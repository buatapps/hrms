<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CountFood extends Migration
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
            'date' => [
                'type'           => 'DATE',
            ],
            'employaa_id' => [
                'type'           => 'INT',
                'constraint'    => 11,
            ],
            'status' => [
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
        $this->forge->createTable('count_food');
    }

    public function down()
    {
        $this->forge->dropTable('count_food');
    }
}
