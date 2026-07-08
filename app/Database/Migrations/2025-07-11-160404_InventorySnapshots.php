<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventorySnapshots extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'item_id'         => ['type' => 'INT', 'constraint' => 11],
            'year_month'      => ['type' => 'VARCHAR', 'constraint' => 7], // format: YYYY-MM
            'stock_awal'      => ['type' => 'INT', 'default' => 0],
            'stock_in'        => ['type' => 'INT', 'default' => 0],
            'stock_out'       => ['type' => 'INT', 'default' => 0],
            'stock_broken'    => ['type' => 'INT', 'default' => 0],
            'stock_lost'      => ['type' => 'INT', 'default' => 0],
            'stock_akhir'     => ['type' => 'INT', 'default' => 0],       // calculated
            'stock_opname'    => ['type' => 'INT', 'null' => true],       // optional (manual input)
            'final_stock'     => ['type' => 'INT', 'default' => 0],       // follow stock_opname if exists
            'status'          => [
                'type'       => 'ENUM',
                'constraint' => ['open', 'closed'],
                'default'    => 'open'
            ],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['item_id', 'year_month']);
        $this->forge->createTable('inventory_snapshots');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_snapshots');
    }
}
