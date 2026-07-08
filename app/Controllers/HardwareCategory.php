<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HardwareCategory extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Hardware Category',
            'list_data' => $this->HardwareCategoryModel->orderBy('id', 'ASC')->findAll()

        ];

        return view('hardware_category/index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Hardware Category',
            'validation'    => $validation
        ];
        return view('hardware_category/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[hardware_category.name]'
        ])) {
            return redirect()->to('hardware_category/add')->withInput();
        }

        $this->HardwareCategoryModel->save([
            'name'      => esc($this->request->getVar('name')),
            'prefix'      => $this->request->getVar('prefix'),
            'description'      => $this->request->getVar('description'),
        ]);

        return redirect()->to(base_url('hardware_category'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {

        $data = [
            'title'     => 'Edit Hardware Category',
            'list_data' => $this->HardwareCategoryModel->where(['id' => $id])->first(),
        ];


        return view('hardware_category/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[hardware_category.name]'
        ])) {
            return redirect()->to('hardware_category/add')->withInput();
        }

        $this->HardwareCategoryModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'prefix'      => $this->request->getVar('prefix'),
            'description'      => $this->request->getVar('description'),
        ]);

        return redirect()->to(base_url('hardware_category'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->HardwareCategoryModel->delete($id);
        return redirect()->to(base_url('hardware_category'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
