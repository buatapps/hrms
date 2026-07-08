<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sim extends Migration
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
            'tipe_sim' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'masa_berlaku' => [
                'type'       => 'DATE',
            ],
            'file_sim' => [
                'type'       => 'text',
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
        $this->forge->createTable('sim');
    }

    public function down()
    {
        $this->forge->dropTable('sim');
    }
}
