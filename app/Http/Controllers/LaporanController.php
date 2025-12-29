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
        Gate::authorize('roleOwner');

        $start = $request->query('start_date') ? Carbon::parse($request->query('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $end = $request->query('end_date') ? Carbon::parse($request->query('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Data Pemasukan
        $pemasukan = TransaksiPenjualan::whereBetween('created_at', [$start, $end])->sum('total_bayar');
        $total_diskon_diberikan = TransaksiPenjualan::whereBetween('created_at', [$start, $end])->sum('potongan');

        // Data Pengeluaran
        $pengeluaran_barang = TransaksiPembelian::whereBetween('created_at', [$start, $end])->sum('total');
        $pengeluaran_gaji = GajiKaryawan::whereBetween('tanggal_bayar', [$start, $end])->sum('jumlah_gaji');
        $total_pengeluaran = $pengeluaran_barang + $pengeluaran_gaji;

        $laba_rugi = $pemasukan - $total_pengeluaran;

        // List Data
        $list_penjualan = TransaksiPenjualan::with('user')->whereBetween('created_at', [$start, $end])->latest()->get();
        $list_pembelian = TransaksiPembelian::whereBetween('created_at', [$start, $end])->latest()->get();
        $list_gaji = GajiKaryawan::with('user')->whereBetween('tanggal_bayar', [$start, $end])->latest()->get();

        return view('dashboard.laporan.keuangan', compact(
            'pemasukan',
            'pengeluaran_barang',
            'pengeluaran_gaji',
            'total_pengeluaran',
            'laba_rugi',
            'start',
            'end',
            'list_penjualan',
            'list_pembelian',
            'list_gaji',
            'total_diskon_diberikan'
        ));
    }
}
