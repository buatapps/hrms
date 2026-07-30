<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Sertifikat extends BaseController
{
    public function index()
    {
        $builder = $this->SertifikatModel->db->table('sertifikat');
        $builder->select('sertifikat.*, data_employee.name as employee_name, tipe_sertifikat.tipe_sertifikat as tipe_sertifikat');
        $builder->join('data_employee', 'data_employee.id = sertifikat.employee_id');
        $builder->join('tipe_sertifikat', 'tipe_sertifikat.id = sertifikat.tipe_sertifikat_id');
        $builder->where('sertifikat.deleted_at', null);
        $builder->orderBy('sertifikat.id', 'DESC');

        $data = [
            'title'     => 'Sertifikat',
            'list_data' => $builder->get()->getResultObject()
        ];

        return view('general_affairs/sertifikat/index', $data);
    }

    public function add()
    {
        $data = [
            'title'             => 'Add Sertifikat',
            'employee'          => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'tipe_sertifikat'   => $this->TipeSertifikatModel->orderBy('id', 'DESC')->findAll(),
            'validation'        => \Config\Services::validation()
        ];
        return view('general_affairs/sertifikat/add', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'employee_id'        => 'required',
            'tipe_sertifikat_id' => 'required',
            'masa_berlaku'       => 'required',
        ])) {
            return redirect()->to('general_affairs/sertifikat_add')->withInput();
        }

        $file = $this->request->getFile('file');
        $fileName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('sertifikat', $fileName);
        }

        $this->SertifikatModel->save([
            'employee_id'        => $this->request->getVar('employee_id'),
            'tipe_sertifikat_id' => $this->request->getVar('tipe_sertifikat_id'),
            'masa_berlaku'       => $this->request->getVar('masa_berlaku'),
            'file'               => $fileName,
        ]);

        return redirect()->to(base_url('general_affairs/sertifikat'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'             => 'Edit Sertifikat',
            'list_data'         => $this->SertifikatModel->where(['id' => $id])->first(),
            'employee'          => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'tipe_sertifikat'   => $this->TipeSertifikatModel->orderBy('id', 'DESC')->findAll(),
            'validation'        => \Config\Services::validation()
        ];

        return view('general_affairs/sertifikat/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'employee_id'        => 'required',
            'tipe_sertifikat_id' => 'required',
            'masa_berlaku'       => 'required',
        ])) {
            return redirect()->to('general_affairs/sertifikat_edit/' . $id)->withInput();
        }

        $file = $this->request->getFile('file');
        $oldData = $this->SertifikatModel->where(['id' => $id])->first();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('sertifikat', $fileName);
            if ($oldData && $oldData->file && file_exists('sertifikat/' . $oldData->file)) {
                unlink('sertifikat/' . $oldData->file);
            }
        } else {
            $fileName = $oldData->file ?? null;
        }

        $this->SertifikatModel->save([
            'id'                 => $id,
            'employee_id'        => $this->request->getVar('employee_id'),
            'tipe_sertifikat_id' => $this->request->getVar('tipe_sertifikat_id'),
            'masa_berlaku'       => $this->request->getVar('masa_berlaku'),
            'file'               => $fileName,
        ]);

        return redirect()->to(base_url('general_affairs/sertifikat'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $oldData = $this->SertifikatModel->where(['id' => $id])->first();
        if ($oldData && $oldData->file && file_exists('sertifikat/' . $oldData->file)) {
            unlink('sertifikat/' . $oldData->file);
        }
        $this->SertifikatModel->delete($id);
        return redirect()->to(base_url('general_affairs/sertifikat'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function tipeSertifikatSave()
    {
        $tipe = $this->request->getVar('tipe_sertifikat');
        $this->TipeSertifikatModel->save(['tipe_sertifikat' => $tipe]);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'saved',
            csrf_token() => csrf_hash()
        ]);
    }

    public function tipeSertifikatUpdate()
    {
        $id = $this->request->getVar('id');
        $tipe = $this->request->getVar('tipe_sertifikat');
        $this->TipeSertifikatModel->save(['id' => $id, 'tipe_sertifikat' => $tipe]);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'updated',
            csrf_token() => csrf_hash()
        ]);
    }

    public function tipeSertifikatDelete($id)
    {
        $this->TipeSertifikatModel->delete($id);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'deleted',
            csrf_token() => csrf_hash()
        ]);
    }

    public function tipeSertifikatList()
    {
        $data = $this->TipeSertifikatModel->orderBy('id', 'DESC')->findAll();
        return $this->response->setJSON($data);
    }
}
