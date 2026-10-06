<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // GET /login — tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // POST /login — proses percobaan login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();   // tiket baru (anti session fixation)

            // kembali ke halaman yang tadi dituju; kalau tidak ada -> katalog
            return redirect()->intended(route('toko.index'));
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // POST /logout — keluar
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('toko.index');
    }
}
