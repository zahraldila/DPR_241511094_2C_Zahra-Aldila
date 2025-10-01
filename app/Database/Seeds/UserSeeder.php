<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'full_name'     => 'Site Admin',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'          => 'admin',
            ],
            [
                'username'      => 'jdoe',
                'full_name'     => 'John Doe',
                'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
                'role'          => 'user',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
