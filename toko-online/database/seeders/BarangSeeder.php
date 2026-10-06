<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * 10 produk toko (sesuai ketentuan minimal 10 barang).
     * Satu produk sengaja berstok 0 untuk uji "stok 0 tidak dapat dibeli".
     */
    public function run(): void
    {
        $produk = [
            ['id_barang' => 'BRG-001', 'nama_barang' => 'Buku Tulis',     'deskripsi' => 'Buku tulis 38 lembar, isi 10 pcs per pak.',      'harga' => 5000,  'stok' => 20, 'gambar' => 'buku-tulis.svg'],
            ['id_barang' => 'BRG-002', 'nama_barang' => 'Pulpen',         'deskripsi' => 'Pulpen tinta hitam 0.5 mm, tulisan halus.',      'harga' => 3000,  'stok' => 30, 'gambar' => 'pulpen.svg'],
            ['id_barang' => 'BRG-003', 'nama_barang' => 'Penggaris',      'deskripsi' => 'Penggaris plastik 30 cm, skala jelas.',          'harga' => 4000,  'stok' => 15, 'gambar' => 'penggaris.svg'],
            ['id_barang' => 'BRG-004', 'nama_barang' => 'Pensil 2B',      'deskripsi' => 'Pensil kayu 2B untuk menulis dan menggambar.',   'harga' => 2500,  'stok' => 25, 'gambar' => 'pensil-2b.svg'],
            ['id_barang' => 'BRG-005', 'nama_barang' => 'Penghapus',      'deskripsi' => 'Penghapus karet lembut, tidak merusak kertas.',  'harga' => 1500,  'stok' => 40, 'gambar' => 'penghapus.svg'],
            ['id_barang' => 'BRG-006', 'nama_barang' => 'Kertas HVS A4',  'deskripsi' => 'Kertas HVS A4 70 gsm, 1 rim (500 lembar).',      'harga' => 55000, 'stok' => 10, 'gambar' => 'kertas-hvs.svg'],
            ['id_barang' => 'BRG-007', 'nama_barang' => 'Spidol',         'deskripsi' => 'Spidol permanent hitam, ujung runcing.',         'harga' => 8000,  'stok' => 12, 'gambar' => 'spidol.svg'],
            ['id_barang' => 'BRG-008', 'nama_barang' => 'Gunting',        'deskripsi' => 'Gunting kertas stainless 16 cm.',                'harga' => 12000, 'stok' => 8,  'gambar' => 'gunting.svg'],
            ['id_barang' => 'BRG-009', 'nama_barang' => 'Lem Kertas',     'deskripsi' => 'Lem kertas cair 50 ml, daya rekat kuat.',        'harga' => 6000,  'stok' => 18, 'gambar' => 'lem-kertas.svg'],
            ['id_barang' => 'BRG-010', 'nama_barang' => 'Tempat Pensil',  'deskripsi' => 'Tempat pensil kain kanvas dua kompartemen.',     'harga' => 25000, 'stok' => 0,  'gambar' => 'tempat-pensil.svg'],
        ];

        foreach ($produk as $p) {
            Barang::create($p);
        }
    }
}
