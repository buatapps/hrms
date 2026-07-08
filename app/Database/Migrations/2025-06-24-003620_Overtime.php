<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Overtime extends Migration
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
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'date' => [
                'type'       => 'DATE',
            ],
            'jobdesk' => [
                'type'       => 'TEXT',
            ],
            'start_time' => [
                'type'       => 'TIME',
            ],
            'end_time' => [
                'type'       => 'TIME',
            ],
            'total_hours' => [
                'type'       => 'FLOAT',
                'constraint' => '8,2',
                'null'       => false,
                'default'    => 0.00,
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
        $this->forge->createTable('overtime');
    }

    public function down()
    {
        $this->forge->dropTable('overtime');
    }
}
