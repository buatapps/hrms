<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class CountFood extends BaseController
{
    public function index()
    {
        $today = new Time('now');
        $dates = explode(' ', $today);
        $countmakan = $this->CountFoodModel->countFood($dates[0], 'MAKAN');
        $counttidakmakan = $this->CountFoodModel->countFood($dates[0], 'TIDAK MAKAN');
        $countpuasa = $this->CountFoodModel->countFood($dates[0], 'PUASA');
        $counttidakpuasa = $this->CountFoodModel->countFood($dates[0], 'TIDAK PUASA');
        $countdiet = $this->CountFoodModel->countFood($dates[0], 'DIET');
        $data = [
            'title'     => 'Count Food',
            'list_data' => $this->CountFoodModel->dataCountFood($dates[0])->getResultObject(),
            'total' => $this->CountFoodModel->dataCountFood($dates[0])->getNumRows(),
            'date'      => $dates[0],
            'countmakan' => $countmakan,
            'counttidakmakan' => $counttidakmakan,
            'countpuasa' => $countpuasa,
            'counttidakpuasa' => $counttidakpuasa,
            'countdiet' => $countdiet,
            'status'    => "MAKAN"
        ];

        return view('count_food/index', $data);
    }

    public function generate()
    {
        $date = $this->request->getVar('date');
        $attendance = $this->AttendanceModel->attendaceEmployee($date);
        $status = $this->request->getVar('status');
        foreach ($attendance as $row) {
            $check = $this->CountFoodModel->checkCountFood($date, $row->pin);
            if ($check == 0) {
                $this->CountFoodModel->save([
                    'date'          => $date,
                    'employee_pin'   => $row->pin,
                    'status'        => $status
                ]);
            }
        }

        return redirect()->to(base_url('count_food'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function update_status()
    {
        $id = $this->request->getVar('id');
        $status = $this->request->getVar('status');
        $this->CountFoodModel->save([
            'id'        => $id,
            'status'    => $status
        ]);

        // return redirect()->to(base_url('count_food'))->with('success', 'data <strong>saved</strong> successfully');
        return redirect()->back();
    }

    public function data()
    {
        $today = new Time('now');
        $dates = explode(' ', $today);
        $date = $dates[0];
        $status = null;
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Count Food Data',
            'date'      => $dates[0],
            'status'    => null,
            'list_data' => $this->CountFoodModel->searchdataCountFood($date, $status, $division_id)->getResultObject(),
            'total'  => $this->CountFoodModel->searchdataCountFood($date, $status, $division_id)->getNumRows(),
            'group_data'    => $this->CountFoodModel->groupsearchdataCountFood($date, $status)
        ];

        return view('count_food/data', $data);
    }

    public function search()
    {
        $date = $this->request->getVar('date');
        $status = $this->request->getVar('status');
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Count Food Data',
            'date'      => $date,
            'status'    => $status,
            'list_data' => $this->CountFoodModel->searchdataCountFood($date, $status, $division_id)->getResultObject(),
            'total'  => $this->CountFoodModel->searchdataCountFood($date, $status, $division_id)->getNumRows(),
            'group_data'    => $this->CountFoodModel->groupsearchdataCountFood($date, $status)
        ];

        return view('count_food/data', $data);
    }

    public function cardFood()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Card Food',
            'list_data' => $this->EmployeeModel->dataEmployee($division_id)
        ];

        return view('count_food/cardFood', $data);
    }

    public function print($id)
    {
        $employees = $this->EmployeeModel->dataEmployeeArray($id);
        return view('count_food/print', ['employees' => $employees]);
    }

    public function printAll()
    {
        $employees = $this->EmployeeModel->dataEmployeeArray();
        return view('count_food/printAll', ['employees' => $employees]);
    }
}
