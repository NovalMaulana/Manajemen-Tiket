<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateAllPasswords extends Seeder
{
    public function run()
    {
        // Update password untuk semua user
        $users = [
            ['username' => 'admin', 'password' => 'admin123'],
            ['username' => 'organizer1', 'password' => 'organizer123'],
            ['username' => 'organizer2', 'password' => 'organizer123'],
            ['username' => 'organizer3', 'password' => 'organizer123'],
            ['username' => 'customer1', 'password' => 'customer123'],
            ['username' => 'customer2', 'password' => 'customer123'],
            ['username' => 'customer3', 'password' => 'customer123'],
            ['username' => 'customer4', 'password' => 'customer123'],
            ['username' => 'customer5', 'password' => 'customer123'],
            ['username' => 'customer6', 'password' => 'customer123'],
            ['username' => 'customer7', 'password' => 'customer123'],
            ['username' => 'customer8', 'password' => 'customer123'],
            ['username' => 'customer9', 'password' => 'customer123'],
            ['username' => 'customer10', 'password' => 'customer123']
        ];

        foreach ($users as $user) {
            $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
            
            $this->db->table('users')
                     ->where('username', $user['username'])
                     ->update(['password' => $hashedPassword]);
            
            echo "Password untuk user {$user['username']} berhasil diupdate!\n";
        }

        echo "\nSemua password user berhasil diupdate menggunakan hash!\n";
        echo "\nInformasi login:\n";
        echo "Admin: admin / admin123\n";
        echo "Organizer: organizer1 / organizer123\n";
        echo "Customer: customer1 / customer123\n";
    }
} 