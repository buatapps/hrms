<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileToSertifikat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sertifikat', [
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sertifikat', 'file');
    }
}
