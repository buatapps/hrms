<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\EmployeeModel;
use App\Models\CountFoodModel;

class CountFoodSeeder extends Seeder
{
    public function run()
    {
        $employeeModel = new EmployeeModel();
        $countFoodModel = new CountFoodModel();

        $statuses = ['MAKAN', 'PUASA', 'DIET'];
        $startDate = strtotime('2025-06-23');
        $endDate = strtotime('2025-06-27');

        $employees = $employeeModel
            ->select('employee_pin')
            ->where('employee_pin IS NOT NULL', null, false)
            ->findAll();
        $data = [];

        foreach ($employees as $emp) {
            for ($d = $startDate; $d <= $endDate; $d = strtotime('+1 day', $d)) {
                $data[] = [
                    'date' => date('Y-m-d', $d),
                    'employee_pin' => $emp->employee_pin,
                    'status' => $statuses[array_rand($statuses)],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        // Insert batch
        $countFoodModel->insertBatch($data);

        echo "Seeder selesai. Total data: " . count($data);
    }
}
