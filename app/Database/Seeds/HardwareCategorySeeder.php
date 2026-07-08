<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HardwareCategorySeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            ['name' => 'Laptop',                 'description' => 'Perangkat komputer portabel'],
            ['name' => 'PC / Komputer',          'description' => 'Komputer desktop rakitan atau pabrikan'],
            ['name' => 'Monitor',                'description' => 'Layar tampilan untuk komputer'],
            ['name' => 'Printer',                'description' => 'Perangkat untuk mencetak dokumen'],
            ['name' => 'Scanner',                'description' => 'Perangkat untuk memindai dokumen/foto'],
            ['name' => 'Router / Switch',        'description' => 'Perangkat jaringan LAN / WAN'],
            ['name' => 'Projector',              'description' => 'Proyektor untuk presentasi atau video'],
            ['name' => 'UPS / Stabilizer',       'description' => 'Perangkat listrik untuk backup daya'],
            ['name' => 'Smartphone / Tablet',    'description' => 'Gadget mobile milik kantor'],
            ['name' => 'Server',                 'description' => 'Komputer server untuk kebutuhan internal'],
            ['name' => 'Lainnya',                'description' => 'Kategori lain yang belum terdaftar']
        ];

        foreach ($kategori as $item) {
            $this->db->table('hardware_category')->insert([
                'name'        => $item['name'],
                'description' => $item['description'], // ← pakai field baru
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]);
        }
    }
}
