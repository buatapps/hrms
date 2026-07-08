<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MarriageStatus extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Marriage Status',
            'list_data' => $this->MarriageStatusModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('marriage_status/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Marriage Status',
            'validation'    => $validation
        ];
        return view('marriage_status/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[marriage_status.name]'
        ])) {
            return redirect()->to('marriage_status/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->MarriageStatusModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('marriage_status'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Marriage Status',
                'list_data' => $this->MarriageStatusModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('marriage_status/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->MarriageStatusModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[marriage_status.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('marriage_status/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->MarriageStatusModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('marriage_status'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->MarriageStatusModel->delete($id);
        return redirect()->to(base_url('marriage_status'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
