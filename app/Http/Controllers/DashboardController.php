<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\MenuVariant;
use Illuminate\Http\Request;
use App\Models\TransaksiItem;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{public function index()
    {
        $today = Carbon::today();
        $start7Days = Carbon::today()->subDays(6);

        // 1. KPI Metrics (Hari Ini)
        $incomeToday = TransaksiPenjualan::whereDate('created_at', $today)->sum('total_bayar');
        $expenseToday = TransaksiPembelian::whereDate('created_at', $today)->sum('total');
        $profitToday = $incomeToday - $expenseToday;

        $transactionCount = TransaksiPenjualan::whereDate('created_at', $today)->count();
        $itemsSoldToday = TransaksiItem::whereHas('transaksi', function($q) use ($today) {
            $q->whereDate('created_at', $today);
        })->sum('jumlah');

        // 2. Data Grafik (7 Hari Terakhir)
        $chartDataRaw = TransaksiPenjualan::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->where('created_at', '>=', $start7Days)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $label = Carbon::today()->subDays($i)->format('D'); // Mon, Tue, etc
            $chartLabels[] = $label;

            $found = $chartDataRaw->where('date', $date)->first();
            $chartData[] = $found ? (int)$found->total : 0;
        }

        // 3. Menu Terlaris (Bulan Ini)
        $topMenus = TransaksiItem::select('menu_id', DB::raw('SUM(jumlah) as total_sold'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('menu_id')
            ->orderBy('total_sold', 'DESC')
            ->with('menu')
            ->take(5)
            ->get();

        // 4. Low Stock Alert (Dari Tabel menu_variants)
        $lowStockVariants = MenuVariant::with('menu')
            ->where('stok', '<=', 10)
            ->orderBy('stok', 'ASC')
            ->get();

        // 5. Transaksi Terbaru
        $recentTransactions = TransaksiPenjualan::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'incomeToday', 'expenseToday', 'profitToday',
            'transactionCount', 'itemsSoldToday',
            'chartLabels', 'chartData',
            'topMenus', 'lowStockVariants', 'recentTransactions'
        ));
    }
}
