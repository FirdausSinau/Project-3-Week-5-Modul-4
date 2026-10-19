<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ---------- Pintu untuk TAMU (belum login) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ---------- Pintu untuk PENGGUNA yang sudah login ----------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Role management: hanya admin (ability manage-roles).
Route::middleware('can:manage-roles')->group(function () {
    Route::get('/admin/users', [RoleController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])->name('admin.users.role.update');
    });

    // Simulasi cart stateless W06: hanya customer (ability use-cart).
Route::middleware('can:use-cart')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    });
});
