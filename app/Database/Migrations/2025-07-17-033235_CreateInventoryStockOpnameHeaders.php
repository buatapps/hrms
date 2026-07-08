<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryStockOpnameHeaders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'year_month'   => ['type' => 'VARCHAR', 'constraint' => 7], // Format: YYYY-MM
            'created_by'   => ['type' => 'INT', 'unsigned' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('inventory_stock_opname_headers');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_stock_opname_headers');
    }
}
