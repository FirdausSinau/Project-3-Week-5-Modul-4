<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleDemoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Akun demo untuk praktikum role management.
     */
    public function run(): void
    {
        $users = [
            ['username' => 'admin', 'nama_lengkap' => 'Administrator', 'password' => 'admin123', 'role' => 'admin'],
            ['username' => 'staff', 'nama_lengkap' => 'Staff Toko', 'password' => 'staff123', 'role' => 'staff'],
            ['username' => 'budi', 'nama_lengkap' => 'Budi Santoso', 'password' => 'rahasia123', 'role' => 'customer'],
            ['username' => 'siti', 'nama_lengkap' => 'Siti Aminah', 'password' => 'rahasia456', 'role' => 'customer'],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrNew(['username' => $data['username']]);
            $user->fill($data);
            $user->role = $role;
            $user->save();
        }
    }
}
