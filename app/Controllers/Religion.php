<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Religion extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Religion',
            'list_data' => $this->ReligionModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('religion/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Religion',
            'validation'    => $validation
        ];
        return view('religion/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[religion.name]'
        ])) {
            return redirect()->to('religion/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->ReligionModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('religion'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Religion',
                'list_data' => $this->ReligionModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('religion/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->ReligionModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[religion.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('religion/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->ReligionModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('religion'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->ReligionModel->delete($id);
        return redirect()->to(base_url('religion'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
