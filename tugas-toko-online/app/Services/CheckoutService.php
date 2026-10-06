<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Proses checkout: 5 langkah database dalam SATU transaksi (all-or-nothing).
     */
    public function proses(User $user, array $keranjang, string $alamat): Pesanan
    {
        return DB::transaction(function () use ($user, $keranjang, $alamat) {

            // 1. buat pesanan (total diisi sementara 0)
            $pesanan = Pesanan::create([
                'id_order'          => 'ORD-' . strtoupper(Str::random(6)),
                'id_user'           => $user->id_user,
                'tanggal_order'     => now(),
                'total_harga'       => 0,
                'alamat_pengiriman' => $alamat,
            ]);

            $total = 0;

            foreach ($keranjang as $id => $jumlah) {
                $barang = Barang::findOrFail($id);

                // 2. validasi stok TERAKHIR di server (bisa berubah sejak masuk keranjang)
                if ($barang->stok < $jumlah) {
                    throw new \Exception('Stok ' . $barang->nama_barang . ' tidak mencukupi (tersisa ' . $barang->stok . ').');
                }

                // 3. simpan rincian + ARSIP harga saat ini
                DetailPesanan::create([
                    'id_order'     => $pesanan->id_order,
                    'id_barang'    => $barang->id_barang,
                    'harga_satuan' => $barang->harga,
                    'jumlah_beli'  => $jumlah,
                ]);

                // 4. kurangi stok
                $barang->decrement('stok', $jumlah);

                // 5. akumulasi total (harga dari DATABASE, bukan dari browser)
                $total += $barang->harga * $jumlah;
            }

            // simpan total akhir
            $pesanan->update(['total_harga' => $total]);

            return $pesanan;
        });
    }
}
