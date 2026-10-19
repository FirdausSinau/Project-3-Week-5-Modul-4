<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Role Pengguna</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f0f2f5; margin: 0; }
        header { background: #111827; color: #fff; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { margin: 0; font-size: 1.25rem; }
        header a { color: #d1d5db; text-decoration: none; margin-right: 1rem; font-size: .9rem; }
        header form { display: inline; }
        header button { background: #ef4444; color: #fff; border: 0; padding: .5rem .9rem; border-radius: 8px; cursor: pointer; }
        main { max-width: 760px; margin: 2rem auto; background: #fff; padding: 1.5rem 2rem; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.08); }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: .6rem .5rem; border-bottom: 1px solid #eee; vertical-align: middle; }
        th { font-size: .8rem; text-transform: uppercase; color: #666; }
        select { padding: .35rem .5rem; border: 1px solid #ccc; border-radius: 6px; }
        button.simpan { background: #2563eb; color: #fff; border: 0; padding: .4rem .7rem; border-radius: 6px; cursor: pointer; }
        .status { background: #e7f6e9; color: #1e7a34; border: 1px solid #bfe6c6; padding: .5rem .8rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        .error { background: #fdecea; color: #b3261e; border: 1px solid #f5c6c3; padding: .5rem .8rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; }
        .muted { color: #777; font-size: .85rem; }
    </style>
</head>
<body>
    <header>
        <h1>Kelola Role Pengguna</h1>
        <div>
            <a href="/dashboard">Dashboard</a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main>
        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        @error('role')
            <div class="error">{{ $message }}</div>
        @enderror

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Ubah Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.role.update', $user) }}">
                                @csrf
                                @method('PATCH')
                                <select name="role">
                                    <option value="customer" @selected($user->role === 'customer')>customer</option>
                                    <option value="staff" @selected($user->role === 'staff')>staff</option>
                                </select>
                                <button class="simpan" type="submit">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="muted">Role admin tidak ditampilkan di sini dan tidak dapat diubah dari fitur ini.</p>
    </main>
</body>
</html>
