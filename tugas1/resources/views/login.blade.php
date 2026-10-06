<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.08); width: 360px; }
        h1 { margin: 0 0 .25rem; }
        .subtitle { color: #666; margin: 0 0 1.25rem; }
        .alert { background: #fdecea; color: #b3261e; border: 1px solid #f5c6c3; padding: .6rem .8rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        label { display: block; font-weight: 600; margin: .75rem 0 .25rem; font-size: .9rem; }
        input { width: 100%; padding: .6rem .7rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; }
        button { width: 100%; margin-top: 1.25rem; padding: .7rem; background: #2563eb; color: #fff; border: 0; border-radius: 8px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <p class="subtitle">Masuk untuk membuka dashboard</p>

        {{-- Pesan gagal login, dikirim AuthController lewat withErrors(['login' => ...]) --}}
        @error('login')
            <div class="alert">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            {{-- Token CSRF: wajib untuk semua form POST. --}}
            @csrf

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>
