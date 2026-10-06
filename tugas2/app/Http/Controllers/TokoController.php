<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class TokoController extends Controller
{
    // GET / — halaman daftar barang
    public function index()
    {
        $barang     = Barang::all();                // SELECT * FROM barang
        $keranjang  = session('keranjang', []);     // isi keranjang (id => jumlah)
        $jumlahItem = array_sum($keranjang);        // total kuantitas untuk badge

        return view('index', compact('barang', 'keranjang', 'jumlahItem'));
    }

    // POST /keranjang/tambah/{id} — tambah 1 produk ke keranjang
    public function tambah($id)
    {
        $barang = Barang::findOrFail($id);          // 404 jika id tidak ada

        $keranjang = session('keranjang', []);        // 1. baca
        $keranjang[$id] = ($keranjang[$id] ?? 0) + 1; // 2. jumlah bertambah jika sudah ada
        session(['keranjang' => $keranjang]);         // 3. simpan

        return redirect()->route('toko.index')
            ->with('sukses', $barang->nama . ' ditambahkan ke keranjang.');
    }

    // GET /keranjang — halaman keranjang belanja
    public function keranjang()
    {
        $keranjang  = session('keranjang', []);
        $jumlahItem = array_sum($keranjang);

        // Session hanya menyimpan id + jumlah. Nama & harga diambil segar dari database.
        $items = [];
        $total = 0;

        foreach ($keranjang as $id => $jumlah) {
            $barang = Barang::find($id);
            if (! $barang) {
                continue; // jaga-jaga: produk sudah tidak ada di katalog
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
            unset($keranjang[$id]);      // mencapai 0 -> entri dihapus otomatis
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
