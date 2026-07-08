<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ShoesSize extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Shoes Size',
            'list_data' => $this->ShoesSizeModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('shoes_size/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Shoes Size',
            'validation'    => $validation
        ];
        return view('shoes_size/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[shoes_size.name]'
        ])) {
            return redirect()->to('shoes_size/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->ShoesSizeModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('shoes_size'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Shoes Size',
                'list_data' => $this->ShoesSizeModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('shoes_size/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->ShoesSizeModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[shoes_size.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('shoes_size/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->ShoesSizeModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('shoes_size'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->ShoesSizeModel->delete($id);
        return redirect()->to(base_url('shoes_size'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
