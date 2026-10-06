<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

// Katalog — bebas diakses siapa saja (tamu boleh melihat)
Route::get('/', [TokoController::class, 'index'])->name('toko.index');

// Pintu login (untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Area wajib login (dijaga middleware auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/keranjang', [TokoController::class, 'keranjang'])->name('keranjang.index');

    // aksi mengubah data -> POST + @csrf
    Route::post('/keranjang/tambah/{id}', [TokoController::class, 'tambah'])->name('keranjang.tambah');

    Route::post('/keranjang/ubah/{id}/{delta}', [TokoController::class, 'ubah'])
        ->whereIn('delta', ['1', '-1'])
        ->name('keranjang.ubah');

    Route::post('/keranjang/hapus/{id}', [TokoController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/kosongkan', [TokoController::class, 'kosongkan'])->name('keranjang.kosongkan');

    // checkout: GET = halaman konfirmasi, POST = proses pesanan
    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // riwayat pesanan
    Route::get('/riwayat', [PesananController::class, 'index'])->name('riwayat.index');

    // detail pesanan
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
});
