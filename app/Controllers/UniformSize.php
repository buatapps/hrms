<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UniformSize extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Uniform Size',
            'list_data' => $this->UniformSizeModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('uniform_size/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Uniform Size',
            'validation'    => $validation
        ];
        return view('uniform_size/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[uniform_size.name]'
        ])) {
            return redirect()->to('uniform_size/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->UniformSizeModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('uniform_size'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Uniform Size',
                'list_data' => $this->UniformSizeModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('uniform_size/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->UniformSizeModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[uniform_size.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('uniform_size/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->UniformSizeModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('uniform_size'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->UniformSizeModel->delete($id);
        return redirect()->to(base_url('uniform_size'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
