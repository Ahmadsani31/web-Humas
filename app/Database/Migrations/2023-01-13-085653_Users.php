<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'UserID'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'Username'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'Password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'Nama'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'CreatedAT' => [
                'type'           => 'DATETIME',
                'null'            => true,
            ],
            'UpdatedAT' => [
                'type'           => 'DATETIME',
                'null'            => true,
            ],
            'DeletedAT' => [
                'type'           => 'DATETIME',
                'null'            => true,
            ]

        ]);
        $this->forge->addKey('UserID', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
