<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class STNK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nama_stnk' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nomor_plat' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'brand_motor' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'type_motor' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'masa_berlaku_pajak' => [
                'type'       => 'DATE',
            ],
            'masa_berlaku_plat' => [
                'type'       => 'DATE',
            ],
            'file_stnk' => [
                'type'       => 'TEXT',
            ],
            'file_stnk_pajak' => [
                'type'       => 'TEXT',
            ],
            'foto_motor_depan' => [
                'type'       => 'TEXT',
            ],
            'foto_motor_kanan' => [
                'type'       => 'TEXT',
            ],
            'foto_motor_belakang' => [
                'type'       => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('stnk');
    }

    public function down()
    {
        $this->forge->dropTable('stnk');
    }
}
