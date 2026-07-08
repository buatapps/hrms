<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Software extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_asset'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'name'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'license_type'       => ['type' => 'VARCHAR', 'constraint' => 50], // Perpetual, Subscription, etc.
            'platform'           => ['type' => 'VARCHAR', 'constraint' => 50], // Windows, Linux, etc.
            'versi'              => ['type' => 'VARCHAR', 'constraint' => 50],
            'vendor'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'tgl_installasi'     => ['type' => 'DATE'],
            'masa_berlaku'       => ['type' => 'DATE', 'null' => true],
            'jumlah_lisensi'     => ['type' => 'INT', 'default' => 1],
            'lokasi_installasi'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'pengguna'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan'         => ['type' => 'TEXT', 'null' => true],
            'status'             => ['type' => 'ENUM', 'constraint' => ['Aktif', 'Nonaktif', 'Kadaluarsa'], 'default' => 'Aktif'],
            'file_lisensi'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('software');
    }

    public function down()
    {
        $this->forge->dropTable('software');
    }
}
