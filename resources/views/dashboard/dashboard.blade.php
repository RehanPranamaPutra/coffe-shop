@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-[#7a3939] uppercase tracking-tighter">Dashboard Overview</h1>
            <p class="text-gray-500 mt-1 font-medium">Laporan operasional hari ini, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('penjualan.index') }}" class="bg-[#7a3939] text-white px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-[#5a2a2a] transition shadow-xl transform active:scale-95">
                + Transaksi Baru
            </a>
        </div>
    </div>

    {{-- 1. KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pendapatan -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-emerald-100"></div>
            <div class="relative z-10">
                <div class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pemasukan (Net)</div>
                <div class="text-2xl font-black text-gray-800">Rp {{ number_format($incomeToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-[9px] text-emerald-600 font-bold bg-emerald-100 px-3 py-1 rounded-full inline-block uppercase">Hari Ini</div>
            </div>
        </div>

        <!-- Pengeluaran -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-rose-100"></div>
            <div class="relative z-10">
                <div class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Pengeluaran Stok</div>
                <div class="text-2xl font-black text-gray-800">Rp {{ number_format($expenseToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-[9px] text-rose-600 font-bold bg-rose-100 px-3 py-1 rounded-full inline-block uppercase">Hari Ini</div>
            </div>
        </div>

        <!-- Laba -->
        <div class="bg-gradient-to-br from-[#7a3939] to-[#5a2a2a] p-6 rounded-[2rem] shadow-xl text-white relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-1">Estimasi Laba</div>
                <div class="text-2xl font-black">Rp {{ number_format($profitToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-[9px] text-white font-bold bg-white/20 px-3 py-1 rounded-full inline-block uppercase backdrop-blur-md">Profit</div>
            </div>
        </div>

        <!-- Sales Volume -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-[#fdf8f3] rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-[#cc9966]/20"></div>
            <div class="relative z-10">
                <div class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Terjual</div>
                <div class="text-2xl font-black text-gray-800">{{ $itemsSoldToday }} <span class="text-xs font-bold text-gray-400">Cup/Item</span></div>
                <div class="mt-2 text-[9px] text-[#cc9966] font-bold bg-[#fdf8f3] px-3 py-1 rounded-full inline-block uppercase border border-[#cc9966]/20">{{ $transactionCount }} Trx</div>
            </div>
        </div>
    </div>

    {{-- 2. GRAFIK & ANALISA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <!-- Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest">Tren Pendapatan Mingguan</h3>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#7a3939]"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sales (IDR)</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Widgets -->
        <div class="space-y-6">
            <!-- Top Menus -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest mb-6">Menu Terlaris</h3>
                <div class="space-y-5">
                    @forelse($topMenus as $index => $item)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <span class="text-xl font-black text-gray-100 group-hover:text-[#cc9966] transition">0{{ $index + 1 }}</span>
                            <div>
                                <p class="text-xs font-black text-gray-800 uppercase tracking-tight">{{ $item->menu->nama_menu }}</p>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">Bulan Ini</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black bg-gray-50 text-[#7a3939] px-3 py-1.5 rounded-xl border border-gray-100">{{ $item->total_sold }} Sold</span>
                    </div>
                    @empty
                    <p class="text-[10px] text-gray-400 text-center py-4 font-bold uppercase italic">No sales data</p>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alert (Variants) -->
            @if($lowStockVariants->count() > 0)
            <div class="bg-rose-50 p-6 rounded-[2rem] border border-rose-100">
                <h3 class="font-black text-rose-800 text-[10px] uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    Stok Menipis
                </h3>
                <div class="space-y-3">
                    @foreach($lowStockVariants->take(4) as $v)
                    <div class="flex justify-between items-center bg-white/50 p-3 rounded-xl border border-rose-100">
                        <div>
                            <p class="text-[10px] font-black text-gray-800 uppercase">{{ $v->menu->nama_menu }}</p>
                            <p class="text-[9px] font-bold text-rose-600 uppercase">{{ $v->nama_variasi }}</p>
                        </div>
                        <span class="text-xs font-black text-rose-700 bg-rose-100 px-2 py-1 rounded-lg">{{ $v->stok }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- 3. RECENT TRANSACTIONS --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest">Transaksi Terbaru</h3>
            <a href="{{ route('penjualan.index') }}" class="text-[10px] font-black text-[#cc9966] uppercase hover:text-[#7a3939] transition">Ke Menu Transaksi &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Kode Transaksi</th>
                        <th class="px-8 py-5">Kasir</th>
                        <th class="px-8 py-5">Waktu</th>
                        <th class="px-8 py-5 text-right">Total Netto</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50/80 transition group">
                        <td class="px-8 py-5 font-black text-gray-800 text-xs uppercase tracking-tighter">{{ $trx->kode_transaksi }}</td>
                        <td class="px-8 py-5 text-xs font-bold text-gray-500 uppercase">{{ $trx->user->name ?? 'Admin' }}</td>
                        <td class="px-8 py-5 text-xs font-medium text-gray-400">{{ $trx->created_at->diffForHumans() }}</td>
                        <td class="px-8 py-5 text-right font-black text-[#7a3939] text-sm">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('transaksi.struk', $trx->kode_transaksi) }}" class="text-[10px] font-black bg-[#fdf8f3] text-[#cc9966] px-4 py-2 rounded-xl border border-[#cc9966]/20 hover:bg-[#cc9966] hover:text-white transition uppercase">Struk</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(122, 57, 57, 0.2)');
            gradient.addColorStop(1, 'rgba(122, 57, 57, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        data: @json($chartData),
                        backgroundColor: gradient,
                        borderColor: '#7a3939',
                        borderWidth: 4,
                        pointBackgroundColor: '#cc9966',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f5f5f5' },
                            ticks: {
                                font: { size: 10, weight: 'bold' },
                                color: '#d1d1d1',
                                callback: value => 'Rp ' + (value / 1000) + 'k'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#d1d1d1' }
                        }
                    }
                }
            });
        });
    </script>
@endsection
