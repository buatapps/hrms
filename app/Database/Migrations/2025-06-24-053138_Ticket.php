<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ticket extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'auto_increment' => true],
            'ticket_number'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'date'                => ['type' => 'DATE'],
            'time'                => ['type' => 'TIME'],
            'employee_id'         => ['type' => 'INT'],
            'title'               => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'         => ['type' => 'TEXT'],
            'solution'            => ['type' => 'TEXT', 'null' => true],
            'ticket_status_id'    => ['type' => 'INT'],
            'ticket_category_id'  => ['type' => 'INT'],
            'priority'            => ['type' => "ENUM('low','medium','high','critical')", 'default' => 'medium'],
            'attachment'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'closed_at'           => ['type' => 'DATETIME', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ticket');
    }

    public function down()
    {
        $this->forge->dropTable('ticket');
    }
}
