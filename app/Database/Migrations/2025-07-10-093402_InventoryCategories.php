<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => date('Y-m-d H:i:s')
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('inventory_categories');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_categories');
    }
}
