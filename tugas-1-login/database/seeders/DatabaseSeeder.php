<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username'     => 'budi',
            // Password mentah, otomatis di-hash oleh cast.
            'password'     => 'rahasia123',
            'nama_lengkap' => 'Budi Santoso',
        ]);

        User::create([
            'username'     => 'siti',
            'password'     => 'rahasia456',
            'nama_lengkap' => 'Siti Aminah',
        ]);
    }
}
