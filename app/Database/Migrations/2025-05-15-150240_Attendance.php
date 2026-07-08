<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attendance extends Migration
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
            'attendance_machine_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'pin' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'datetime' => [
                'type'       => 'DATETIME',
            ],
            'date' => [
                'type'       => 'DATE',
            ],
            'time' => [
                'type'       => 'TIME',
            ],
            'verified' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('attendance');
    }

    public function down()
    {
        $this->forge->dropTable('attendance');
    }
}
