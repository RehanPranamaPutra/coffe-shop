<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('transaksi_items')->insert([
            [
                'transaksi_id' => 1,
                'menu_id' => 1,
                'promo_id' => 1,
                'jumlah' => 2,
                'harga_satuan' => 25000,
                'subtotal' => 50000,
                'diskon' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaksi_id' => 1,
                'menu_id' => 3,
                'promo_id' => null,
                'jumlah' => 2,
                'harga_satuan' => 5000,
                'subtotal' => 10000,
                'diskon' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
