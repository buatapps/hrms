<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeSchedule extends Migration
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
            'employee_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'employee_pin' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'date' => [
                'type'           => 'DATE',
            ],
            'working_days_id' => [
                'type'       => 'INT',
                'constraint'    => 5,
            ],
            'day' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
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
        $this->forge->createTable('employee_schedule');
    }

    public function down()
    {
        $this->forge->dropTable('employee_schedule');
    }
}
