<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryTransactionsOut extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => "Inventory Transactions Out",
            'list_data' => $this->InventoryTransactionsOutModel->withRelations()->findAll()
        ];

        return view('inventory_out/index', $data);
    }

    public function add()
    {
        $data = [
            'title'     => "Add Inventory Transaction Out",
            'items'     => $this->InventoryItemsModel->findAll(),
            'types'     => $this->InventoryTransactionOutTypeModel->findAll(),
        ];

        return view('inventory_out/add', $data);
    }

    public function save()
    {
        $tanggal = $this->request->getPost('tanggal');
        $item_id = $this->request->getPost('item_id');
        $type_id = $this->request->getPost('type_id');
        $quantity = $this->request->getPost('quantity');
        $keterangan = $this->request->getPost('keterangan');

        // Cek snapshot bulan sebelumnya
        $currentDate = new \DateTime($tanggal);
        $currentDate->modify('-1 month');
        $previousYM = $currentDate->format('Y-m');

        $snapshotSebelumnya = $this->InventorySnapshotModel
            ->where('item_id', $item_id)
            ->where('year_month', $previousYM)
            ->first();

        if ($snapshotSebelumnya && $snapshotSebelumnya->status !== 'closed') {
            return redirect()->back()->with('error', 'Transaksi gagal karena snapshot bulan sebelumnya belum <strong>ditutup</strong>.');
        }

        $currentStock = $this->InventoryItemsModel->find($item_id)->stock;

        if ($currentStock < $quantity) {
            return redirect()->back()->withInput()->with('error', 'Stok tidak mencukupi untuk transaksi ini.');
        }

        $this->InventoryTransactionsOutModel->save([
            'tanggal'   => $tanggal,
            'item_id'   => $item_id,
            'type_id'   => $type_id,
            'quantity'   => $quantity,
            'keterangan'   => $keterangan,
        ]);

        //update inventory stock
        updateStockOut(
            $item_id,
            $type_id,
            $quantity,
            $tanggal,
            $this->InventoryItemsModel,
            $this->InventorySnapshotModel,
            $this->InventoryTransactionOutTypeModel
        );

        return redirect()->to(base_url('inventory_out'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => "Edit Inventory Transaction Out",
            'list_data' => $this->InventoryTransactionsOutModel->where(['id' => $id])->first(),
            'items'     => $this->InventoryItemsModel->findAll(),
            'types'     => $this->InventoryTransactionOutTypeModel->findAll()
        ];

        return view('inventory_out/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $tanggal = $this->request->getPost('tanggal');
        $item_id = $this->request->getPost('item_id');
        $type_id = $this->request->getPost('type_id');
        $quantity = $this->request->getPost('quantity');
        $keterangan = $this->request->getPost('keterangan');

        $old = $this->InventoryTransactionsOutModel->find($id);
        if (!$old) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        $data = [
            'tanggal'   => $tanggal,
            'item_id'   => $item_id,
            'type_id'   => $type_id,
            'quantity'   => $quantity,
            'keterangan'   => $keterangan,
        ];

        $this->InventoryTransactionsOutModel->update($id, $data);

        updateStockOutOnUpdate(
            $old->item_id,
            $old->type_id,
            $old->quantity,
            $old->tanggal,
            $item_id,
            $type_id,
            $quantity,
            $tanggal,
            $this->InventoryItemsModel,
            $this->InventorySnapshotModel,
            $this->InventoryTransactionOutTypeModel
        );

        return redirect()->to(base_url('inventory_out'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        // Ambil data transaksi sebelum dihapus
        $transaksi = $this->InventoryTransactionsOutModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Rollback stok
        rollbackStockOutOnDelete(
            $transaksi->item_id,
            $transaksi->type_id,
            $transaksi->quantity,
            $transaksi->tanggal,
            $this->InventoryItemsModel,
            $this->InventorySnapshotModel,
            $this->InventoryTransactionOutTypeModel
        );

        // Hapus data
        $this->InventoryTransactionsOutModel->delete($id);

        return redirect()->to(base_url('inventory_out'))->with('success', 'data <strong>dihapus</strong> successfully');
    }
}
