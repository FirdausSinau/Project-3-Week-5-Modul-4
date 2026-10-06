<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class TokoController extends Controller
{
    // GET / — katalog (boleh diakses siapa saja)
    public function index()
    {
        $barang = Barang::all();

        return view('index', compact('barang'));
    }

    // GET /keranjang — halaman keranjang (wajib login, dijaga middleware auth)
    public function keranjang()
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

        return view('keranjang', compact('items', 'total'));
    }

    // POST /keranjang/tambah/{id}
    public function tambah($id)
    {
        $barang         = Barang::findOrFail($id);
        $keranjang      = session('keranjang', []);
        $jumlahSekarang = $keranjang[$id] ?? 0;

        // aturan PR: jumlah tidak boleh melebihi stok
        if ($jumlahSekarang + 1 > $barang->stok) {
            return redirect()->route('toko.index')
                ->with('error', 'Stok ' . $barang->nama_barang . ' tinggal ' . $barang->stok . '.');
        }

        $keranjang[$id] = $jumlahSekarang + 1;
        session(['keranjang' => $keranjang]);

        return redirect()->route('toko.index')
            ->with('sukses', $barang->nama_barang . ' ditambahkan ke keranjang.');
    }

    // POST /keranjang/ubah/{id}/{delta} — +1 atau -1
    public function ubah($id, $delta)
    {
        $keranjang = session('keranjang', []);

        if (! isset($keranjang[$id])) {
            return redirect()->route('keranjang.index');
        }

        $barang     = Barang::find($id);
        $jumlahBaru = (int) $keranjang[$id] + (int) $delta;

        // batas stok juga dijaga saat menambah dari halaman keranjang
        if ($jumlahBaru > 0 && $barang && $jumlahBaru > $barang->stok) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Stok ' . $barang->nama_barang . ' tidak mencukupi.');
        }

        if ($jumlahBaru <= 0) {
            // Jumlah 0 berarti entri dihapus.
            unset($keranjang[$id]);
        } else {
            $keranjang[$id] = $jumlahBaru;
        }

        session(['keranjang' => $keranjang]);

        return redirect()->route('keranjang.index');
    }

    // POST /keranjang/hapus/{id}
    public function hapus($id)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$id]);
        session(['keranjang' => $keranjang]);

        return redirect()->route('keranjang.index')
            ->with('sukses', 'Item dihapus dari keranjang.');
    }

    // POST /keranjang/kosongkan
    public function kosongkan()
    {
        session()->forget('keranjang');

        return redirect()->route('keranjang.index')
            ->with('sukses', 'Keranjang dikosongkan.');
    }
}
