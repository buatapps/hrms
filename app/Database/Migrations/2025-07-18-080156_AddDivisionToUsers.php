<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDivisionToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'division_id' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
