<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryStockOpname extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'header_id'      => ['type' => 'INT', 'unsigned' => true],
            'item_id'        => ['type' => 'INT', 'unsigned' => true],
            'final_stock'    => ['type' => 'INT', 'default' => 0],
            'stock_opname'   => ['type' => 'INT', 'default' => 0],
            'selisih'        => ['type' => 'INT', 'default' => 0],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('header_id', 'inventory_stock_opname_headers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('item_id', 'inventory_items', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('inventory_stock_opname');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_stock_opname');
    }
}
