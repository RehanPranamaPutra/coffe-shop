@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Laba Rugi & Keuangan</h1>
        <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded shadow print:hidden">
            Cetak Laporan
        </button>
    </div>

    <!-- Filter Tanggal -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 print:hidden">
        <form action="{{ route('laporan.keuangan') }}" method="GET" class="flex gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $start->format('Y-m-d') }}" class="mt-1 border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $end->format('Y-m-d') }}" class="mt-1 border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Filter</button>
            <a href="{{ route('laporan.keuangan') }}" class="bg-gray-200 px-4 py-2 rounded text-gray-700">Reset</a>
        </form>
    </div>

    <!-- Ringkasan Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow">
            <p class="text-sm text-green-600 font-bold uppercase">Total Pemasukan (Penjualan)</p>
            <p class="text-2xl font-black text-green-700">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
        </div>

        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow">
            <p class="text-sm text-red-600 font-bold uppercase">Total Pengeluaran</p>
            <p class="text-2xl font-black text-red-700">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
            <p class="text-[10px] text-red-400">Barang: Rp{{ number_format($pengeluaran_barang, 0, ',', '.') }} | Gaji: Rp{{ number_format($pengeluaran_gaji, 0, ',', '.') }}</p>
        </div>

        <div class="{{ $laba_rugi >= 0 ? 'bg-indigo-50 border-indigo-500' : 'bg-orange-50 border-orange-500' }} border-l-4 p-4 rounded shadow">
            <p class="text-sm font-bold uppercase">Laba / Rugi Bersih</p>
            <p class="text-2xl font-black {{ $laba_rugi >= 0 ? 'text-indigo-700' : 'text-orange-700' }}">
                Rp {{ number_format($laba_rugi, 0, ',', '.') }}
            </p>
            <p class="text-[10px]">{{ $laba_rugi >= 0 ? 'Profit Terdeteksi' : 'Defisit Terdeteksi' }}</p>
        </div>
    </div>

    <!-- Detail Tables -->
    <div class="space-y-8">
        <!-- Tabel Penjualan -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-800 px-4 py-2">
                <h3 class="text-white font-bold text-sm">Rincian Pemasukan (Penjualan)</h3>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Kode TRX</th>
                        <th class="p-3">Total Belanja</th>
                        <th class="p-3">Diskon/Promo</th>
                        <th class="p-3 text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_penjualan as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="p-3 font-mono text-xs">{{ $item->kode_transaksi }}</td>
                        <td class="p-3">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td class="p-3 text-red-500">-Rp {{ number_format($item->potongan, 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-bold">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabel Pembelian & Gaji (Pengeluaran) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pembelian -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-red-800 px-4 py-2">
                    <h3 class="text-white font-bold text-sm">Rincian Pembelian Barang</h3>
                </div>
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2">Nama Barang</th>
                            <th class="p-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_pembelian as $p)
                        <tr class="border-b">
                            <td class="p-2">{{ $p->nama_barang }} (x{{ $p->jumlah }})</td>
                            <td class="p-2 text-right font-bold">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Gaji -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-orange-800 px-4 py-2">
                    <h3 class="text-white font-bold text-sm">Rincian Gaji Karyawan</h3>
                </div>
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2">Nama Karyawan</th>
                            <th class="p-2 text-right">Jumlah Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_gaji as $g)
                        <tr class="border-b">
                            <td class="p-2">{{ $g->user->name }} ({{ $g->bulan }})</td>
                            <td class="p-2 text-right font-bold">Rp {{ number_format($g->jumlah_gaji, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background: white; }
        .print\:hidden { display: none !important; }
        .shadow { shadow: none !important; border: 1px solid #eee; }
    }
</style>
@endsection
