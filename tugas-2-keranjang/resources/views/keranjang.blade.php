<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; margin: 0; padding: 2rem 1rem; }
        .container { max-width: 720px; margin: 0 auto; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        h1 { margin: 0; font-size: 1.4rem; }
        .badge-abu { background: #e5e7eb; color: #444; padding: .4rem .9rem; border-radius: 999px; font-size: .85rem; }
        .pesan { background: #e7f6e9; color: #1e7a34; border: 1px solid #bfe6c6; padding: .6rem .9rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        .produk { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .item { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.25rem; border-bottom: 1px solid #eee; }
        .item:last-child { border-bottom: 0; }
        .nama { flex: 1; font-weight: 600; }
        .hitung { color: #444; font-size: .95rem; }
        .aksi { display: flex; align-items: center; gap: .35rem; }
        .aksi form { display: inline; }
        .qty { min-width: 1.5rem; text-align: center; font-weight: 700; }
        button { border: 0; border-radius: 6px; cursor: pointer; font-size: .85rem; padding: .35rem .6rem; background: #2563eb; color: #fff; }
        button:hover { background: #1d4ed8; }
        button.merah { background: #ef4444; }
        button.merah:hover { background: #dc2626; }
        .kosong { padding: 2rem; text-align: center; color: #777; }
        .total { display: flex; justify-content: space-between; background: #fff; border-radius: 12px; padding: 1rem 1.25rem; margin-top: 1rem; font-size: 1.05rem; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
        .bawah { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
        .bawah a { color: #2563eb; text-decoration: none; font-size: .9rem; }
        .bawah a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Keranjang belanja</h1>
            <span class="badge-abu">Tanpa login</span>
        </header>

        @if (session('sukses'))
            <div class="pesan">{{ session('sukses') }}</div>
        @endif

        <div class="produk">
            @forelse ($items as $item)
                <div class="item">
                    <div class="nama">{{ $item['barang']->nama }}</div>
                    <div class="hitung">
                        Rp {{ number_format($item['barang']->harga, 0, ',', '.') }}
                        x {{ $item['jumlah'] }}
                        = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>

                    <div class="aksi">
                        <form method="POST" action="{{ route('keranjang.ubah', [$item['barang']->id, -1]) }}">
                            @csrf
                            <button type="submit" title="Kurangi">−</button>
                        </form>

                        <span class="qty">{{ $item['jumlah'] }}</span>

                        <form method="POST" action="{{ route('keranjang.ubah', [$item['barang']->id, 1]) }}">
                            @csrf
                            <button type="submit" title="Tambah">+</button>
                        </form>

                        <form method="POST" action="{{ route('keranjang.hapus', $item['barang']->id) }}">
                            @csrf
                            <button type="submit" class="merah" title="Hapus item">hps</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="kosong">Keranjang kosong.</div>
            @endforelse
        </div>

        @if ($jumlahItem > 0)
            <div class="total">
                <span>Total</span>
                <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>

            <div class="bawah">
                <a href="{{ route('toko.index') }}">&larr; Lanjut belanja</a>

                <form method="POST" action="{{ route('keranjang.kosongkan') }}">
                    @csrf
                    <button type="submit" class="merah">Kosongkan keranjang</button>
                </form>
            </div>
        @else
            <div class="bawah">
                <a href="{{ route('toko.index') }}">&larr; Kembali ke daftar barang</a>
            </div>
        @endif
    </div>
</body>
</html>
