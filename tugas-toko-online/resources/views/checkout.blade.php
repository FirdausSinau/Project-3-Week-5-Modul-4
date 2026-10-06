@extends('layouts.app')

@section('judul', 'Checkout — Toko Alat Tulis')

@section('konten')
    <style>
        .panel { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .baris { display: flex; justify-content: space-between; padding: .85rem 1.25rem; border-bottom: 1px solid #eee; }
        .baris:last-child { border-bottom: 0; }
        .total-box { display: flex; justify-content: space-between; background: #fff; border-radius: 12px; padding: 1rem 1.25rem; margin: 1rem 0; font-size: 1.05rem; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
        label { display: block; font-weight: 600; margin-bottom: .35rem; font-size: .9rem; }
        textarea { width: 100%; padding: .6rem .7rem; border: 1px solid #ccc; border-radius: 8px; font-size: .95rem; font-family: inherit; resize: vertical; }
        .btn { border: 0; border-radius: 8px; cursor: pointer; padding: .65rem 1.1rem; background: #16a34a; color: #fff; font-size: .95rem; }
        .btn:hover { background: #15803d; }
        .kembali { color: #2563eb; text-decoration: none; font-size: .9rem; }
        .kembali:hover { text-decoration: underline; }
    </style>

    <h1>Checkout</h1>

    <div class="panel">
        @foreach ($items as $item)
            <div class="baris">
                <span>{{ $item['barang']->nama_barang }} &times; {{ $item['jumlah'] }}</span>
                <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    <div class="total-box">
        <span>Total bayar (tanpa ongkir)</span>
        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    <div class="panel" style="padding: 1.25rem;">
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <label for="alamat_pengiriman">Alamat pengiriman</label>
            <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <a class="kembali" href="{{ route('keranjang.index') }}">&larr; Kembali ke keranjang</a>
                <button class="btn" type="submit">Buat Pesanan</button>
            </div>
        </form>
    </div>
@endsection
