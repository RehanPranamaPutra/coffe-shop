<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PromosiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promos')->insert([
            [
                'menu_id' => 1, // Nasi Goreng
                'jenis_promo' => 'persen',
                'nilai_diskon' => 10, // 10%
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(7),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 2, // Mie Ayam
                'jenis_promo' => 'nominal',
                'nilai_diskon' => 3000, // potongan langsung
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(5),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 2, // Mie Ayam
                'jenis_promo' => 'nominal',
                'nilai_diskon' => 4000, // potongan langsung
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(5),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 2, // Mie Ayam
                'jenis_promo' => 'nominal',
                'nilai_diskon' => 6000, // potongan langsung
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(5),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
