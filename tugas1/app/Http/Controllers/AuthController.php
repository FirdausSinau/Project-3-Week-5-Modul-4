<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // GET /login — tampilkan halaman form login
    public function showLoginForm()
    {
        return view('login');
    }

    // POST /login — proses percobaan login
    public function login(Request $request)
    {
        // Validasi input wajib diisi dan berupa string.
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cek kredensial; jika cocok, status login disimpan ke session.
        if (Auth::attempt($credentials)) {
            // Ganti ID session yang baru (cegah session fixation).
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Gagal: kembali ke form dengan pesan umum.
        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // GET /dashboard — halaman terproteksi (hanya untuk yang sudah login)
    public function dashboard()
    {
        return view('dashboard');
    }

    // POST /logout — keluar dari aplikasi
    public function logout(Request $request)
    {
        // Hapus status login dari session.
        Auth::logout();
        // Buang seluruh data session lama.
        $request->session()->invalidate();
        // Ganti token CSRF.
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
