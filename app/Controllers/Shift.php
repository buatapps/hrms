<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Shift extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Shift',
            'list_data' => $this->ShiftModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('shift/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Shift',
            'validation'    => $validation
        ];
        return view('shift/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[shift.name]'
        ])) {
            return redirect()->to('shift/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->ShiftModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('shift'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Shift',
                'list_data' => $this->ShiftModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('shift/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->ShiftModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[shift.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('shift/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->ShiftModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('shift'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->ShiftModel->delete($id);
        return redirect()->to(base_url('shift'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
