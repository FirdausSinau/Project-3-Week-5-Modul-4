<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class PesananController extends Controller
{
    // GET /riwayat — daftar pesanan milik user yang sedang login
    public function index()
    {
        // Pesanan milik user aktif (terbaru dulu) beserta detailnya.
        $pesanan = auth()->user()->pesanans()
            ->with('details')
            ->latest('tanggal_order')
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
