<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Hardware',
                'slug'       => 'hardware',
                'color'      => 'primary',
                'order'      => 1,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Software',
                'slug'       => 'software',
                'color'      => 'info',
                'order'      => 2,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Network',
                'slug'       => 'network',
                'color'      => 'warning',
                'order'      => 3,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Email',
                'slug'       => 'email',
                'color'      => 'danger',
                'order'      => 4,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Printer',
                'slug'       => 'printer',
                'color'      => 'purple',
                'order'      => 5,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Support',
                'slug'       => 'support',
                'color'      => 'dark',
                'order'      => 6,
                'is_active'  => 1,
            ],
            [
                'name'       => 'Lainnya',
                'slug'       => 'other',
                'color'      => 'secondary',
                'order'      => 99,
                'is_active'  => 1,
            ],
        ];

        $this->db->table('ticket_category')->insertBatch($data);
    }
}
