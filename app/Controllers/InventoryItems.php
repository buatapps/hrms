<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryItems extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Inventory Items',
            'list_data' => $this->InventoryItemsModel->findAll(),
        ];
        return view('inventory_items/index', $data);
    }

    public function add()
    {
        $data = [
            'title'     => 'Add Inventory Items',
            'category'  => $this->InventoryCategoryModel->findAll()
        ];
        return view('inventory_items/add', $data);
    }

    public function save()
    {
        $categoryId = $this->request->getPost('category_id');
        $category   = $this->InventoryCategoryModel->find($categoryId);
        $prefix     = $category->code ?? 'ITEM';

        $prefixWithDash = $prefix . '-';

        $lastCode = $this->InventoryItemsModel
            ->like('code', $prefixWithDash, 'after')
            ->orderBy('code', 'DESC')
            ->first();

        if ($lastCode) {
            // Ambil angka di akhir (misal: ATK007 → ambil 7)
            $number = (int) substr($lastCode->code, strlen($prefixWithDash));
            $newNumber = $number + 1;
        } else {
            $newNumber = 1;
        }

        $newCode = $prefixWithDash . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $this->InventoryItemsModel->save([
            'category_id'       => $categoryId,
            'name'              => $this->request->getPost('name'),
            'code'              => $newCode,
            'description'       => $this->request->getPost('description'),
            'stock'             => 0,
            'stock_broken'      => 0,
            'stock_lost'        => 0,
        ]);

        return redirect()->to(base_url('inventory_items'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Add Inventory Items',
            'category'  => $this->InventoryCategoryModel->findAll(),
            'list_data' => $this->InventoryItemsModel->where(['id' => $id])->first()
        ];
        return view('inventory_items/edit', $data);
    }

    public function update()
    {
        // Ambil data lama item
        $itemId    = $this->request->getPost('id');
        $oldItem   = $this->InventoryItemsModel->where(['id' => $itemId])->first();

        // Ambil kategori baru
        $newCategoryId = $this->request->getPost('category_id');
        $newCategory   = $this->InventoryCategoryModel->find($newCategoryId);
        $newPrefix     = $newCategory->code ?? 'ITEM';

        // Default: pakai kode lama
        $newCode = $oldItem->code;

        // Kalau kategori berubah, generate ulang kode
        if ($oldItem->category_id != $newCategoryId) {
            $prefixWithDash = $newPrefix . '-';

            $lastCode = $this->InventoryItemsModel
                ->like('code', $prefixWithDash, 'after')
                ->orderBy('code', 'DESC')
                ->first();

            if ($lastCode) {
                $lastNumber = (int) substr($lastCode->code, strlen($prefixWithDash));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $newCode = $newPrefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }

        $this->InventoryItemsModel->save([
            'id'                => $itemId,
            'category_id'       => $newCategoryId,
            'name'              => $this->request->getPost('name'),
            'code'              => $newCode,
            'description'       => $this->request->getPost('description')
        ]);

        return redirect()->to(base_url('inventory_items'))->with('success', 'data <strong>update</strong> successfully');
    }

    function delete($id)
    {
        $this->InventoryItemsModel->delete($id);
        return redirect()->to(base_url('inventory_items'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
