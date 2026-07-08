<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryCategories extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Inventory Category',
            'list_data' => $this->InventoryCategoryModel->findAll()
        ];
        return view('inventory_category/index', $data);
    }

    public function add()
    {
        $data = [
            'title'     => 'Add Inventory Category'
        ];
        return view('inventory_category/add', $data);
    }

    public function save()
    {
        $name = $this->request->getVar('name');
        $code = $this->request->getVar('code');
        $description = $this->request->getVar('description');

        $this->InventoryCategoryModel->save([
            'name'      => $name,
            'code'      => $code,
            'description' => $description,
        ]);

        return redirect()->to(base_url('inventory_category'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Edit Inventory Category',
            'list_data' => $this->InventoryCategoryModel->where(['id' => $id])->first()

        ];
        return view('inventory_category/edit', $data);
    }

    public function update($id)
    {
        $name = $this->request->getVar('name');
        $code = $this->request->getVar('code');
        $description = $this->request->getVar('description');

        $this->InventoryCategoryModel->save([
            'id'        => $id,
            'name'      => $name,
            'code'      => $code,
            'description' => $description,
        ]);

        return redirect()->to(base_url('inventory_category'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->InventoryCategoryModel->delete($id);
        return redirect()->to(base_url('inventory_category'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
