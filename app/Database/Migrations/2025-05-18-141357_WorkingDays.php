<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkingDays extends Migration
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
            'shift_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'shift_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'working_time_id' => [
                'type'       => 'INT',
                'constraint'    => 5,
            ],
            'working_time_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'day' => [
                'type'       => 'VARCHAR',
                'constraint'    => '100',
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
        $this->forge->createTable('working_days');
    }

    public function down()
    {
        $this->forge->dropTable('working_days');
    }
}
