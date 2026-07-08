<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailOvertimeDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'header_id'     => ['type' => 'INT'],
            'employee_id'   => ['type' => 'INT'],
            'job_desk'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'total_hours'   => ['type' => 'DECIMAL', 'constraint' => '5,2'],

            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('overtime_detail_form');
    }

    public function down()
    {
        $this->forge->dropTable('overtime_detail_form');
    }
}
