<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TaxStatus extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Tax Status',
            'list_data' => $this->TaxStatusModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('tax_status/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Tax Status',
            'validation'    => $validation
        ];
        return view('tax_status/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[tax_status.name]'
        ])) {
            return redirect()->to('tax_status/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->TaxStatusModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('tax_status'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Tax Status',
                'list_data' => $this->TaxStatusModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('tax_status/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->TaxStatusModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[tax_status.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('tax_status/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->TaxStatusModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('tax_status'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->TaxStatusModel->delete($id);
        return redirect()->to(base_url('tax_status'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
