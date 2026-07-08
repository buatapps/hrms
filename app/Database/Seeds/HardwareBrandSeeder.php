<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HardwareBrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            // Laptop → ID kategori = 1
            ['hardware_category_id' => 1, 'name' => 'Lenovo'],
            ['hardware_category_id' => 1, 'name' => 'ASUS'],
            ['hardware_category_id' => 1, 'name' => 'HP'],
            ['hardware_category_id' => 1, 'name' => 'Dell'],
            ['hardware_category_id' => 1, 'name' => 'Acer'],
            ['hardware_category_id' => 1, 'name' => 'Apple'],

            // PC / Komputer → ID kategori = 2
            ['hardware_category_id' => 2, 'name' => 'Lenovo'],
            ['hardware_category_id' => 2, 'name' => 'HP'],
            ['hardware_category_id' => 2, 'name' => 'Dell'],
            ['hardware_category_id' => 2, 'name' => 'Appel'],

            // Monitor → ID kategori = 3
            ['hardware_category_id' => 3, 'name' => 'Samsung'],
            ['hardware_category_id' => 3, 'name' => 'LG'],
            ['hardware_category_id' => 3, 'name' => 'AOC'],
            ['hardware_category_id' => 3, 'name' => 'Dell'],
            ['hardware_category_id' => 3, 'name' => 'Apple'],

            // Printer → ID kategori = 4
            ['hardware_category_id' => 4, 'name' => 'Epson'],
            ['hardware_category_id' => 4, 'name' => 'Canon'],
            ['hardware_category_id' => 4, 'name' => 'HP'],

            // Scanner → ID kategori = 5
            ['hardware_category_id' => 5, 'name' => 'Canon'],
            ['hardware_category_id' => 5, 'name' => 'Epson'],

            // Router / Switch → ID kategori = 6
            ['hardware_category_id' => 6, 'name' => 'TP-Link'],
            ['hardware_category_id' => 6, 'name' => 'MikroTik'],
            ['hardware_category_id' => 6, 'name' => 'Cisco'],

            // Projector → ID kategori = 7
            ['hardware_category_id' => 7, 'name' => 'Infocus'],
            ['hardware_category_id' => 7, 'name' => 'Epson'],

            // UPS / Stabilizer → ID kategori = 8
            ['hardware_category_id' => 8, 'name' => 'APC'],
            ['hardware_category_id' => 8, 'name' => 'Prolink'],
            ['hardware_category_id' => 8, 'name' => 'Matsunaga'],

            // Smartphone / Tablet → ID kategori = 9
            ['hardware_category_id' => 9, 'name' => 'Samsung'],
            ['hardware_category_id' => 9, 'name' => 'Apple'],
            ['hardware_category_id' => 9, 'name' => 'Xiaomi'],

            // Server → ID kategori = 10
            ['hardware_category_id' => 10, 'name' => 'Dell'],
            ['hardware_category_id' => 10, 'name' => 'HP Enterprise'],
            ['hardware_category_id' => 10, 'name' => 'Lenovo'],

            // Peripheral → ID kategori = 11
            ['hardware_category_id' => 11, 'name' => 'Logitech'],
            ['hardware_category_id' => 11, 'name' => 'Rexus'],
            ['hardware_category_id' => 11, 'name' => 'NYK'],
            ['hardware_category_id' => 11, 'name' => 'Sades'],
            ['hardware_category_id' => 11, 'name' => 'Fantech'],
            ['hardware_category_id' => 11, 'name' => 'Digital Alliance'],

            // Lainnya → ID kategori = 12
            ['hardware_category_id' => 12, 'name' => 'OEM'],
            ['hardware_category_id' => 12, 'name' => 'Custom'],
            ['hardware_category_id' => 12, 'name' => 'Logitech'],
            ['hardware_category_id' => 12, 'name' => 'Taffware'],
            ['hardware_category_id' => 12, 'name' => 'NYK'],
            ['hardware_category_id' => 12, 'name' => 'Unbranded'],
        ];

        foreach ($brands as $item) {
            $this->db->table('hardware_brand')->insert([
                'hardware_category_id' => $item['hardware_category_id'],
                'name'                 => $item['name'],
                'created_at'           => date('Y-m-d H:i:s'),
                'updated_at'           => date('Y-m-d H:i:s')
            ]);
        }
    }
}
