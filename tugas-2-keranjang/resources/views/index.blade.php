<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Tulis</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; margin: 0; padding: 2rem 1rem; }
        .container { max-width: 720px; margin: 0 auto; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        h1 { margin: 0; font-size: 1.5rem; }
        .badge { background: #2563eb; color: #fff; padding: .45rem .9rem; border-radius: 999px; text-decoration: none; font-size: .9rem; }
        .badge:hover { background: #1d4ed8; }
        .pesan { background: #e7f6e9; color: #1e7a34; border: 1px solid #bfe6c6; padding: .6rem .9rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        .produk { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .item { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; border-bottom: 1px solid #eee; }
        .item:last-child { border-bottom: 0; }
        .img { width: 48px; height: 48px; border-radius: 8px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .nama { flex: 1; font-weight: 600; }
        .harga { color: #444; }
        button { background: #2563eb; color: #fff; border: 0; padding: .5rem .9rem; border-radius: 8px; cursor: pointer; font-size: .9rem; }
        button:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Toko Alat Tulis</h1>
            <a class="badge" href="{{ route('keranjang.index') }}">Keranjang ({{ $jumlahItem }})</a>
        </header>

        {{-- pesan flash dari session (sekali tampil, lalu hilang) --}}
        @if (session('sukses'))
            <div class="pesan">{{ session('sukses') }}</div>
        @endif

        <div class="produk">
            @foreach ($barang as $p)
                <div class="item">
                    <div class="img">📦</div>
                    <div class="nama">{{ $p->nama }}</div>
                    <div class="harga">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>

                    {{-- Aksi mengubah data: POST + @csrf --}}
                    <form method="POST" action="{{ route('keranjang.tambah', $p->id) }}">
                        @csrf
                        <button type="submit">Masukkan ke keranjang</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
