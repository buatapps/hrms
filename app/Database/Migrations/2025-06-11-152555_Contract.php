<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contract extends Migration
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
            'kontrak' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'start_date' => [
                'type'       => 'DATE',
            ],
            'end_date' => [
                'type'       => 'DATE',
            ],
            'status' => [
                'type'       => 'SET',
                'constraint' => ['Active', 'Non Active'],
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
        $this->forge->createTable('contact');
    }

    public function down()
    {
        $this->forge->dropTable('contact');
    }
}
