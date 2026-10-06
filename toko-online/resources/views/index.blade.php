@extends('layouts.app')

@section('judul', 'Katalog — Toko Alat Tulis')

@section('konten')
    <style>
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
        .kartu { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.06); display: flex; flex-direction: column; }
        .kartu img { width: 100%; height: 140px; object-fit: cover; display: block; }
        .kartu .info { padding: .9rem 1rem 1rem; display: flex; flex-direction: column; gap: .25rem; flex: 1; }
        .kartu .nama { font-weight: 600; }
        .kartu .harga { color: #1d4ed8; font-weight: 700; }
        .kartu .stok { color: #666; font-size: .85rem; margin-bottom: .5rem; }
        .beli { display: block; text-align: center; padding: .55rem; border-radius: 8px; border: 0; font-size: .9rem; cursor: pointer; text-decoration: none; background: #2563eb; color: #fff; margin-top: auto; }
        .beli:hover { background: #1d4ed8; }
        .beli.mati { background: #d1d5db; color: #6b7280; cursor: not-allowed; }
        .beli.masuk { background: #f59e0b; }
        .beli.masuk:hover { background: #d97706; }
        form { margin: 0; }
    </style>

    <h1>Daftar Barang</h1>

    <div class="grid">
        @foreach ($barang as $b)
            <div class="kartu">
                <img src="{{ asset('produk/' . $b->gambar) }}" alt="{{ $b->nama_barang }}">

                <div class="info">
                    <div class="nama">{{ $b->nama_barang }}</div>
                    <div class="harga">Rp {{ number_format($b->harga, 0, ',', '.') }}</div>
                    <div class="stok">Stok: {{ $b->stok }}</div>

                    @if ($b->stok <= 0)
                        {{-- stok habis: tombol mati --}}
                        <button class="beli mati" disabled>Stok habis</button>
                    @elseif (auth()->check())
                        {{-- sudah login: tombol beli sungguhan (POST + CSRF) --}}
                        <form method="POST" action="{{ route('keranjang.tambah', $b->id_barang) }}">
                            @csrf
                            <button class="beli" type="submit">Masuk ke keranjang</button>
                        </form>
                    @else
                        {{-- tamu: diarahkan login dulu --}}
                        <a class="beli masuk" href="{{ route('login') }}">Masuk untuk membeli</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
