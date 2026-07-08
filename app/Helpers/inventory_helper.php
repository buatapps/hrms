<?php

function updateStockIn($item_id, $quantity, $tanggal, $InventoryItemsModel, $InventorySnapshotModel)
{
    // Update inventory_items stock
    $item = $InventoryItemsModel->find($item_id);
    $new_stock = $item->stock + $quantity;
    $InventoryItemsModel->update($item_id, ['stock' => $new_stock]);

    // Format year_month
    $yearMonth = date('Y-m', strtotime($tanggal));

    // Cari snapshot yang masih open
    $snapshot = $InventorySnapshotModel
        ->where('item_id', $item_id)
        ->where('year_month', $yearMonth)
        ->where('status', 'open')
        ->first();

    if ($snapshot) {
        // Update snapshot yang ada
        $InventorySnapshotModel->update($snapshot->id, [
            'stock_in'    => $snapshot->stock_in + $quantity,
            'stock_akhir' => $snapshot->stock_akhir + $quantity,
            'final_stock' => $snapshot->final_stock + $quantity,
        ]);
    } else {
        // Buat snapshot baru
        $InventorySnapshotModel->save([
            'item_id'      => $item_id,
            'year_month'   => $yearMonth,
            'stock_awal'   => $item->stock,
            'stock_in'     => $quantity,
            'stock_out'    => 0,
            'stock_broken' => 0,
            'stock_lost'   => 0,
            'stock_akhir'  => $new_stock,
            'stock_opname' => null,
            'final_stock'  => $new_stock,
            'status'       => 'open',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}

function adjustStockIn($item_id, $old_qty, $new_qty, $tanggal, $InventoryItemsModel, $InventorySnapshotModel)
{
    $selisih = $new_qty - $old_qty;

    // Update stock item
    $item = $InventoryItemsModel->find($item_id);
    $new_stock = $item->stock + $selisih;
    $InventoryItemsModel->update($item_id, ['stock' => $new_stock]);

    // Update snapshot
    $yearMonth = date('Y-m', strtotime($tanggal));
    $snapshot = $InventorySnapshotModel
        ->where('item_id', $item_id)
        ->where('year_month', $yearMonth)
        ->where('status', 'open')
        ->first();

    if ($snapshot) {
        $InventorySnapshotModel->update($snapshot->id, [
            'stock_in'    => $snapshot->stock_in + $selisih,
            'stock_akhir' => $snapshot->stock_akhir + $selisih,
            'final_stock' => $snapshot->final_stock + $selisih,
        ]);
    }
}

function rollbackStockIn($item_id, $quantity, $tanggal, $InventoryItemsModel, $InventorySnapshotModel)
{
    // Kurangi stock item
    $item = $InventoryItemsModel->find($item_id);
    $new_stock = $item->stock - $quantity;
    $InventoryItemsModel->update($item_id, ['stock' => $new_stock]);

    // Update snapshot
    $yearMonth = date('Y-m', strtotime($tanggal));
    $snapshot = $InventorySnapshotModel
        ->where('item_id', $item_id)
        ->where('year_month', $yearMonth)
        ->where('status', 'open')
        ->first();

    if ($snapshot) {
        $InventorySnapshotModel->update($snapshot->id, [
            'stock_in'    => $snapshot->stock_in - $quantity,
            'stock_akhir' => $snapshot->stock_akhir - $quantity,
            'final_stock' => $snapshot->final_stock - $quantity,
        ]);
    }
}

function updateStockOut($item_id, $type_id, $quantity, $tanggal, $itemsModel, $snapshotModel, $typeModel)
{
    $yearMonth = date('Y-m', strtotime($tanggal));
    $snapshot = $snapshotModel
        ->where('item_id', $item_id)
        ->where('year_month', $yearMonth)
        ->first();

    if (!$snapshot) {
        throw new \Exception("Snapshot belum tersedia untuk item ini di bulan tersebut.");
    }

    if ($snapshot->status == 'closed') {
        throw new \Exception("Transaksi tidak bisa dilakukan karena snapshot bulan ini sudah ditutup.");
    }

    $type = $typeModel->find($type_id);

    if (!$type || !$type->impact_column) {
        throw new \Exception("Tipe transaksi tidak valid atau belum punya impact_column.");
    }

    $impactField = $type->impact_column;

    if (!property_exists($snapshot, $impactField)) {
        throw new \Exception("Kolom '{$impactField}' tidak ditemukan di tabel snapshot.");
    }

    if ($snapshot->stock_akhir < $quantity) {
        throw new \Exception("Stok tidak mencukupi untuk transaksi ini.");
    }

    // Update snapshot
    $updateData = [
        $impactField     => $snapshot->{$impactField} + $quantity,
        'stock_akhir'    => $snapshot->stock_akhir - $quantity,
        'final_stock'    => $snapshot->final_stock - $quantity,
    ];
    $snapshotModel->update($snapshot->id, $updateData);

    // Update inventory_items
    $item = $itemsModel->find($item_id);
    $itemsModel->update($item_id, [
        'stock' => $item->stock - $quantity
    ]);
}

function updateStockOutOnUpdate(
    $oldItemId,
    $oldTypeId,
    $oldQuantity,
    $oldTanggal,
    $newItemId,
    $newTypeId,
    $newQuantity,
    $newTanggal,
    $itemModel,
    $snapshotModel,
    $typeModel
) {
    // === Rollback Transaksi Lama ===
    $oldYM = (new DateTime($oldTanggal))->format('Y-m');
    $oldField = 'stock_' . $typeModel->find($oldTypeId)->code;

    $oldSnapshot = $snapshotModel
        ->where('item_id', $oldItemId)
        ->where('year_month', $oldYM)
        ->first();

    if ($oldSnapshot && isset($oldSnapshot->$oldField)) {
        $updatedOld = [
            'id' => $oldSnapshot->id,
            $oldField => $oldSnapshot->$oldField - $oldQuantity,
            'final_stock' => $oldSnapshot->final_stock + $oldQuantity,
        ];
        $snapshotModel->update($oldSnapshot->id, $updatedOld);
    }

    $oldItem = $itemModel->find($oldItemId);
    if ($oldItem) {
        $itemModel->update($oldItemId, [
            'stock' => $oldItem->stock + $oldQuantity
        ]);
    }

    // === Apply Transaksi Baru ===
    $newYM = (new DateTime($newTanggal))->format('Y-m');
    $newField = 'stock_' . $typeModel->find($newTypeId)->code;

    $newSnapshot = $snapshotModel
        ->where('item_id', $newItemId)
        ->where('year_month', $newYM)
        ->first();

    if ($newSnapshot && isset($newSnapshot->$newField)) {
        $updatedNew = [
            'id' => $newSnapshot->id,
            $newField => $newSnapshot->$newField + $newQuantity,
            'final_stock' => $newSnapshot->final_stock - $newQuantity,
        ];
        $snapshotModel->update($newSnapshot->id, $updatedNew);
    }

    $newItem = $itemModel->find($newItemId);
    if ($newItem) {
        $itemModel->update($newItemId, [
            'stock' => $newItem->stock - $newQuantity
        ]);
    }
}

function rollbackStockOutOnDelete(
    $itemId,
    $typeId,
    $quantity,
    $tanggal,
    $itemModel,
    $snapshotModel,
    $typeModel
) {
    $yearMonth = date('Y-m', strtotime($tanggal));
    $type = $typeModel->find($typeId);
    $field = 'stock_' . $type->code;

    // Update snapshot
    $snapshot = $snapshotModel
        ->where('item_id', $itemId)
        ->where('year_month', $yearMonth)
        ->first();

    if ($snapshot && isset($snapshot->$field)) {
        $snapshotModel->update($snapshot->id, [
            $field => $snapshot->$field - $quantity,
            'final_stock' => $snapshot->final_stock + $quantity,
        ]);
    }

    // Update item stock
    $item = $itemModel->find($itemId);
    if ($item) {
        $itemModel->update($itemId, [
            'stock' => $item->stock + $quantity,
        ]);
    }
}
