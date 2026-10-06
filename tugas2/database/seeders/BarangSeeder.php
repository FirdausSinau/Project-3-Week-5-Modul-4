<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Isi tabel barang dengan 5 produk contoh (data minimal sesuai tugas).
     */
    public function run(): void
    {
        $produk = [
            ['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 20],
            ['nama' => 'Pulpen',     'harga' => 3000, 'stok' => 30],
            ['nama' => 'Penggaris',  'harga' => 4000, 'stok' => 15],
            ['nama' => 'Pensil 2B',  'harga' => 2500, 'stok' => 25],
            ['nama' => 'Penghapus',  'harga' => 1500, 'stok' => 40],
        ];

        foreach ($produk as $p) {
            Barang::create($p);   // mass assignment — dijaga oleh #[Fillable]
        }
    }
}
