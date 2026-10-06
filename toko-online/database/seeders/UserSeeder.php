<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * 2 akun pembeli untuk pengujian login & checkout.
     */
    public function run(): void
    {
        $users = [
            [
                'id_user'      => 'USR-001',
                'nama_lengkap' => 'Budi Santoso',
                'email'        => 'budi@example.com',
                'username'     => 'budi',
                // Password mentah, otomatis di-hash oleh cast.
                'password'     => 'rahasia123',
                'no_hp'        => '081234567890',
                'alamat'       => 'Jl. Merdeka No. 10, Bandung',
            ],
            [
                'id_user'      => 'USR-002',
                'nama_lengkap' => 'Siti Aminah',
                'email'        => 'siti@example.com',
                'username'     => 'siti',
                'password'     => 'rahasia456',
                'no_hp'        => '082198765432',
                'alamat'       => 'Jl. Sudirman No. 25, Jakarta',
            ],
        ];

        foreach ($users as $u) {
            User::create($u);
        }
    }
}
