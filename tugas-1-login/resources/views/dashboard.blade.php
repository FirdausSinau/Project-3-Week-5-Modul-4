<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; margin: 0; }
        header { background: #111827; color: #fff; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.25rem; }
        header button { background: #ef4444; color: #fff; border: 0; padding: .5rem .9rem; border-radius: 8px; cursor: pointer; }
        header button:hover { background: #dc2626; }
        main { max-width: 640px; margin: 2rem auto; background: #fff; padding: 1.5rem 2rem; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        .hello { font-size: 1.25rem; }
        .muted { color: #666; }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>

        {{-- Logout = form POST + @csrf, bukan link biasa (pertahanan CSRF!) --}}
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <p class="hello">Selamat datang, <strong>{{ auth()->user()->nama_lengkap }}</strong>!</p>
        <p class="muted">Halaman ini hanya bisa dibuka setelah login.</p>
        <p>Username: <strong>{{ auth()->user()->username }}</strong></p>
    </main>
</body>
</html>
