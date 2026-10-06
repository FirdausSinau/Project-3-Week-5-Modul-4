<?php

use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

// Halaman daftar barang (toko)
Route::get('/', [TokoController::class, 'index'])->name('toko.index');

// Halaman keranjang (hanya membaca -> GET)
Route::get('/keranjang', [TokoController::class, 'keranjang'])->name('keranjang.index');

// Aksi keranjang = MENGUBAH data -> POST + @csrf
Route::post('/keranjang/tambah/{id}', [TokoController::class, 'tambah'])->name('keranjang.tambah');

Route::post('/keranjang/ubah/{id}/{delta}', [TokoController::class, 'ubah'])
    ->whereIn('delta', ['1', '-1'])          // hanya izinkan +1 / -1
    ->name('keranjang.ubah');

Route::post('/keranjang/hapus/{id}', [TokoController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/kosongkan', [TokoController::class, 'kosongkan'])->name('keranjang.kosongkan');
