<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LockerHistory extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $list_data = $db->table('locker_history lh')
            ->select('
        lh.*,
        l.locker_code,
        l.key_number,
        l.location,
        e.name as employee_name
    ')
            ->join('locker l', 'l.id = lh.locker_id')
            ->join('employee e', 'e.id = lh.employee_id', 'left')
            ->orderBy('lh.id', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title'     => 'Locker History',
            'list_data' => $list_data

        ];

        return view('locker_history/index', $data);
    }

    public function add()
    {

        $data = [
            'title'         => 'Add Locker History',
            'locker'        => $this->LockerModel->findAll(),
            'employee'      => $this->EmployeeModel->findAll()
        ];
        return view('locker_history/add', $data);
    }

    public function save()
    {

        $locker_id = $this->request->getVar('locker_id');
        $employee_id = $this->request->getVar('employee_id');
        $transaction_date = $this->request->getVar('transaction_date');
        $event = $this->request->getVar('event');
        $remark = $this->request->getVar('remark');

        if ($event == 'Broken') {
            $this->LockerModel->save([
                'id'        => $locker_id,
                'is_active' => 'non-active'
            ]);
        } else {
            $this->LockerModel->save([
                'id'        => $locker_id,
                'is_active' => 'active'
            ]);
        }


        $this->LockerHistoryModel->save([
            'locker_id'         => $locker_id,
            'employee_id'       => $employee_id,
            'transaction_date'  => $transaction_date,
            'event'             => $event,
            'remark'            => $remark
        ]);

        return redirect()->to(base_url('locker_history'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Edit Locker History',
            'locker'        => $this->LockerModel->findAll(),
            'employee'      => $this->EmployeeModel->findAll(),
            'list_data' => $this->LockerHistoryModel->where(['id' => $id])->first(),
        ];


        return view('locker_history/edit', $data);
    }

    public function update($id)
    {
        $locker_id = $this->request->getVar('locker_id');
        $employee_id = $this->request->getVar('employee_id');
        $transaction_date = $this->request->getVar('transaction_date');
        $event = $this->request->getVar('event');
        $remark = $this->request->getVar('remark');

        if ($event == 'Broken') {
            $this->LockerModel->save([
                'id'        => $locker_id,
                'is_active' => 'non-active'
            ]);
        } else {
            $this->LockerModel->save([
                'id'        => $locker_id,
                'is_active' => 'active'
            ]);
        }


        $this->LockerHistoryModel->save([
            'id'               => $id,
            'locker_id'      => $locker_id,
            'employee_id'       => $employee_id,
            'transaction_date'         => $transaction_date,
            'event'           => $event,
            'remark'           => $remark
        ]);

        return redirect()->to(base_url('locker_history'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->LockerHistoryModel->delete($id);
        return redirect()->to(base_url('locker_history'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
