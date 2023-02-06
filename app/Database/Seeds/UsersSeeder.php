<?php

namespace App\Database\Seeds;

use CodeIgniter\Config\Factory;
use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {

        $data = [
            'Nama' => 'Administrator',
            'Username' => 'admin',
            'Password' => password_hash('hapus', PASSWORD_DEFAULT),
            'CreatedAT' => date("Y-m-d H:i:s"),
        ];
        $this->db->table('users')->insert($data);
    }
}
