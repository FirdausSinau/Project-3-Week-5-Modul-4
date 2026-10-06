<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ---------- Pintu untuk TAMU (belum login) ----------
Route::middleware('guest')->group(function () {
    // GET /login — tampilkan form. Nama 'login' WAJIB: satpam auth mencari
    // rute ber-nama ini untuk menendang tamu yang mencoba akses halaman terproteksi.
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // POST /login — proses submit form login
    Route::post('/login', [AuthController::class, 'login']);
});

// ---------- Pintu untuk PENGGUNA yang sudah login ----------
Route::middleware('auth')->group(function () {
    // GET /dashboard — halaman terproteksi
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    // POST /logout — keluar. Sengaja POST, bukan link GET (kita bahas kenapa nanti!)
    Route::post('/logout', [AuthController::class, 'logout']);
});
