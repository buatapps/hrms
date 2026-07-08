<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyModel;
use CodeIgniter\HTTP\ResponseInterface;


class Company extends BaseController
{

    public function index()
    {

        $data = [
            'title'     => 'Company',
            'list_data' => $this->CompanyModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('company/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Company',
            'validation'    => $validation
        ];
        return view('company/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[company.name]'
        ])) {
            return redirect()->to('company/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->CompanyModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('company'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Company',
                'list_data' => $this->CompanyModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('company/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->CompanyModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[company.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('company/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->CompanyModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('company'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->CompanyModel->delete($id);
        return redirect()->to(base_url('company'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
