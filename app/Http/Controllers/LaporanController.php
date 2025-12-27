<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPenjualan;

class LaporanController extends Controller
{
      public function keuangan(Request $request)
    {
        // 1. Tentukan Range Tanggal (Default: Bulan Ini)
        $start = $request->query('start_date') ? Carbon::parse($request->query('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $end = $request->query('end_date') ? Carbon::parse($request->query('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // 2. Ambil Data Pemasukan (Penjualan)
        $pemasukan = TransaksiPenjualan::whereBetween('created_at', [$start, $end])->sum('total_bayar');

        // 3. Ambil Data Pengeluaran (Pembelian Barang + Gaji)
        $pengeluaran_barang = TransaksiPembelian::whereBetween('created_at', [$start, $end])->sum('total');
        $pengeluaran_gaji = GajiKaryawan::whereBetween('tanggal_bayar', [$start, $end])->sum('jumlah_gaji');

        $total_pengeluaran = $pengeluaran_barang + $pengeluaran_gaji;

        // 4. Hitung Laba Rugi
        $laba_rugi = $pemasukan - $total_pengeluaran;

        // 5. Data Detail untuk Tabel
        $list_penjualan = TransaksiPenjualan::whereBetween('created_at', [$start, $end])->latest()->get();
        $list_pembelian = TransaksiPembelian::whereBetween('created_at', [$start, $end])->latest()->get();
        $list_gaji = GajiKaryawan::whereBetween('tanggal_bayar', [$start, $end])->latest()->get();

        return view('dashboard.laporan.keuangan', compact(
            'pemasukan', 'pengeluaran_barang', 'pengeluaran_gaji',
            'total_pengeluaran', 'laba_rugi', 'start', 'end',
            'list_penjualan', 'list_pembelian', 'list_gaji'
        ));
    }
}
