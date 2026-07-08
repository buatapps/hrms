<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthGroups extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Data Auth Groups',
            'list_data' => $this->AuthGroupsModel->orderBy('id', 'DESC')->findAll()
        ];

        return view('auth_groups/index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Auth Groups',
            'validation'    => $validation
        ];
        return view('auth_groups/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[auth_groups.name]'
        ])) {
            return redirect()->to('auth_groups/add')->withInput();
        }

        $this->AuthGroupsModel->save([
            'name'      => esc($this->request->getVar('name')),
            'description'      => $this->request->getVar('description')
        ]);

        return redirect()->to(base_url('auth_groups'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $validation =
            $data = [
                'title'         => 'Edit Auth Groups',
                'list_data'     => $this->AuthGroupsModel->where(['id' => $id])->first(),
                'validation'    => \Config\Services::validation()
            ];

        return view('auth_groups/edit', $data);
    }

    public function update($id)
    {
        $old_data = $this->AuthGroupsModel->where(['id' => $id])->first();
        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[auth_groups.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('auth_groups/edit/' . $id)->withInput();
        }

        $this->AuthGroupsModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'description'      => $this->request->getVar('description')
        ]);

        return redirect()->to(base_url('auth_groups'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->AuthGroupsModel->delete($id);
        return redirect()->to(base_url('auth_groups'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
