<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\Gate;

class LaporanController extends Controller
{
    // Di LaporanController.php
    public function keuangan(Request $request)
    {
        // 1. Atur Rentang Tanggal
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // 2. Ambil Data Pemasukan (Penjualan)
        $penjualan = TransaksiPenjualan::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $total_penjualan_kotor = $penjualan->sum('total');
        $total_potongan_promo = $penjualan->sum('potongan');
        $pemasukan_bersih = $penjualan->sum('total_bayar');

        // 3. Ambil Data Pengeluaran (Pembelian Barang)
        $total_pengeluaran_barang = TransaksiPembelian::whereBetween('created_at', [$start, $end])
            ->sum('total');

        // 4. Ambil Data Pengeluaran (Gaji Karyawan)
        $total_pengeluaran_gaji = GajiKaryawan::whereBetween('tanggal_bayar', [$start, $end])
            ->sum('jumlah_gaji');

        // 5. Kalkulasi Akhir
        $total_pengeluaran_akumulasi = $total_pengeluaran_barang + $total_pengeluaran_gaji;
        $laba_rugi_bersih = $pemasukan_bersih - $total_pengeluaran_akumulasi;

        return view('dashboard.laporan.keuangan', [
            'start' => $start,
            'end' => $end,
            'list_penjualan' => $penjualan,
            'penjualan_kotor' => $total_penjualan_kotor,
            'potongan_promo' => $total_potongan_promo,
            'pemasukan_bersih' => $pemasukan_bersih,
            'pengeluaran_barang' => $total_pengeluaran_barang,
            'pengeluaran_gaji' => $total_pengeluaran_gaji,
            'total_pengeluaran' => $total_pengeluaran_akumulasi,
            'laba_rugi' => $laba_rugi_bersih
        ]);
    }
}
