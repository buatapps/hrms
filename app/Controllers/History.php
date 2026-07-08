<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class History extends BaseController
{

    public function index() {}

    public function plant_group()
    {

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $list_data = $this->LogHistoryModel->logplantgroup($start_date, $end_date);
        $employees = $this->EmployeeModel->findAll();
        $data = [
            'title' => 'History Plant - Group',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employees' => $employees,
            'list_data' => $list_data
        ];

        return view('history/plant_group', $data);
    }

    public function log_plant_group_search()
    {
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
        $employee_id = $this->request->getVar('employee_id');
        $list_data = $this->LogHistoryModel->logplantgroup($start_date, $end_date, $employee_id);
        $employees = $this->EmployeeModel->findAll();
        $data = [
            'title' => 'History Plant - Group',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employees' => $employees,
            'list_data' => $list_data
        ];

        return view('history/plant_group', $data);
    }

    public function absent()
    {
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $list_data = $this->LogHistoryAbsentModel->logabsent($start_date, $end_date);
        $employees = $this->EmployeeModel->findAll();
        $data = [
            'title' => 'History Absent',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employees' => $employees,
            'list_data' => $list_data
        ];

        return view('history/absent', $data);
    }
}
