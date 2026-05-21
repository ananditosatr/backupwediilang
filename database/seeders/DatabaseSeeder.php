<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan data lama agar tidak terjadi duplikasi akun atau menu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Category::truncate();
        Menu::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat Akun Kasir
        User::create([
            'username' => 'kasir01',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);

        // 3. Buat Kategori Baru yang Sesuai dengan Jenis Menu Baru
        $cakes = Category::create(['name' => 'Cakes', 'status' => 'active', 'display_order' => 1]);
        $snacks = Category::create(['name' => 'Traditional Snacks', 'status' => 'active', 'display_order' => 2]);
        $breads = Category::create(['name' => 'Savory Breads', 'status' => 'active', 'display_order' => 3]);
        $catering = Category::create(['name' => 'Catering & Heavy Meals', 'status' => 'active', 'display_order' => 4]);

        // 4. Tambahkan Menu Sesuai Nama, Deskripsi, dan Harga yang Kamu Berikan

        // === CATEGORY: CAKES ===
        Menu::create([
            'category_id' => $cakes->id,
            'name' => 'Chiffon Cake',
            'description' => 'Kue chiffon dengan tekstur lembut, ringan, dan manis pas di lidah. Cocok untuk teman santai bersama teh atau kopi.',
            'price' => 55000,
            'is_available' => true,
            'stock' => 15,
            'image_base64' => null
        ]);
        Menu::create([
            'category_id' => $cakes->id,
            'name' => 'Banana Cake Ukuran 24',
            'description' => 'Banana cake ukuran besar dengan aroma pisang yang harum, tekstur moist, dan rasa manis yang lembut.',
            'price' => 65000,
            'is_available' => true,
            'stock' => 10,
            'image_base64' => null
        ]);
        Menu::create([
            'category_id' => $cakes->id,
            'name' => 'Banana Cake Ukuran 16',
            'description' => 'Cake pisang ukuran personal dengan rasa lembut dan legit, cocok untuk cemilan keluarga kecil.',
            'price' => 15000,
            'is_available' => true,
            'stock' => 20,
            'image_base64' => null
        ]);

        // === CATEGORY: TRADITIONAL SNACKS ===
        Menu::create([
            'category_id' => $snacks->id,
            'name' => 'Sosis Solo',
            'description' => 'Camilan tradisional dengan kulit lembut dan isian ayam gurih berbumbu khas yang nikmat disantap hangat.',
            'price' => 35000, // Diinput 35.000 sesuai format teks, sesuaikan jadi 3500 jika maksudnya tiga ribu lima ratus rupiah
            'is_available' => true,
            'stock' => 100,
            'image_base64' => null
        ]);
        Menu::create([
            'category_id' => $snacks->id,
            'name' => 'Kue Nampan',
            'description' => 'Aneka kue basah dalam satu nampan dengan pilihan beragam, cocok untuk acara keluarga, arisan, atau hajatan.',
            'price' => 30000, // Diinput 30.000 sesuai format teks, sesuaikan jadi 3000 jika maksudnya tiga ribu rupiah per pcs
            'is_available' => true,
            'stock' => 50,
            'image_base64' => null
        ]);

        // === CATEGORY: SAVORY BREADS ===
        Menu::create([
            'category_id' => $breads->id,
            'name' => 'Roti Sosis',
            'description' => 'Roti lembut dengan isian sosis, mayo, dan saus yang gurih manis, cocok untuk sarapan atau camilan.',
            'price' => 50000, // Diinput 50.000 sesuai format teks, sesuaikan jadi 5000 jika maksudnya lima ribu rupiah
            'is_available' => true,
            'stock' => 40,
            'image_base64' => null
        ]);

        // === CATEGORY: CATERING & HEAVY MEALS ===
        Menu::create([
            'category_id' => $catering->id,
            'name' => 'Nasi Kotak Sate',
            'description' => 'Paket nasi kotak lengkap dengan sate dan lauk pendamping yang praktis serta mengenyangkan.',
            'price' => 35000,
            'is_available' => true,
            'stock' => 99,
            'image_base64' => null
        ]);
        Menu::create([
            'category_id' => $catering->id,
            'name' => 'Ayam Goreng Laos',
            'description' => 'Ayam goreng berbumbu rempah dengan taburan laos gurih, disajikan bersama lalapan dan sambal.',
            'price' => 50000,
            'is_available' => true,
            'stock' => 25,
            'image_base64' => null
        ]);
        Menu::create([
            'category_id' => $catering->id,
            'name' => 'Nasi Tumpeng',
            'description' => 'Sajian nasi tumpeng lengkap dengan aneka lauk pilihan, cocok untuk acara syukuran dan perayaan spesial.',
            'price' => 300000,
            'is_available' => true,
            'stock' => 5,
            'image_base64' => null
        ]);
    }
}