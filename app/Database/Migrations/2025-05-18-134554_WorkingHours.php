<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkingHours extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'entry_time' => [
                'type'       => 'TIME',
            ],
            'clock_out' => [
                'type'       => 'TIME',
            ],
            'start_scan_in' => [
                'type'       => 'DATE',
            ],
            'end_scan_in' => [
                'type'       => 'TIME',
            ],
            'start_scan_out' => [
                'type'       => 'TIME',
            ],
            'end_scan_out' => [
                'type'       => 'TIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('working_hours');
    }

    public function down()
    {
        $this->forge->dropTable('working_hours');
    }
}
