<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Idcard extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'ID Card',
            'list_data' => $this->IdcardModel->getEmployees()
        ];

        return view('idcard/index', $data);
    }

    public function print($id = null)
    {
        $employees = $this->IdcardModel->getEmployees($id);

        return view('idcard/print', ['employees' => $employees]);
    }
}
