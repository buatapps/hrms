<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Bank extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Bank',
            'list_data' => $this->BankModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('bank/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Bank',
            'validation'    => $validation
        ];
        return view('bank/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[bank.name]'
        ])) {
            return redirect()->to('bank/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->BankModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('bank'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Bank',
                'list_data' => $this->BankModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('bank/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->BankModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[bank.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('bank/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->BankModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('bank'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->BankModel->delete($id);
        return redirect()->to(base_url('bank'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
