<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AttendanceMachine extends BaseController
{
    public function index()
    {

        $data = [
            'title'     => 'Attendance Machine',
            'list_data' => $this->AttendanceMachineModel->orderBy('id', 'DESC')->findAll()

        ];

        return view('attendance_machine/index', $data);
    }

    public function add()
    {

        $validation = \Config\Services::validation();
        $data = [
            'title'         => 'Add Attendance Machine',
            'validation'    => $validation
        ];
        return view('attendance_machine/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'name'      => 'required|is_unique[attendance_machine.name]',
            'ip'      => 'required|is_unique[attendance_machine.ip]'
        ])) {
            return redirect()->to('attendance_machine/add')->withInput();
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->AttendanceMachineModel->save([
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $slug,
            'ip'        => $this->request->getVar('ip'),
            'key'       => $this->request->getVar('key')
        ]);

        return redirect()->to(base_url('attendance_machine'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($slug)
    {
        $validation =
            $data = [
                'title'     => 'Edit Attendance Machine',
                'list_data' => $this->AttendanceMachineModel->where(['slug' => $slug])->first(),
                'validation'    => \Config\Services::validation()
            ];


        return view('attendance_machine/edit', $data);
    }

    public function update($id)
    {
        $slug = $this->request->getVar('slug');
        $old_data = $this->AttendanceMachineModel->where(['slug' => $slug])->first();

        if ($old_data->name == $this->request->getVar('name')) {
            $rule_name = 'required';
        } else {
            $rule_name = 'required|is_unique[attendance_machine.name]';
        }

        if ($old_data->ip == $this->request->getVar('ip')) {
            $rule_ip = 'required';
        } else {
            $rule_ip = 'required|is_unique[attendance_machine.ip]';
        }

        if (!$this->validate([
            'name'      => $rule_name,
            'ip'        => $rule_ip
        ])) {
            return redirect()->to('attendance_machine/edit/' . $slug)->withInput();
        }

        $newslug = url_title($this->request->getVar('name'), '-', true);
        $this->AttendanceMachineModel->save([
            'id'        => $id,
            'name'      => esc($this->request->getVar('name')),
            'slug'      => $newslug,
            'ip'        => $this->request->getVar('ip'),
            'key'       => $this->request->getVar('key')
        ]);

        return redirect()->to(base_url('attendance_machine'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->AttendanceMachineModel->delete($id);
        return redirect()->to(base_url('attendance_machine'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
