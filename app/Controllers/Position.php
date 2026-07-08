<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Position extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Position',
            'list_data' => $this->PositionModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('position/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Position',
            'validation'    => $validation
        ];
        return view('position/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[position.name]'
        ])) {
            return redirect()->to('position/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->PositionModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug
        ]);

        return redirect()->to(base_url('position'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {

        $data = [
            'title'     => 'Edit Position',
            'list_data' => $this->PositionModel->where(['slug' => $slug])->first(),
        ];


        return view('position/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->PositionModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[position.name]';
        }

        if (!$this->validate([
            'name'      => $rule_name
        ])) {
            return redirect()->to('position/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->PositionModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug
        ]);

        return redirect()->to(base_url('position'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->PositionModel->delete($id);
        return redirect()->to(base_url('position'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
