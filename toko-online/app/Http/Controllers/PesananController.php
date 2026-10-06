<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class PesananController extends Controller
{
    // GET /riwayat — daftar pesanan milik user yang sedang login
    public function index()
    {
        $pesanan = auth()->user()->pesanans()     // relasi -> otomatis WHERE id_user = user aktif
            ->with('details')                     // eager loading (hindari N+1)
            ->latest('tanggal_order')             // terbaru di atas
            ->get();

        return view('riwayat.index', compact('pesanan'));
    }

    // GET /pesanan/{id_order} — detail satu pesanan (hanya milik user yang login)
    public function show(Pesanan $pesanan)
    {
        // otorisasi: cegah user melihat pesanan orang lain
        abort_if($pesanan->id_user !== auth()->id(), 403, 'Ini bukan pesanan Anda.');

        $pesanan->load(['details.barang', 'user']);

        return view('pesanan.show', compact('pesanan'));
    }
}
