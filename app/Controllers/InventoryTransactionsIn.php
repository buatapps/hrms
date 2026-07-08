<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryTransactionsIn extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => "Inventory Transactions In",
            'list_data' => $this->InventoryTransactionsInModel->withItems()->findAll()
        ];

        return view('inventory_in/index', $data);
    }

    public function add()
    {
        $data = [
            'title'     => "Add Inventory Transaction In",
            'items'     => $this->InventoryItemsModel->findAll()
        ];

        return view('inventory_in/add', $data);
    }

    public function save()
    {
        $tanggal = $this->request->getPost('tanggal');
        $item_id = $this->request->getPost('item_id');
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

        $this->InventoryTransactionsInModel->save([
            'tanggal'   => $tanggal,
            'item_id'   => $item_id,
            'quantity'   => $quantity,
            'keterangan'   => $keterangan,
        ]);

        //update inventory stock
        updateStockIn($item_id, $quantity, $tanggal, $this->InventoryItemsModel, $this->InventorySnapshotModel);

        return redirect()->to(base_url('inventory_in'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => "Edit Inventory Transaction In",
            'list_data' => $this->InventoryTransactionsInModel->where(['id' => $id])->first(),
            'items'     => $this->InventoryItemsModel->findAll()
        ];

        return view('inventory_in/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $tanggal = $this->request->getPost('tanggal');
        $item_id = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');
        $keterangan = $this->request->getPost('keterangan');

        $old = $this->InventoryTransactionsInModel->find($id);

        $data = [
            'tanggal'   => $tanggal,
            'item_id'   => $item_id,
            'quantity'   => $quantity,
            'keterangan'   => $keterangan,
        ];

        $this->InventoryTransactionsInModel->update($id, $data);

        adjustStockIn($item_id, $old->quantity, $quantity, $tanggal, $this->InventoryItemsModel, $this->InventorySnapshotModel);

        return redirect()->to(base_url('inventory_in'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function delete($id)
    {
        $transaksi = $this->InventoryTransactionsInModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Rollback stock
        rollbackStockIn(
            $transaksi->item_id,
            $transaksi->quantity,
            $transaksi->tanggal,
            $this->InventoryItemsModel,
            $this->InventorySnapshotModel
        );

        // Soft delete
        $this->InventoryTransactionsInModel->delete($id);

        return redirect()->to(base_url('inventory_in'))->with('success', 'Data <strong>berhasil</strong> dihapus');
    }
}
