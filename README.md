# Project 3 — Week 5 — Modul 4

**Penyimpanan Data pada Web: Cookies, Session, dan Local Storage**

- **Nama:** Ananda Firdaus
- **NIM:** 251511003

## Isi Repositori

| Folder | Tugas | Poin utama |
|---|---|---|
| `tugas-1-login/` | Tugas 1 — Login dengan Password Terenkripsi | Laravel 13 + MySQL; password ter-hash (bcrypt); `Auth::attempt`; middleware `auth`/`guest`; session regeneration |
| `tugas-2-keranjang/` | Tugas 2 — Keranjang Belanja Tanpa Login | Mekanisme **session** (data di server); badge jumlah; tombol + / − / hapus / kosongkan; batas stok |
| `tugas-toko-online/` | PR — Program Toko Online | Login wajib untuk membeli; katalog 10 barang + gambar; keranjang session; checkout transaksional (`CheckoutService` + `DB::transaction`); arsip `harga_satuan`; riwayat pesanan |

## Teknologi
- Laravel 13 (PHP 8.4), MySQL 8, Blade

## Cara Menjalankan (dilakukan di tiap folder proyek)
```bash
composer install
copy .env.example .env     # Windows (sesuaikan DB_* dengan MySQL setempat)
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Akun Uji
| Username | Password | Nama |
|---|---|---|
| `budi` | `rahasia123` | Budi Santoso |
| `siti` | `rahasia456` | Siti Aminah |
