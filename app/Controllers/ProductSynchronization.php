<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductSynchronization extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Product Synchronization',
            'list_data' => $this->ProductSynchronizationModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('product_synchronization/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Product Synchronization',
            'validation'    => $validation
        ];
        return view('product_synchronization/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[product_synchronization.name]'
        ])) {
            return redirect()->to('product_synchronization/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->ProductSynchronizationModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('product_synchronization'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Product Synchronization',
                'list_data' => $this->ProductSynchronizationModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('product_synchronization/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->ProductSynchronizationModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[product_synchronization.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('product_synchronization/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->ProductSynchronizationModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('product_synchronization'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->ProductSynchronizationModel->delete($id);
        return redirect()->to(base_url('product_synchronization'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
