<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeLate extends Migration
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
            'employee_pin' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'date' => [
                'type'           => 'DATE',
            ],
            'late_hour' => [
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
        $this->forge->createTable('employee_late');
    }

    public function down()
    {
        $this->forge->dropTable('employee_late');
    }
}
