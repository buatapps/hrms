<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ToolsModel;
use CodeIgniter\HTTP\ResponseInterface;

class Tools extends BaseController
{

    public function createAuth()
    {
        $model = new ToolsModel();
        // $auth_date = date('Y-m-d', strtotime('-1 day'));
        $auth_date = '2026-12-31';
        $auth_label = "main_system";
        $id = $model->generateAndSave($auth_date, $auth_label);

        return $this->response->setJSON([
            'status' => 'ok',
            'id' => $id
        ]);
    }

    public function authKey()
    {
        return view('errors/system_expired');
    }
}
