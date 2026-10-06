<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class TokoController extends Controller
{
    // GET / — halaman daftar barang
    public function index()
    {
        // Ambil barang dan isi keranjang dari session.
        $barang     = Barang::all();
        $keranjang  = session('keranjang', []);
        $jumlahItem = array_sum($keranjang);

        return view('index', compact('barang', 'keranjang', 'jumlahItem'));
    }

    // POST /keranjang/tambah/{id} — tambah 1 produk ke keranjang
    public function tambah($id)
    {
        // 404 otomatis jika produk tidak ada.
        $barang = Barang::findOrFail($id);

        // Tambah satu ke jumlah produk di session.
        $keranjang = session('keranjang', []);
        $keranjang[$id] = ($keranjang[$id] ?? 0) + 1;
        session(['keranjang' => $keranjang]);

        return redirect()->route('toko.index')
            ->with('sukses', $barang->nama . ' ditambahkan ke keranjang.');
    }

    // GET /keranjang — halaman keranjang belanja
    public function keranjang()
    {
        $keranjang  = session('keranjang', []);
        $jumlahItem = array_sum($keranjang);

        // Nama dan harga selalu diambil dari database.
        $items = [];
        $total = 0;

        foreach ($keranjang as $id => $jumlah) {
            $barang = Barang::find($id);
            if (! $barang) {
                // Lewati produk yang sudah tidak ada di katalog.
                continue;
            }

            $subtotal = $barang->harga * $jumlah;
            $items[]  = compact('barang', 'jumlah', 'subtotal');
            $total   += $subtotal;
        }

        return view('keranjang', compact('items', 'total', 'jumlahItem'));
    }

    // POST /keranjang/ubah/{id}/{delta} — tambah (+) atau kurangi (-) jumlah
    public function ubah($id, $delta)
    {
        $keranjang = session('keranjang', []);

        if (! isset($keranjang[$id])) {
            return redirect()->route('keranjang.index');
        }

        $jumlahBaru = (int) $keranjang[$id] + (int) $delta;

        if ($jumlahBaru <= 0) {
            // Jumlah 0 berarti entri dihapus.
            unset($keranjang[$id]);
        } else {
            $keranjang[$id] = $jumlahBaru;
        }

        session(['keranjang' => $keranjang]);

        return redirect()->route('keranjang.index');
    }

    // POST /keranjang/hapus/{id} — hapus satu item
    public function hapus($id)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$id]);
        session(['keranjang' => $keranjang]);

        return redirect()->route('keranjang.index')
            ->with('sukses', 'Item dihapus dari keranjang.');
    }

    // POST /keranjang/kosongkan — hapus semua item
    public function kosongkan()
    {
        session()->forget('keranjang');

        return redirect()->route('keranjang.index')
            ->with('sukses', 'Keranjang dikosongkan.');
    }
}
