@extends('layouts.app')

@section('judul', 'Pesanan ' . $pesanan->id_order)

@section('konten')
    <style>
        .meta { display: flex; gap: 2.5rem; flex-wrap: wrap; background: #fff; padding: 1rem 1.25rem; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); margin-bottom: 1rem; font-size: .95rem; }
        .meta .label { color: #777; font-size: .78rem; text-transform: uppercase; letter-spacing: .03em; margin-bottom: .15rem; }
        .panel { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .baris { display: flex; justify-content: space-between; align-items: center; padding: .85rem 1.25rem; border-bottom: 1px solid #eee; }
        .baris:last-child { border-bottom: 0; }
        .sub { color: #777; font-size: .85rem; }
        .total-box { display: flex; justify-content: space-between; background: #fff; border-radius: 12px; padding: 1rem 1.25rem; margin-top: 1rem; font-size: 1.05rem; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    </style>

    <h1>Pesanan {{ $pesanan->id_order }}</h1>

    <div class="meta">
        <div>
            <div class="label">Tanggal</div>
            {{ $pesanan->tanggal_order }}
        </div>
        <div>
            <div class="label">Pembeli</div>
            {{ $pesanan->user->nama_lengkap }}
        </div>
        <div>
            <div class="label">Alamat pengiriman</div>
            {{ $pesanan->alamat_pengiriman }}
        </div>
    </div>

    <div class="panel">
        @foreach ($pesanan->details as $d)
            <div class="baris">
                <div>
                    <div>{{ $d->barang->nama_barang }}</div>
                    <div class="sub">
                        Rp {{ number_format($d->harga_satuan, 0, ',', '.') }} &times; {{ $d->jumlah_beli }}
                        — harga arsip saat dibeli
                    </div>
                </div>
                <strong>Rp {{ number_format($d->harga_satuan * $d->jumlah_beli, 0, ',', '.') }}</strong>
            </div>
        @endforeach
    </div>

    <div class="total-box">
        <span>Total</span>
        <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
    </div>
@endsection
