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
        // Isi data awal: akun pembeli + 10 produk toko
        $this->call([
            UserSeeder::class,
            BarangSeeder::class,
        ]);
    }
}
