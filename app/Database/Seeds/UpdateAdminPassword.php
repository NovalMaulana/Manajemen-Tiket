<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateAdminPassword extends Seeder
{
    public function run()
    {
        $data = [
            'password' => password_hash('admin123', PASSWORD_DEFAULT)
        ];

        $this->db->table('users')
                 ->where('username', 'admin')
                 ->update($data);

        echo "Password admin berhasil diupdate!\n";
    }
} 