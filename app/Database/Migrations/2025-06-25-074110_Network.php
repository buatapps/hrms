<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Network extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_asset'    => ['type' => 'VARCHAR', 'constraint' => 20],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'tipe'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'ip_address'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'mac_address'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'lokasi'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pengguna'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'keterangan'    => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['Aktif', 'Nonaktif', 'Rusak'], 'default' => 'Aktif'],
            'lampiran'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('network');
    }

    public function down()
    {
        $this->forge->dropTable('network');
    }
}
