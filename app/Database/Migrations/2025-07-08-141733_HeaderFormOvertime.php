<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HeaderFormOvertime extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'date'          => ['type' => 'DATE'],
            'status'        => ['type' => "ENUM('submitted','approved','rejected')", 'default'    => 'submitted'],
            'created_by'    => ['type' => 'INT'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('overtime_header_form');
    }

    public function down()
    {
        $this->forge->dropTable('overtime_header_form');
    }
}
