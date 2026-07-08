<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTransactionOutTypes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'impact_column' => ['type' => 'VARCHAR', 'constraint' => 50],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inventory_transaction_out_types');

        // Seed default types
        $db = \Config\Database::connect();
        $db->table('inventory_transaction_out_types')->insertBatch([
            [
                'code'           => 'out',
                'name'           => 'Pemakaian',
                'impact_column'  => 'stock_out'
            ],
            [
                'code'           => 'broken',
                'name'           => 'Rusak',
                'impact_column'  => 'stock_broken'
            ],
            [
                'code'           => 'lost',
                'name'           => 'Hilang',
                'impact_column'  => 'stock_lost'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('inventory_transaction_out_types');
    }
}
