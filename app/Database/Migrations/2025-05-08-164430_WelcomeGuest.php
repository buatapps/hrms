<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WelcomeGuest extends Migration
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
            'welcome_board_id' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'member_guest' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'member_information' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
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
        $this->forge->createTable('welcome_guest');
    }

    public function down()
    {
        $this->forge->dropTable('welcome_guest');
    }
}
