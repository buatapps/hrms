<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Education extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Education',
            'list_data' => $this->EducationModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('education/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Education',
            'validation'    => $validation
        ];
        return view('education/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[education.name]'
        ])) {
            return redirect()->to('education/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->EducationModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('education'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Education',
                'list_data' => $this->EducationModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('education/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->EducationModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[education.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('education/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->EducationModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('education'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->EducationModel->delete($id);
        return redirect()->to(base_url('education'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
