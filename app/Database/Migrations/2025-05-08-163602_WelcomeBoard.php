<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WelcomeBoard extends Migration
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
            'guest_id' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'start_date' => [
                'type'       => 'DATETIME',
            ],
            'end_date' => [
                'type'       => 'DATETIME',
            ],
            'start_time' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'end_time' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'topic' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'active' => [
                'type'       => 'INT',
                'constraint' => '1',
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
        $this->forge->createTable('welcome_board');
    }

    public function down()
    {
        $this->forge->dropTable('welcome_board');
    }
}
