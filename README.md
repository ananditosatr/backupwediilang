# POS Rumah Cake Suprezz

Aplikasi point of sale berbasis web untuk pemesanan pelanggan dan operasional kasir Rumah Cake Suprezz.

## Fitur

- Pelanggan dapat melihat katalog, memilih kategori menu, dan membuat pesanan.
- Pelanggan dapat melihat status pesanan dan mengunggah bukti pembayaran.
- Kasir dapat memeriksa bukti pembayaran, menyetujui atau menolak pesanan, dan memperbarui status pesanan.
- Kasir dapat mengelola menu dan kategori, membuat pesanan walk-in, serta membuka invoice, delivery note, dan struk.
- Riwayat pesanan tersedia pada dashboard kasir.

> Pembayaran tunai melalui aksi dashboard saat ini dinonaktifkan di aplikasi.

## Teknologi

- PHP 8.2+
- Laravel 12
- Blade
- Tailwind CSS 4
- Vite 7
- SQLite untuk konfigurasi pengembangan lokal

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm

## Menjalankan aplikasi

1. Clone repository dan masuk ke direktori proyek.
2. Jalankan skrip setup yang tersedia di `composer.json`:

   ```bash
   composer setup
   ```

   Skrip tersebut memasang dependency, menyiapkan `.env`, membuat application key, menjalankan migrasi, memasang dependency frontend, dan membangun aset.

3. Isi nilai `WHATSAPP_NUMBER` dan konfigurasi lokal lain di `.env` bila diperlukan.
4. Jalankan server pengembangan:

   ```bash
   composer dev
   ```

> Kredensial demo tidak disertakan. Jangan gunakan kredensial produksi dalam pengujian atau lingkungan publik.

## Konfigurasi

Salin `.env.example` sebagai dasar konfigurasi lokal. Jangan commit `.env`, application key, kredensial, database lokal, atau bukti pembayaran. Jika application key lama pernah dipakai, buat key baru pada setiap environment yang menggunakannya:

```bash
php artisan key:generate --force
```

Mengganti key dapat mengeluarkan sesi lama dan membuat data yang dienkripsi dengan key sebelumnya tidak dapat dibaca.

## Catatan pengembangan

README ini menjelaskan implementasi yang ada saat ini; fitur pembayaran dan metode transaksi dapat berubah mengikuti konfigurasi aplikasi.
