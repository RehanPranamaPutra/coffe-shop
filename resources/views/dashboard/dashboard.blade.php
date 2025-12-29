@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#7a3939]">Dashboard Overview</h1>
            <p class="text-gray-500 mt-1">Laporan harian untuk {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
        <div class="flex gap-2">
             
            <a href="{{ route('penjualan.index') }}" class="bg-[#7a3939] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#8d4343] transition shadow-lg shadow-[#7a3939]/30">
                + Transaksi Baru
            </a>
        </div>
    </div>

    {{-- 1. KPI CARDS (METRIK UTAMA HARI INI) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card: Pendapatan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-green-100"></div>
            <div class="relative z-10">
                <div class="text-gray-500 text-sm font-medium mb-1">Pendapatan Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($incomeToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-green-600 font-bold bg-green-100 px-2 py-1 rounded-full inline-block">
                    Uang Masuk
                </div>
            </div>
        </div>

        <!-- Card: Pengeluaran -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100"></div>
            <div class="relative z-10">
                <div class="text-gray-500 text-sm font-medium mb-1">Pengeluaran Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($expenseToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-red-600 font-bold bg-red-100 px-2 py-1 rounded-full inline-block">
                    Belanja Stok
                </div>
            </div>
        </div>

        <!-- Card: Laba Bersih -->
        <div class="bg-gradient-to-br from-[#7a3939] to-[#8d4343] p-6 rounded-2xl shadow-lg shadow-[#7a3939]/20 text-white relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="text-white/80 text-sm font-medium mb-1">Estimasi Laba Hari Ini</div>
                <div class="text-2xl font-bold">Rp {{ number_format($profitToday, 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-white/90 bg-white/20 px-2 py-1 rounded-full inline-block backdrop-blur-sm">
                    Net Profit
                </div>
            </div>
        </div>

        <!-- Card: Volume Penjualan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition">
            <div class="absolute right-0 top-0 w-24 h-24 bg-[#f7e0c4] rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-[#cc9966]/30"></div>
            <div class="relative z-10">
                <div class="text-gray-500 text-sm font-medium mb-1">Menu Terjual Hari Ini</div>
                <div class="text-2xl font-bold text-gray-800">{{ $itemsSoldToday }} <span class="text-sm font-normal text-gray-500">Item</span></div>
                <div class="mt-2 text-xs text-[#7a3939] font-bold bg-[#f7e0c4] px-2 py-1 rounded-full inline-block">
                    Dari {{ $transactionCount }} Transaksi
                </div>
            </div>
        </div>
    </div>

    {{-- 2. GRAFIK & ANALISA (GRID 3:1) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <!-- Main Chart: Tren Penjualan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800 text-lg">Grafik Pendapatan (7 Hari Terakhir)</h3>
                <span class="text-xs text-gray-400">Update Realtime</span>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Side Widget: Top Menu & Stok Alert -->
        <div class="space-y-6">
            <!-- Top Menu -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg mb-4">🔥 Menu Terlaris (Bulan Ini)</h3>
                <div class="space-y-4">
                    @forelse($topMenus as $index => $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-[#cc9966]">#{{ $index + 1 }}</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $item->menu->nama_menu }}</p>
                                <p class="text-xs text-gray-500">{{ $item->menu->kategori }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold bg-gray-100 px-2 py-1 rounded-lg">{{ $item->total_sold }} Sold</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada data penjualan bulan ini.</p>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if($lowStockMenus->count() > 0)
            <div class="bg-red-50 p-6 rounded-2xl border border-red-100">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <h3 class="font-bold text-red-800 text-sm">Stok Menipis!</h3>
                </div>
                <ul class="space-y-2">
                    @foreach($lowStockMenus->take(3) as $menu)
                    <li class="flex justify-between text-sm text-red-700">
                        <span>{{ $menu->nama_menu }}</span>
                        <span class="font-bold">Sisa: {{ $menu->stok }}</span>
                    </li>
                    @endforeach
                </ul>
                @if($lowStockMenus->count() > 3)
                    <a href="#" class="text-xs text-red-600 underline mt-2 block">Lihat {{ $lowStockMenus->count() - 3 }} lainnya</a>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- 3. TABEL TRANSAKSI TERBARU --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-lg">Transaksi Terbaru</h3>
            <a href="#" class="text-sm text-[#7a3939] font-semibold hover:underline">Lihat Semua Data</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Kode Transaksi</th>
                        <th class="px-6 py-4">Kasir/User</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Total Bayar</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-[#7a3939]">{{ $trx->kode_transaksi }}</td>
                        <td class="px-6 py-4">{{ $trx->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-right font-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Success</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SCRIPT CHART.JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Data dari Controller Laravel
            const labels = @json($chartLabels);
            const data = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: data,
                        backgroundColor: 'rgba(122, 57, 57, 0.1)', // #7a3939 with opacity
                        borderColor: '#7a3939',
                        borderWidth: 2,
                        pointBackgroundColor: '#cc9966',
                        pointRadius: 4,
                        tension: 0.4, // Membuat garis melengkung halus
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f0f0f0' },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k'; // Singkat angka sumbu Y
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endsection
