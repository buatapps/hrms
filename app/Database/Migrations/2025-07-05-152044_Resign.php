<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Resign extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'employee_id'   => ['type' => 'INT'],
            'resign_date'   => ['type' => 'DATE'],
            'reason'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'notes'        => ['type' => 'VARCHAR', 'constraint' => 255],
            
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('resign');
    }

    public function down()
    {
        $this->forge->dropTable('resign');
    }
}
