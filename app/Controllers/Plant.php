<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Plant extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Marriage Status',
            'list_data' => $this->PlantModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('plant/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Plant',
            'validation'    => $validation
        ];
        return view('plant/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[plant.name]'
        ])) {
            return redirect()->to('plant/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->PlantModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('plant'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Plant',
                'list_data' => $this->PlantModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('plant/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->PlantModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[plant.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('plant/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->PlantModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('plant'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->PlantModel->delete($id);
        return redirect()->to(base_url('plant'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
