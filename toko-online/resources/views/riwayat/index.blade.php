@extends('layouts.app')

@section('judul', 'Riwayat Pesanan — Toko Alat Tulis')

@section('konten')
    <style>
        .panel { background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); overflow: hidden; }
        .baris { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; border-bottom: 1px solid #eee; }
        .baris:last-child { border-bottom: 0; }
        .judul-pesanan { font-weight: 600; }
        .sub { color: #777; font-size: .85rem; }
        .kanan { text-align: right; }
        .total { color: #1d4ed8; font-weight: 700; }
        .kosong { padding: 2rem; text-align: center; color: #777; }
    </style>

    <h1>Riwayat Pesanan</h1>

    <div class="panel">
        @forelse ($pesanan as $p)
            <div class="baris">
                <div>
                    <div class="judul-pesanan">{{ $p->id_order }}</div>
                    <div class="sub">{{ $p->tanggal_order }} — {{ $p->details->sum('jumlah_beli') }} barang</div>
                </div>
                <div class="kanan">
                    <div class="total">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</div>
                    <a class="sub" href="{{ route('pesanan.show', $p) }}">Lihat detail &rarr;</a>
                </div>
            </div>
        @empty
            <div class="kosong">Belum ada pesanan. <a href="{{ route('toko.index') }}">Mulai belanja</a></div>
        @endforelse
    </div>
@endsection
