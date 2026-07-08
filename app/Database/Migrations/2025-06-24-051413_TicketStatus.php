<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'color'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'secondary'],
            'order'      => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ticket_status');
    }

    public function down()
    {
        $this->forge->dropTable('ticket_status');
    }
}
