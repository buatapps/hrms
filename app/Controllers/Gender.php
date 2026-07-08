<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Gender extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Gender',
            'list_data' => $this->GenderModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('gender/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Gender',
            'validation'    => $validation
        ];
        return view('gender/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[gender.name]'
        ])) {
            return redirect()->to('gender/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->GenderModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('gender'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Gender',
                'list_data' => $this->GenderModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('gender/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->GenderModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[gender.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('gender/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->GenderModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('gender'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->GenderModel->delete($id);
        return redirect()->to(base_url('gender'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
