<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Guest extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Guest',
            'list_data' => $this->GuestModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('guest/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Guest',
            'validation'    => $validation
        ];
        return view('guest/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[guest.name]'
        ])) {
            return redirect()->to('guest/add')->withInput();
        }

        $logo = $this->request->getFile('logo');
        if (! $logo->isValid()) {
            $logoName = null;
        } else {
            $logoName = $logo->getRandomName();
            $logo->move('logo_guest', $logoName);
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->GuestModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug,
            'logo'      => $logoName
        ]);

        return redirect()->to(base_url('guest'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Guest',
                'list_data' => $this->GuestModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('guest/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->GuestModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rules_name = 'required';
        } else {
            $rules_name = 'required|is_unique[guest.name]';
        }

        if (!$this->validate([
            'name'      => $rules_name
        ])) {
            return redirect()->to('guest/edit/' . $slug)->withInput();
        }

        $logo = $this->request->getFile('logo');
        if (! $logo->isValid()) {
            $logoName = $this->request->getVar('oldLogo');
        } else {
            $logoName = $logo->getRandomName();
            $logo->move('logo_guest', $logoName);
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->GuestModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug,
            'logo'      => $logoName
        ]);

        return redirect()->to(base_url('guest'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->GuestModel->delete($id);
        return redirect()->to(base_url('guest'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
