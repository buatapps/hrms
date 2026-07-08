<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HardwareBrand extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Hardware Brand',
            'list_data' => $this->HardwareBrandModel->getBrandWithCategory()

        ];

        return view('hardware_brand/index', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Add Hardware Brand',
            'category'      => $this->HardwareCategoryModel->findAll(),
        ];
        return view('hardware_brand/add', $data);
    }

    public function save()
    {
        $this->HardwareBrandModel->save([
            'hardware_category_id'      => $this->request->getVar('hardware_category_id'),
            'name'      => esc($this->request->getVar('name')),
        ]);

        return redirect()->to(base_url('hardware_brand'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {

        $data = [
            'title'     => 'Edit Hardware Brand',
            'list_data' => $this->HardwareBrandModel->where(['id' => $id])->first(),
            'category'  => $this->HardwareCategoryModel->findAll(),
        ];


        return view('hardware_brand/edit', $data);
    }

    public function update($id)
    {
        $this->HardwareBrandModel->save([
            'id'        => $id,
            'hardware_category_id'      => $this->request->getVar('hardware_category_id'),
            'name'      => esc($this->request->getVar('name')),
        ]);

        return redirect()->to(base_url('hardware_brand'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->HardwareBrandModel->delete($id);
        return redirect()->to(base_url('hardware_brand'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
