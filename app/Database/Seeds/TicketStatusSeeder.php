<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Open',
                'slug' => 'open',
                'color' => 'primary',
                'order' => 1
            ],
            [
                'name' => 'Assigned',
                'slug' => 'assigned',
                'color' => 'info',
                'order' => 2
            ],
            [
                'name' => 'On Progress',
                'slug' => 'on-progress',
                'color' => 'warning',
                'order' => 3
            ],
            [
                'name' => 'Resolved',
                'slug' => 'resolved',
                'color' => 'success',
                'order' => 4
            ],
            [
                'name' => 'Closed',
                'slug' => 'closed',
                'color' => 'dark',
                'order' => 5
            ],
            [
                'name' => 'Canceled',
                'slug' => 'canceled',
                'color' => 'danger',
                'order' => 6
            ],
        ];

        foreach ($data as $status) {
            $this->db->table('ticket_status')->insert($status);
        }
    }
}
