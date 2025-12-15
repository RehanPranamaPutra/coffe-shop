<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('transaksi_pembelians')->insert([
            [
                'user_id' => 1,
                'nama_barang' => 'Beras Premium',
                'kategori' => 'Bahan Baku',
                'jumlah' => 10,
                'harga' => 120000,
                'total' => 1200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'nama_barang' => 'Ayam Fillet',
                'kategori' => 'Bahan Baku',
                'jumlah' => 5,
                'harga' => 45000,
                'total' => 225000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
