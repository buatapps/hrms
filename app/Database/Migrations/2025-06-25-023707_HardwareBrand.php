<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HardwareBrand extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'hardware_category_id' => ['type' => 'INT', 'unsigned' => true],
            'name'                  => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('hardware_category_id', 'hardware_category', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hardware_brand');
    }

    public function down()
    {
        $this->forge->dropTable('hardware_brand');
    }
}
