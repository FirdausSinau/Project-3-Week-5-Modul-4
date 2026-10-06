# LAPORAN MODUL 4 — PENYIMPANAN DATA PADA WEB
## Cookies, Session, dan Local Storage

- **Nama:** Ananda Firdaus
- **NIM:** 251511003
- **Repositori:** https://github.com/FirdausSinau/Project-3-Week-5-Modul-4

> *Catatan draf: ganti setiap penanda 📸 dengan screenshot, lalu hapus baris catatan ini sebelum dikumpulkan. Laporan final disimpan sebagai `251511003_Ananda Firdaus_Laporan_Modul4.docx`.*

---

## Daftar Isi
1. Tugas 1 — Login dengan Password Terenkripsi
2. Tugas 2 — Keranjang Belanja Tanpa Login
3. PR — Program Toko Online
4. Lampiran — Akun Uji

---

# 1. TUGAS 1 — Login dengan Password Terenkripsi

## Ringkasan Implementasi
Aplikasi dibuat dengan **Laravel 13 + MySQL** (folder `tugas1/`), tanpa starter kit — seluruh logika login ditulis sendiri.

- **Tabel `users`** (`id`, `username` unik, `password`, `nama_lengkap`, timestamps) dibuat via **migration**.
- **Seeder** mengisi 2 user; password ditulis mentah di seeder dan otomatis di-hash oleh cast `'password' => 'hashed'` pada model `User`.
- **`AuthController`**: `GET /login` (form), `POST /login` (`Auth::attempt` + `session()->regenerate()`), `GET /dashboard`, `POST /logout` (`Auth::logout()` + `invalidate()` + `regenerateToken()`).
- **Middleware `auth`** melindungi `/dashboard` & `/logout`; **middleware `guest`** melindungi `/login`. Rute login diberi nama `login` (dibutuhkan middleware `auth` untuk mengarahkan tamu).
- Tampilan memakai **Blade**: `login.blade.php` dan `dashboard.blade.php`.

## Jawaban Pertanyaan

**a. Mengapa password harus di-hash? Jelaskan isi kolom password pada tabel users.**

Hash bersifat **satu arah** — tidak dapat dikembalikan ke bentuk aslinya (berbeda dengan enkripsi yang dapat didekripsi dengan kunci). Kolom `password` pada tabel `users` berisi string hash bcrypt, misalnya `$2y$12$hUTAM0jB...`. Struktur tersebut berarti: `$2y$` = algoritma bcrypt, `12` = cost factor, diikuti salt dan hasil hash. Password asli (misalnya `rahasia123`) tidak pernah tersimpan di database. Saat login, sistem tidak "membuka" hash, melainkan **meng-hash ulang** input lalu membandingkannya (`Hash::check`). Dengan demikian, jika database bocor, password pengguna tetap aman. Salt acak mencegah serangan tabel hash siap pakai (*rainbow table*), dan cost 12 membuat brute force menjadi sangat lambat.

**b. Mengapa logout memakai metode POST dengan @csrf, bukan link biasa?**

Logout **mengubah keadaan** (menghapus sesi), sedangkan method `GET` semestinya hanya untuk membaca data. Link GET dapat dipicu secara diam-diam oleh situs lain, misalnya `<img src="http://toko/logout">`, sehingga browser korban mengirim request yang membawa cookie sesinya dan korban ter-logout paksa — inilah serangan **CSRF**. Dengan `POST` + token `@csrf`, server memverifikasi token rahasia yang hanya diketahui halaman sendiri; request tanpa token valid ditolak (error 419). Token tidak dapat dibaca penyerang karena *same-origin policy*.

**c. Apa fungsi middleware auth dan guest? Apa yang terjadi jika /dashboard dibuka tanpa login?**

Middleware `auth` adalah "pintu" yang hanya mengizinkan pengguna yang **sudah login**; pengguna yang belum login dialihkan ke route bernama `login`. Middleware `guest` berlaku sebaliknya: pengguna yang **sudah login** tidak boleh membuka halaman login dan akan diarahkan ke dashboard. Jika `/dashboard` dibuka tanpa login, pengguna otomatis dilempar ke `/login`; setelah berhasil login, Laravel mengembalikannya ke `/dashboard` berkat fitur **intended** (`redirect()->intended()`).

**d. Apa fungsi session()->regenerate() setelah login berhasil?**

`session()->regenerate()` mengganti **ID sesi (tiket)** lama dengan yang baru, tanpa menghilangkan data sesi (Laravel juga mengganti token CSRF-nya). Tujuannya mencegah **session fixation**: bila penyerang sempat mengetahui atau menanamkan ID sesi sebelum korban login, ID lama tersebut menjadi tidak valid setelah regenerasi sehingga tidak dapat dipakai untuk membajak sesi yang sudah login.

## Screenshot
- 📸 Isi tabel `users` — kolom password berupa hash (`$2y$12$...`)
- 📸 Login gagal — pesan "Username atau password salah."
- 📸 Login berhasil — diarahkan ke dashboard
- 📸 Halaman dashboard — "Selamat datang, Budi Santoso!"
- 📸 `/dashboard` dibuka di jendela incognito tanpa login — dialihkan ke `/login`
- 📸 Setelah logout — kembali ke halaman login

---

# 2. TUGAS 2 — Keranjang Belanja Tanpa Login

## Mekanisme yang Dipilih: **Session**

Isi keranjang hanya menyimpan **id produk dan jumlah**; nama dan harga selalu diambil segar dari tabel `barang` (MySQL). Data keranjang disimpan **di server** (tabel `sessions`), sedangkan browser hanya membawa tiket sesi (`laravel-session`) yang nilainya acak dan terenkripsi.

## Jawaban Pertanyaan

**1. Mekanisme apa yang dipilih, dan mengapa?**

Saya memilih **session**. Seluruh isi keranjang tersimpan di server sehingga pengguna **tidak dapat memanipulasi jumlah barang** dari sisi browser. Terbukti saat pengujian: payload session di server berisi `"keranjang":{"1":2}`, sementara di browser hanya ada tiket sesi. Integrasi dengan Laravel juga paling natural dibanding dua mekanisme lain.

**2. Satu kelebihan dan satu kekurangan dibanding mekanisme lain.**

- **Kelebihan:** keamanan integritas data — pada cookies dan Local Storage, isi keranjang dapat diubah pengguna lewat DevTools; pada session tidak (yang bisa diubah hanya tiketnya, dan itu justru menghasilkan sesi kosong).
- **Kekurangan:** **tidak lintas browser/perangkat** — sesi terikat pada browser dan memiliki masa berlaku (mis. menganggur 120 menit dapat hangus). Cookies dapat dibuat lebih persisten dengan `expires`, sedangkan Local Storage paling awet (tetapi tidak dapat dibaca server).

**3. Eksperimen mengubah jumlah menjadi 999 lewat DevTools — apa yang terjadi? (sertakan screenshot)**

Jumlah **tidak dapat diubah** karena angka jumlah tidak pernah berada di browser. Yang tersimpan hanyalah cookie `laravel-session` (tiket terenkripsi). Ketika nilai cookie tersebut diubah lalu halaman dimuat ulang, validitas tanda tangannya rusak sehingga server menganggapnya sesi baru yang kosong — keranjang tetap kosong, bukan berubah jumlahnya.

**4. Mengapa harga tidak boleh dipercaya dari data yang dikirim atau disimpan di browser? Apa yang harus dilakukan server saat checkout?**

Karena data di sisi klien sepenuhnya berada di tangan pengguna: cookies/Local Storage dapat diedit lewat DevTools, dan request dapat dipalsukan. Server **wajib** mengambil harga asli dari database berdasarkan id produk, menghitung total di sisi server, dan memvalidasi stok saat checkout; nilai total dari client tidak boleh diterima. (Prinsip ini diterapkan pada PR: `CheckoutService` mengambil harga dari tabel `products` dan mengarsipkannya ke `harga_satuan`.)

**5. Apa yang terjadi jika pengguna membuka situs dari browser lain?**

Tiket sesinya berbeda, sehingga server mengenali sesi baru dan **keranjang tampil kosong** (terbukti saat pengujian dengan cookie jar baru). Jika keranjang diharapkan konsisten lintas perangkat — terutama untuk pengguna yang login — data sebaiknya disimpan di database yang dikaitkan dengan akun pengguna.

## Screenshot
- 📸 Halaman daftar barang
- 📸 Keranjang kosong
- 📸 Keranjang terisi (contoh: 2× Buku Tulis + 1× Pulpen = Rp 13.000)
- 📸 Setelah refresh — keranjang tetap ada
- 📸 Lokasi data di DevTools: Application → Cookies (`laravel-session`) dan Local Storage kosong
- 📸 Hasil percobaan mengubah data lewat DevTools

---

# 3. PR — Program Toko Online

Aplikasi **toko online berbasis Laravel 13 + MySQL** (folder `toko-online/`) dengan fitur lengkap sesuai ketentuan.

## Fitur dan Alur

1. **Login** — pengunjung bebas melihat katalog; untuk memasukkan ke keranjang dan checkout **wajib login**. Tamu yang mencoba membuka halaman terproteksi otomatis diarahkan ke login, lalu dikembalikan ke halaman tujuan (fitur *intended*).
2. **Daftar Barang (10 barang)** — menampilkan gambar, nama, harga, dan stok. Barang dengan **stok 0 tidak dapat dibeli** (tombol dinonaktifkan).
3. **Keranjang (session)** — menambah barang, mengubah jumlah (+/−), menghapus item, mengosongkan keranjang, subtotal dan total. Jumlah tidak boleh melebihi stok (divalidasi di server).
4. **Checkout** — membuat data pesanan (`orders`), menyimpan detail barang yang dibeli (`order_details`), **mengurangi stok**, dan **mengosongkan keranjang** — seluruhnya dalam **satu transaksi database** (`DB::transaction`, all-or-nothing). Ongkir diabaikan.
5. **Riwayat Pesanan** — pengguna melihat daftar pesanan miliknya beserta detailnya. Pesanan milik pengguna lain dilindungi (HTTP 403).

## Rancangan Database (4 tabel)

| Tabel | Kolom kunci |
|---|---|
| `users` | `id_user` (PK, varchar), nama_lengkap, email (unik), username (unik), password (hash), no_hp, alamat |
| `products` | `id_barang` (PK, varchar), nama_barang, deskripsi, harga, stok, gambar |
| `orders` | `id_order` (PK, varchar), `id_user` (FK), tanggal_order, total_harga, alamat_pengiriman |
| `order_details` | `id_order` + `id_barang` (**PK gabungan**), harga_satuan, jumlah_beli, keduanya FK |

## Detail Teknis Penting

- **Primary key berupa teks** (`id_user`, `id_barang`, `id_order`) dikonfigurasi pada model (Laravel 13: atribut `#[Table(...)]`), termasuk `incrementing: false`.
- **Relasi Eloquent**: `User hasMany Pesanan`; `Pesanan belongsTo User` & `hasMany DetailPesanan`; `DetailPesanan belongsTo Pesanan & Barang`; `Barang hasMany DetailPesanan`.
- **`harga_satuan` adalah arsip harga saat dibeli** — riwayat transaksi tidak berubah walaupun harga produk naik di kemudian hari.
- **`CheckoutService`** memisahkan logika bisnis dari controller. Diuji: jika salah satu barang gagal (stok tidak cukup), seluruh transaksi di-*rollback* — pesanan, detail, dan pengurangan stok dibatalkan bersama.
- **Server yang menghitung total**; harga selalu diambil dari database (bukan dari session/browser).
- **Keamanan**: password ter-hash (bcrypt), CSRF token pada semua aksi POST, middleware `auth`/`guest`, otorisasi pesanan (403), dan transaksi database.

## Screenshot
- 📸 Katalog — 10 barang (gambar, harga, stok; ada barang berstok 0 yang tidak dapat dibeli)
- 📸 Tamu membuka keranjang → diarahkan ke halaman login
- 📸 Setelah login → kembali ke halaman keranjang (*intended*)
- 📸 Keranjang terisi + pesan error saat melebihi stok
- 📸 Halaman checkout (ringkasan + alamat pengiriman)
- 📸 Halaman detail pesanan — terlihat "harga arsip saat dibeli"
- 📸 Riwayat pesanan + detailnya
- 📸 Tabel `orders` dan `order_details` di database

---

# 4. Lampiran — Akun Uji

| Username | Password | Nama |
|---|---|---|
| `budi` | `rahasia123` | Budi Santoso |
| `siti` | `rahasia456` | Siti Aminah |
