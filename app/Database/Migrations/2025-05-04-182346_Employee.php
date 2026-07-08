<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'company_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'employee_id' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'employee_pin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'section_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'position_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'education_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'date_of_entry' => [
                'type'      => 'DATE',
                'null'      => true,
            ],
            'working_status_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'working_days' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'gender_id' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'birthday_place' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'birthday_date' => [
                'type'      => 'DATE',
                'null'      => true,
            ],
            'address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'identity_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
                'null'       => true,
            ],
            'religion_id' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'marriage_status_id' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'number_of_children' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'bank_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'account_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'salary' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'npwp_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'ketenagakerjaan_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'kesehatan_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'klinik_provider' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'uniform_size_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'shoes_size_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
            'emergency_contact' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'couple' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'child_1' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'child_2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'child_3' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'image' => [
                'type'       => 'TEXT',
                'null' => true,
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
        $this->forge->createTable('employee');
    }

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
