@extends('layouts.app')

@section('judul', 'Keranjang — Toko Alat Tulis')

@section('konten')
    <style>
        .panel { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .baris { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; border-bottom: 1px solid #eee; }
        .baris:last-child { border-bottom: 0; }
        .baris img { width: 56px; height: 56px; border-radius: 8px; object-fit: cover; }
        .baris .nama { flex: 1; font-weight: 600; }
        .hitung { color: #444; font-size: .95rem; }
        .aksi { display: flex; align-items: center; gap: .35rem; }
        .aksi form { display: inline; margin: 0; }
        .qty { min-width: 1.5rem; text-align: center; font-weight: 700; }
        .btn { border: 0; border-radius: 6px; cursor: pointer; font-size: .85rem; padding: .35rem .6rem; background: #2563eb; color: #fff; }
        .btn:hover { background: #1d4ed8; }
        .btn.merah { background: #ef4444; }
        .btn.merah:hover { background: #dc2626; }
        .kosong { padding: 2rem; text-align: center; color: #777; }
        .total { display: flex; justify-content: space-between; background: #fff; border-radius: 12px; padding: 1rem 1.25rem; margin-top: 1rem; font-size: 1.05rem; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
        .bawah { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
        .bawah a { color: #2563eb; text-decoration: none; font-size: .9rem; }
        .bawah a:hover { text-decoration: underline; }
    </style>

    <h1>Keranjang Belanja</h1>

    <div class="panel">
        @forelse ($items as $item)
            <div class="baris">
                <img src="{{ asset('produk/' . $item['barang']->gambar) }}" alt="">
                <div class="nama">{{ $item['barang']->nama_barang }}</div>
                <div class="hitung">
                    Rp {{ number_format($item['barang']->harga, 0, ',', '.') }}
                    x {{ $item['jumlah'] }}
                    = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                </div>

                <div class="aksi">
                    <form method="POST" action="{{ route('keranjang.ubah', [$item['barang']->id_barang, -1]) }}">
                        @csrf
                        <button class="btn" type="submit" title="Kurangi">−</button>
                    </form>

                    <span class="qty">{{ $item['jumlah'] }}</span>

                    <form method="POST" action="{{ route('keranjang.ubah', [$item['barang']->id_barang, 1]) }}">
                        @csrf
                        <button class="btn" type="submit" title="Tambah">+</button>
                    </form>

                    <form method="POST" action="{{ route('keranjang.hapus', $item['barang']->id_barang) }}">
                        @csrf
                        <button class="btn merah" type="submit" title="Hapus item">hps</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="kosong">Keranjang kosong. <a href="{{ route('toko.index') }}">Mulai belanja</a></div>
        @endforelse
    </div>

    @if (count($items) > 0)
        <div class="total">
            <span>Total</span>
            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
        </div>

        <div class="bawah">
            <a href="{{ route('toko.index') }}">&larr; Lanjut belanja</a>

            <div style="display: flex; gap: .5rem; align-items: center;">
                <form method="POST" action="{{ route('keranjang.kosongkan') }}">
                    @csrf
                    <button class="btn merah" type="submit">Kosongkan keranjang</button>
                </form>

                <a href="{{ route('checkout.form') }}" class="btn" style="text-decoration: none; padding: .5rem .9rem;">Checkout &rarr;</a>
            </div>
        </div>
    @else
        <div class="bawah">
            <a href="{{ route('toko.index') }}">&larr; Kembali ke katalog</a>
        </div>
    @endif
@endsection
