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
        // 1. Validasi input: wajib diisi, harus berupa string
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Auth::attempt: cari user by username -> Hash::check password
        //    -> jika cocok, SIMPAN status login ke session (di server)
        if (Auth::attempt($credentials)) {
            // 3. Ganti ID session yang baru (cegah session fixation)
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // 4. Gagal: kembali ke form, pesan umum (tidak menyebut mana yang salah),
        //    dan isi ulang kolom username supaya user tidak mengetik lagi
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
        Auth::logout();                            // hapus status login dari session
        $request->session()->invalidate();         // buang seluruh data session lama di server
        $request->session()->regenerateToken();    // ganti token CSRF agar token lama tidak bisa dipakai

        return redirect('/login');
    }
}
