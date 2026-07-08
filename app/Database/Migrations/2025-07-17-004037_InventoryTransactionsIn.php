<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryTransactionsIn extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'item_id'         => ['type' => 'INT', 'unsigned' => true],
            'quantity'        => ['type' => 'INT', 'unsigned' => true],
            'tanggal'         => ['type' => 'DATE'],
            'keterangan'      => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('item_id', 'inventory_items', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('inventory_transactions_in');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_transactions_in');
    }
}
