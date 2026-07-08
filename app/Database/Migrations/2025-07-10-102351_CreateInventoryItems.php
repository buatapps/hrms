<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'category_id'     => ['type' => 'INT', 'constraint' => 11],
            'code'            => ['type' => 'VARCHAR', 'constraint' => 20],
            'name'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'size'            => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'stock'           => ['type' => 'INT', 'default' => 0],
            'stock_broken'    => ['type' => 'INT', 'default' => 0],
            'stock_lost'      => ['type' => 'INT', 'default' => 0],
            'description'     => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inventory_items');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_items');
    }
}
