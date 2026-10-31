# POS Rumah Cake Suprezz

Proyek tugas akhir S1 Sistem Informasi, Telkom University Surabaya.

**Judul skripsi:** “Pembangunan Aplikasi Point of Sale Berbasis Website Menggunakan Personal Extreme Programming (Studi Kasus: PT Rumah Cake Suprezz)”

- **Demo:** https://rumahcakesuprezz.site
- **Repository:** https://github.com/ananditosatr/pos-rumah-cake-suprezz

## Tampilan

Tambahkan tangkapan layar aplikasi yang diambil dari versi yang berjalan. Gambar belum disertakan.

![Katalog menu — tambahkan screenshot ke docs/katalog.png](docs/katalog.png)

![Dashboard kasir — tambahkan screenshot ke docs/kasir.png](docs/kasir.png)

![Invoice — tambahkan screenshot ke docs/invoice.png](docs/invoice.png)

## Fitur

- Pelanggan dapat melihat katalog dan kategori menu, membuat pesanan, serta melacak status pesanan.
- Pembayaran QRIS atau transfer bank mendukung unggah bukti pembayaran.
- Kasir dapat memeriksa dan memverifikasi pembayaran.
- Kasir dapat mengelola menu dan kategori, membuat pesanan walk-in, serta membuka invoice, delivery note, dan struk.
- Dashboard kasir menyediakan riwayat pesanan.

Pembayaran tunai melalui aksi dashboard saat ini dinonaktifkan di controller, sehingga tidak dicantumkan sebagai fitur aktif.

## Teknologi

- PHP 8.2+
- Laravel 12
- Blade
- Tailwind CSS 4
- Vite 7
- Database pada template konfigurasi lokal: SQLite (`.env.example`). Database yang benar-benar digunakan secara lokal: [PERLU KONFIRMASI].
- Database produksi/hosting: [PERLU KONFIRMASI].
- Perangkat pengembangan: XAMPP dan Visual Studio Code

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

3. Isi konfigurasi lokal di `.env` bila diperlukan. Jika nomor kontak kurir digunakan, atur `KASIR_COURIER_PHONE` hanya di `.env` pada environment terkait.
4. Jalankan server pengembangan:

   ```bash
   composer dev
   ```

Jangan gunakan kredensial produksi dalam pengujian atau lingkungan publik. Jangan commit `.env`, application key, kredensial, database lokal, atau bukti pembayaran.

## Saran About repository

Aplikasi POS berbasis Laravel untuk pemesanan pelanggan dan operasional kasir, dibuat sebagai proyek tugas akhir Sistem Informasi.

## Saran topics

`laravel`, `php`, `point-of-sale`, `tailwindcss`, `blade`

## Catatan keamanan

Sebuah `APP_KEY` pernah ter-commit di riwayat repository. Riwayat branch telah dibersihkan, tetapi rotasi key pada server perlu dilakukan secara terpisah jika key tersebut pernah digunakan di produksi. Mengganti key dapat mengakhiri sesi aktif dan membuat data yang dienkripsi menggunakan key lama tidak dapat dibaca.
