<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('transaksi_penjualans')->insert([
            [
                'kode_transaksi' => 'TRX-' . strtoupper(Str::random(8)),
                'user_id' => 1,
                'total' => 72000,
                'potongan' => 5000,
                'total_bayar' => 67000,
                'dibayar' => 70000,
                'kembalian' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
