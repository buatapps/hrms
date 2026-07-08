<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryStockOpname extends BaseController
{
    public function index()
    {
        $listData = $this->InventoryStockOpnameHeaderModel
            ->select('inventory_stock_opname_headers.*, users.username as created_by_name')
            ->join('users', 'users.id = inventory_stock_opname_headers.created_by', 'left')
            ->findAll();
        $data = [
            'title'     => 'Inventory Stock Opname',
            'list_data' => $listData
        ];

        return view('inventory_stock_opname/index', $data);
    }

    public function add()
    {
        $yearMonth = date('Y-m');

        // Cek apakah sudah ada header untuk bulan ini
        $existing = $this->InventoryStockOpnameHeaderModel
            ->where('year_month', $yearMonth)
            ->first();

        if ($existing) {
            // Langsung redirect ke edit jika sudah ada
            return redirect()->to(base_url('inventory_stock_opname/edit/' . $existing->id));
        }

        // Insert header baru
        $newId = $this->InventoryStockOpnameHeaderModel->insert([
            'year_month' => $yearMonth,
            'created_by' => user_id(), // asumsikan ada fungsi user_id()
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Redirect ke edit halaman isian
        return redirect()->to(base_url('inventory_stock_opname/edit/' . $newId));
    }

    public function edit($headerId)
    {
        // Ambil header
        $header = $this->InventoryStockOpnameHeaderModel->find($headerId);
        if (!$header) {
            return redirect()->to(base_url('inventory_stock_opname'))
                ->with('error', 'Data stock opname tidak ditemukan.');
        }

        // Ambil semua item
        $items = $this->InventoryItemsModel->findAll();

        // Ambil data stock opname untuk header ini
        $opnameData = $this->InventoryStockOpnameModel
            ->where('header_id', $headerId)
            ->findAll();

        // Indexkan opname data biar gampang dicocokin per item_id
        $opnameByItem = [];
        foreach ($opnameData as $opname) {
            $opnameByItem[$opname->item_id] = $opname;
        }

        $snapshots = [];
        foreach ($items as $item) {
            $snapshots[$item->id] = $this->InventorySnapshotModel
                ->where('item_id', $item->id)
                ->where('year_month', $header->year_month)
                ->first(); // hasilnya object atau null
        }

        $data = [
            'title' => 'Edit Stock Opname Bulan ' . $header->year_month,
            'header' => $header,
            'snapshots' => $snapshots,
            'items' => $items,
            'opnameByItem' => $opnameByItem,
        ];

        return view('inventory_stock_opname/edit', $data);
    }

    public function save($headerId)
    {
        $stockOpname = $this->request->getPost('stock_opname');
        $keterangan  = $this->request->getPost('keterangan');

        $header = $this->InventoryStockOpnameHeaderModel->find($headerId);
        if (!$header) {
            return redirect()->back()->with('error', 'Header tidak ditemukan');
        }

        $yearMonth = $header->year_month;

        foreach ($stockOpname as $itemId => $opnameValue) {
            // Ambil snapshot
            $snapshot = $this->InventorySnapshotModel
                ->where('item_id', $itemId)
                ->where('year_month', $yearMonth)
                ->first();

            // Ambil nilai final_stock untuk referensi hitung selisih
            // Gunakan stock_akhir karena itu nilai awal bulan (fixed)
            if ($snapshot) {
                $stockAwal = $snapshot->stock_akhir;
            } else {
                // Fallback ke stock item
                $item = $this->InventoryItemsModel->find($itemId);
                if (!$item) {
                    continue;
                }
                $stockAwal = $item->stock;
            }

            $selisih = $opnameValue - $stockAwal;

            // Cek apakah sudah ada entri opname sebelumnya
            $existing = $this->InventoryStockOpnameModel
                ->where('header_id', $headerId)
                ->where('item_id', $itemId)
                ->first();

            $data = [
                'header_id'     => $headerId,
                'item_id'       => $itemId,
                'stock_akhir'   => $stockAwal,
                'stock_opname'  => $opnameValue,
                'selisih'       => $selisih,
                'keterangan'    => $keterangan[$itemId] ?? null,
            ];

            if ($existing) {
                $this->InventoryStockOpnameModel->update($existing->id, $data);
            } else {
                $this->InventoryStockOpnameModel->insert($data);
            }

            // Update snapshot
            if ($snapshot) {
                $this->InventorySnapshotModel->update($snapshot->id, [
                    'stock_opname' => $opnameValue,
                    'final_stock'  => $opnameValue,
                    'status'       => 'closed',
                ]);
            } else {
                $this->InventorySnapshotModel->insert([
                    'item_id'       => $itemId,
                    'year_month'    => $yearMonth,
                    'stock_akhir'   => $stockAwal, // simpan juga stock awal
                    'final_stock'   => $opnameValue, // optional, jika masih pakai
                    'stock_opname'  => $opnameValue,
                    'stock_in'      => 0,
                    'stock_out'     => 0,
                    'stock_broken'  => 0,
                    'stock_lost'    => 0,
                    'status'        => 'closed',
                ]);
            }

            // Update master item
            $this->InventoryItemsModel->update($itemId, [
                'stock' => $opnameValue,
            ]);
        }

        return redirect()->to(base_url('inventory_stock_opname'))->with('success', 'Data <strong>saved</strong> successfully');
    }

    public function delete($headerId)
    {
        // Ambil semua detail item dari header ini
        $opnames = $this->InventoryStockOpnameModel->where('header_id', $headerId)->findAll();

        // Ambil data header untuk dapatkan year_month
        $header = $this->InventoryStockOpnameHeaderModel->find($headerId);
        if (!$header) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $yearMonth = $header->year_month;

        foreach ($opnames as $op) {
            // Reset snapshot
            $snapshot = $this->InventorySnapshotModel
                ->where('item_id', $op->item_id)
                ->where('year_month', $yearMonth)
                ->first();

            if ($snapshot) {
                $this->InventorySnapshotModel->update($snapshot->id, [
                    'stock_opname' => null,
                    'status'       => 'open', // balikin jadi open biar bisa input ulang
                ]);
            }

            // (Opsional) rollback stock master item ke stock_akhir
            $item = $this->InventoryItemsModel->find($op->item_id);
            if ($item && $snapshot && $snapshot->stock_akhir !== null) {
                $this->InventoryItemsModel->update($op->item_id, [
                    'stock' => $snapshot->stock_akhir,
                ]);
            }
        }

        // Hapus detail opname
        $this->InventoryStockOpnameModel->where('header_id', $headerId)->delete();

        // Hapus header
        $this->InventoryStockOpnameHeaderModel->delete($headerId);

        return redirect()->to(base_url('inventory_stock_opname'))->with('success', 'Data <strong>dihapus</strong> dengan sukses');
    }

    public function details($headerId)
    {
        $listData = $this->InventoryStockOpnameModel
            ->select('inventory_stock_opname.*, inventory_items.name as item_name, inventory_items.code as item_code')
            ->join('inventory_items', 'inventory_items.id = inventory_stock_opname.item_id', 'left')
            ->where('inventory_stock_opname.header_id', $headerId)
            ->findAll();

        $data = [
            'title'     => 'Inventory Stock Opname',
            'list_data' => $listData,
            'headerId'  => $headerId
        ];

        return view('inventory_stock_opname/details', $data);
    }

    public function print($headerId)
    {
        $header = $this->InventoryStockOpnameHeaderModel
            ->select('inventory_stock_opname_headers.*, users.username as created_by_name')
            ->join('users', 'users.id = inventory_stock_opname_headers.created_by', 'left')
            ->find($headerId);

        $listData = $this->InventoryStockOpnameModel
            ->select('inventory_stock_opname.*, inventory_items.name as item_name, inventory_items.code as item_code')
            ->join('inventory_items', 'inventory_items.id = inventory_stock_opname.item_id', 'left')
            ->where('inventory_stock_opname.header_id', $headerId)
            ->findAll();

        $data = [
            'header'     => $header,
            'list_data'  => $listData,
        ];

        return view('inventory_stock_opname/print', $data);
    }

    public function print_empty()
    {
        // Ambil year_month terbaru dari snapshot
        $latestSnapshot = $this->InventorySnapshotModel
            ->select('year_month')
            ->orderBy('year_month', 'desc')
            ->first();
        if (!$latestSnapshot) {
            return redirect()->back()->with('error', 'Belum ada data snapshot.');
        }

        $yearMonth = $latestSnapshot->year_month;

        // Ambil semua snapshot di bulan tersebut
        $snapshots = $this->InventorySnapshotModel
            ->select('inventory_snapshots.*, inventory_items.name, inventory_items.code')
            ->join('inventory_items', 'inventory_items.id = inventory_snapshots.item_id')
            ->where('inventory_snapshots.year_month', $yearMonth)
            ->orderBy('inventory_items.name', 'asc')
            ->findAll();

        $data = [
            'title'  => 'Print Kosong Stock Opname',
            'items'  => $snapshots,
            'yearMonth' => $yearMonth
        ];

        return view('inventory_stock_opname/print_empty', $data);
    }
}
