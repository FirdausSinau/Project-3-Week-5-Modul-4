<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Toko Alat Tulis')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; margin: 0; }
        header { background: #111827; color: #fff; padding: .9rem 1.5rem; display: flex; align-items: center; gap: 1rem; }
        header .brand { font-weight: 700; text-decoration: none; color: #fff; font-size: 1.1rem; }
        header .spacer { flex: 1; }
        header a.link { color: #d1d5db; text-decoration: none; font-size: .9rem; }
        header a.link:hover { color: #fff; }
        .badge { background: #2563eb; color: #fff; padding: .35rem .8rem; border-radius: 999px; text-decoration: none; font-size: .85rem; }
        .badge:hover { background: #1d4ed8; }
        .hello { font-size: .9rem; color: #d1d5db; }
        header form { display: inline; }
        header button { background: #ef4444; color: #fff; border: 0; padding: .4rem .8rem; border-radius: 8px; cursor: pointer; font-size: .85rem; }
        header button:hover { background: #dc2626; }
        .container { max-width: 960px; margin: 1.5rem auto; padding: 0 1rem; }
        .flash-ok { background: #e7f6e9; color: #1e7a34; border: 1px solid #bfe6c6; padding: .6rem .9rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        .flash-err { background: #fdecea; color: #b3261e; border: 1px solid #f5c6c3; padding: .6rem .9rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
    </style>
</head>
<body>
    <header>
        <a class="brand" href="{{ route('toko.index') }}">Toko Alat Tulis</a>
        <span class="spacer"></span>

        {{-- badge keranjang: dihitung langsung dari session --}}
        <a class="badge" href="{{ route('keranjang.index') }}">Keranjang ({{ array_sum(session('keranjang', [])) }})</a>

        @auth
            {{-- HANYA untuk yang sudah login --}}
            <a class="link" href="{{ route('riwayat.index') }}">Riwayat</a>
            <span class="hello">Halo, {{ auth()->user()->nama_lengkap }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            {{-- HANYA untuk tamu --}}
            <a class="link" href="{{ route('login') }}">Masuk</a>
        @endauth
    </header>

    <div class="container">
        @if (session('sukses'))
            <div class="flash-ok">{{ session('sukses') }}</div>
        @endif
        @if (session('error'))
            <div class="flash-err">{{ session('error') }}</div>
        @endif

        @yield('konten')   {{-- 🕳️ lubang: isi unik tiap halaman --}}
    </div>
</body>
</html>
