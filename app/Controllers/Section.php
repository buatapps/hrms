<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Section extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Section',
            'list_data' => $this->SectionModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('section/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Section',
            'validation'    => $validation
        ];
        return view('section/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[section.name]'
        ])) {
            return redirect()->to('section/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->SectionModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('section'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Section',
                'list_data' => $this->SectionModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('section/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->SectionModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[section.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('section/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->SectionModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('section'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->SectionModel->delete($id);
        return redirect()->to(base_url('section'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
