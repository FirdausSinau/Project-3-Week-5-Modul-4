<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // GET /checkout — halaman konfirmasi + form alamat pengiriman
    public function form()
    {
        [$items, $total] = $this->ringkasanKeranjang();

        if (empty($items)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        return view('checkout', compact('items', 'total'));
    }

    // POST /checkout — jalankan checkout lewat service (transaksi database)
    public function store(Request $request, CheckoutService $checkout)
    {
        $validated = $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:255'],
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        try {
            $pesanan = $checkout->proses(auth()->user(), $keranjang, $validated['alamat_pengiriman']);
        } catch (\Exception $e) {
            // transaksi otomatis di-rollback; user melihat pesan errornya
            return redirect()->route('keranjang.index')->with('error', $e->getMessage());
        }

        // keranjang (session) bukan bagian transaksi DB -> dibersihkan controller setelah sukses
        session()->forget('keranjang');

        return redirect()->route('pesanan.show', $pesanan)
            ->with('sukses', 'Pesanan ' . $pesanan->id_order . ' berhasil dibuat!');
    }

    // ringkasan keranjang untuk halaman konfirmasi
    private function ringkasanKeranjang(): array
    {
        $keranjang = session('keranjang', []);
        $items = [];
        $total = 0;

        foreach ($keranjang as $id => $jumlah) {
            $barang = Barang::find($id);
            if (! $barang) {
                continue;
            }

            $subtotal = $barang->harga * $jumlah;
            $items[]  = compact('barang', 'jumlah', 'subtotal');
            $total   += $subtotal;
        }

        return [$items, $total];
    }
}
