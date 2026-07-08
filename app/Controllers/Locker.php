<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Locker extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Locker',
            'list_data' => $this->LockerModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('locker/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Locker',
            'validation'    => $validation
        ];
        return view('locker/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'locker_code'      => 'required|is_unique[locker.locker_code]'
        ])) {
            return redirect()->to('locker/add')->withInput();
        }
        $this->LockerModel->save([
            'locker_code'      => esc($this->request->getVar('locker_code')),
            'key_number'      => esc($this->request->getVar('key_number')),
            'location'      => esc($this->request->getVar('location')),
            'remark'      => esc($this->request->getVar('remark')),
            'is_active'      => 'active',
        ]);

        return redirect()->to(base_url('locker'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $validation =
            $data = [
                'title'     => 'Edit Locker',
                'list_data' => $this->LockerModel->where(['id' => $id])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('locker/edit', $data);
    }

    public function update($id)
    {
        $locker_code = $this->request->getVar('locker_code');
        $key_number = $this->request->getVar('key_number');
        $location = $this->request->getVar('location');
        $remark = $this->request->getVar('remark');
        $is_active = $this->request->getVar('is_active');
        $old_data = $this->LockerModel->where(['id' => $id])->first();

        if ($old_data->locker_code == $this->request->getVar('locker_code')) {
            $rule_locker_code = 'required';
        } else {
            $rule_locker_code = 'required|is_unique[locker.locker_code]';
        }

        if (!$this->validate([
            'locker_code'      => $rule_locker_code
        ])) {
            return redirect()->to('locker/edit/' . $id)->withInput();
        }

        $this->LockerModel->save([
            'id'        => $id,
            'locker_code'      => $locker_code,
            'key_number'      => $key_number,
            'location'      => $location,
            'remark'      => $remark,
            'is_active'      => $is_active,
        ]);

        return redirect()->to(base_url('locker'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->LockerModel->delete($id);
        return redirect()->to(base_url('locker'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
