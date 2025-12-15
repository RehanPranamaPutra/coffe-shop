<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'nama_menu' => 'Nasi Goreng Spesial',
                'slug' => Str::slug('Nasi Goreng Spesial'),
                'harga' => 25000,
                'stok' => 50,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'deskripsi' => 'Nasi goreng dengan telur, ayam, dan kerupuk',
                'gambar' => 'nasi-goreng.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Mie Ayam Bakso',
                'slug' => Str::slug('Mie Ayam Bakso'),
                'harga' => 22000,
                'stok' => 40,
                'kategori' => 'Makanan',
                'status' => 'Tersedia',
                'deskripsi' => 'Mie ayam dengan topping bakso sapi',
                'gambar' => 'mie-ayam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Es Teh Manis',
                'slug' => Str::slug('Es Teh Manis'),
                'harga' => 5000,
                'stok' => 100,
                'kategori' => 'Minuman',
                'status' => 'Tersedia',
                'deskripsi' => 'Minuman teh manis dingin',
                'gambar' => 'es-teh.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
