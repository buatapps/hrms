<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AbsentType extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Absent Type',
            'list_data' => $this->AbsentTypeModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('absent_type/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Absent Type',
            'validation'    => $validation
        ];
        return view('absent_type/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[absent_type.name]'
        ])) {
            return redirect()->to('absent_type/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->AbsentTypeModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('absent_type'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Absent Type',
                'list_data' => $this->AbsentTypeModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('absent_type/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->AbsentTypeModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[absent_type.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('absent_type/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->AbsentTypeModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('absent_type'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->AbsentTypeModel->delete($id);
        return redirect()->to(base_url('absent_type'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
