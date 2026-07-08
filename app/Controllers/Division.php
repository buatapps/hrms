<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Division extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Division',
            'list_data' => $this->DivisionModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('division/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add division',
            'validation'    => $validation
        ];
        return view('division/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[division.name]'
        ])) {
            return redirect()->to('division/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->DivisionModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('division'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Division',
                'list_data' => $this->DivisionModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('division/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->DivisionModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[division.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('Division/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->DivisionModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('division'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->DivisionModel->delete($id);
        return redirect()->to(base_url('division'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
