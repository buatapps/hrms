<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WorkingDays extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Working Hours',
            'list_data' => $this->WorkingDaysModel->WokingDaysData()

        ];

        return view('working_days/index', $data);
    }

    public function add()
    {
        $shift = $this->ShiftModel->findAll();
        $workinghours = $this->WorkingHoursModel->findAll();

        $data = [
            'title'         => 'Add Working Days',
            'shift'         => $shift,
            'workinghours'  => $workinghours
        ];
        return view('working_days/add', $data);
    }

    public function save()
    {
        $day = $this->request->getVar('day');
        $shift_id = $this->request->getVar('shift_id');
        $working_hours_id = $this->request->getVar('working_hours_id');
        $check = $this->WorkingDaysModel->checkData($shift_id, $working_hours_id);
        if ($check != 0) {
            return redirect()->to(base_url('working_days'))->with('error', 'data <strong>Failed!</strong> is duplicated');
        }
        foreach ($day as $days) {
            $shift = $this->ShiftModel->where('id', $shift_id)->first();
            $workinghours = $this->WorkingHoursModel->where('id', $working_hours_id)->first();

            $this->WorkingDaysModel->save([
                'shift_id'      => $this->request->getVar('shift_id'),
                'shift_name'    => $shift->name,
                'working_hours_id' => $this->request->getVar('working_hours_id'),
                'working_hours_name' => $workinghours->name,
                'day'           => $days
            ]);
        }

        return redirect()->to(base_url('working_days'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($shift_id, $working_hours_id)
    {
        $shift = $this->ShiftModel->where('id', $shift_id)->get()->getResultObject();
        $workinghours = $this->WorkingHoursModel->where('id', $working_hours_id)->get()->getResultObject();
        $data = [
            'title'     => 'Edit Working Hours',
            'list_data' => $this->WorkingDaysModel->where(['shift_id' => $shift_id, 'working_hours_id' => $working_hours_id])->first(),
            'shift'     => $shift,
            'workinghours' => $workinghours,
            'shift_id'  => $shift_id,
            'working_hours_id' => $working_hours_id,
            'num_Monday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Monday'),
            'num_Tuesday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Tuesday'),
            'num_Wednesday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Wednesday'),
            'num_Thursday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Thursday'),
            'num_Friday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Friday'),
            'num_Saturday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Saturday'),
            'num_Sunday'    => $this->WorkingDaysModel->checkDays($shift_id, $working_hours_id, 'Sunday'),
        ];


        return view('working_days/edit', $data);
    }

    public function update($shift_id, $working_hours_id)
    {
        $day = $this->request->getVar('day');
        $shift = $this->ShiftModel->where('id', $shift_id)->get()->getResultObject();
        $workinghours = $this->WorkingHoursModel->where('id', $working_hours_id)->get()->getResultObject();
        $this->WorkingDaysModel->where(['shift_id' => $shift_id, 'working_hours_id' => $working_hours_id])->delete();
        foreach ($day as $days) {
            $this->WorkingDaysModel->save([
                'shift_id'      => $this->request->getVar('shift_id'),
                'shift_name'    => $shift[0]->name,
                'working_hours_id' => $this->request->getVar('working_hours_id'),
                'working_hours_name' => $workinghours[0]->name,
                'day'           => $days
            ]);
        }

        return redirect()->to(base_url('working_days'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($shift_id, $working_hours_id)
    {
        $this->WorkingDaysModel->where(['shift_id' => $shift_id, 'working_hours_id' => $working_hours_id])->delete();
        return redirect()->to(base_url('working_days'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
