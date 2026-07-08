<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryHardware extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_asset'           => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama'                 => ['type' => 'VARCHAR', 'constraint' => 100],
            'hardware_category_id' => ['type' => 'INT', 'unsigned' => true],
            'hardware_brand_id'    => ['type' => 'INT', 'unsigned' => true],
            'tipe'                 => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'serial_number'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'spesifikasi'          => ['type' => 'TEXT', 'null' => true],
            'lokasi'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pengguna'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'               => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Rusak', 'Dipinjam', 'Nonaktif'],
                'default'    => 'Aktif'
            ],
            'tgl_perolehan'        => ['type' => 'DATE', 'null' => true],
            'foto'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'keterangan'           => ['type' => 'TEXT', 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('hardware_category_id', 'hardware_category', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('hardware_brand_id', 'hardware_brand', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('hardware');
    }

    public function down()
    {
        $this->forge->dropTable('hardware');
    }
}
