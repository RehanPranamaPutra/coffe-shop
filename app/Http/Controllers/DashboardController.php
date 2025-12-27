<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\TransaksiItem;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function index()
    {
        $today = Carbon::today();

        // 1. KPI Cards (Ringkasan Hari Ini)
        $incomeToday = TransaksiPenjualan::whereDate('created_at', $today)->sum('total_bayar');
        $expenseToday = TransaksiPembelian::whereDate('created_at', $today)->sum('total');
        $profitToday = $incomeToday - $expenseToday;
        $itemsSoldToday = TransaksiItem::whereDate('created_at', $today)->sum('jumlah');
        $transactionCount = TransaksiPenjualan::whereDate('created_at', $today)->count();

        // 2. Data Grafik Penjualan (7 Hari Terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = TransaksiPenjualan::whereDate('created_at', $date)->sum('total_bayar');
        }

        // 3. Top 5 Menu Terlaris (Bulan Ini)
        $topMenus = TransaksiItem::select('menu_id', DB::raw('sum(jumlah) as total_sold'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->with('menu') // Pastikan ada relasi belongsTo di model TransaksiItem ke Menu
            ->groupBy('menu_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 4. Stok Menipis (Alert)
        $lowStockMenus = Menu::where('stok', '<', 10)->where('status', 'Tersedia')->get();

        // 5. Transaksi Terakhir
        $recentTransactions = TransaksiPenjualan::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'incomeToday', 'expenseToday', 'profitToday', 'itemsSoldToday', 'transactionCount',
            'chartLabels', 'chartData', 'topMenus', 'lowStockMenus', 'recentTransactions'
        ));
    }
}
