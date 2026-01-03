@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 max-w-7xl mx-auto space-y-6">

    <!-- HEADER ACTION -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-6 print:hidden">
        <div>
            <h1 class="text-3xl font-black text-[#7a3939] uppercase tracking-tighter">Laporan Laba Rugi</h1>
            <p class="text-gray-500 text-sm font-medium">Analisis performa keuangan Access Coffee.</p>
        </div>
        <button onclick="window.print()" class="flex items-center gap-2 bg-[#7a3939] text-white px-6 py-3 rounded-2xl hover:bg-[#5a2a2a] transition shadow-xl font-bold uppercase text-xs tracking-widest">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2"/></svg>
            Cetak Laporan
        </button>
    </div>

    <!-- FILTER TANGGAL -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 print:hidden">
        <form action="{{ route('laporan.keuangan') }}" method="GET" class="flex flex-wrap items-end gap-6">
            <div class="flex-1 min-w-[200px]">
                <label class="text-[10px] font-black text-[#cc9966] uppercase mb-2 block tracking-widest">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $start->format('Y-m-d') }}" class="w-full bg-gray-50 border-none rounded-xl py-3 focus:ring-2 focus:ring-[#cc9966] font-bold text-gray-700">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="text-[10px] font-black text-[#cc9966] uppercase mb-2 block tracking-widest">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $end->format('Y-m-d') }}" class="w-full bg-gray-50 border-none rounded-xl py-3 focus:ring-2 focus:ring-[#cc9966] font-bold text-gray-700">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#cc9966] text-white px-8 py-3 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-[#b38659] transition shadow-md">Filter</button>
                <a href="{{ route('laporan.keuangan') }}" class="bg-gray-100 text-gray-400 px-6 py-3 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-gray-200 transition text-center">Reset</a>
            </div>
        </form>
    </div>

    <!-- TAMPILAN LAPORAN -->
    <div class="bg-white p-6 sm:p-12 rounded-[3rem] shadow-sm border border-gray-50 print:shadow-none print:border-none print:p-0">

        <!-- Kop Surat Cetak -->
        <div class="hidden print:block text-center border-b-2 border-gray-800 pb-6 mb-10">
            <h1 class="text-4xl font-black uppercase text-black tracking-tighter">Access Coffee</h1>
            <p class="text-xs uppercase tracking-widest mt-1">Laporan Keuangan Resmi / Laba Rugi</p>
            <p class="text-[10px] text-gray-500 mt-2">Jl. Akses Bandara Internasional Minangkabau No.9, Katapiang, Padang Pariaman</p>
        </div>

        <div class="text-center mb-12">
            <h2 class="text-2xl font-black uppercase tracking-tight text-gray-800 underline decoration-[#cc9966] decoration-4 underline-offset-8">Ringkasan Laba Rugi</h2>
            <p class="text-gray-400 font-bold uppercase text-[10px] mt-4 tracking-[0.2em]">{{ $start->format('d M Y') }} — {{ $end->format('d M Y') }}</p>
        </div>

        <!-- GRID RINGKASAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            <!-- PENDAPATAN -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 border-b-2 border-[#7a3939] pb-2">
                    <div class="p-2 bg-[#7a3939] rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="3"/></svg>
                    </div>
                    <h3 class="font-black text-[#7a3939] uppercase text-xs tracking-widest">A. Pemasukan (Revenue)</h3>
                </div>

                <div class="space-y-3 px-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Penjualan Kotor</span>
                        <span class="font-bold text-gray-800 text-right">Rp {{ number_format($penjualan_kotor, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Total Potongan Promo</span>
                        <span class="font-bold text-red-500 text-right">- Rp {{ number_format($potongan_promo, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-dashed font-black text-emerald-600">
                        <span class="text-xs uppercase tracking-tighter">Total Pemasukan Bersih</span>
                        <span class="text-lg">Rp {{ number_format($pemasukan_bersih, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- PENGELUARAN -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 border-b-2 border-red-700 pb-2">
                    <div class="p-2 bg-red-700 rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" stroke-width="3"/></svg>
                    </div>
                    <h3 class="font-black text-red-700 uppercase text-xs tracking-widest">B. Pengeluaran (Expenses)</h3>
                </div>

                <div class="space-y-3 px-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Pembelian Stok Barang</span>
                        <span class="font-bold text-gray-800 text-right">Rp {{ number_format($pengeluaran_barang, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Total Gaji Karyawan</span>
                        <span class="font-bold text-gray-800 text-right">Rp {{ number_format($pengeluaran_gaji, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-dashed font-black text-red-700">
                        <span class="text-xs uppercase tracking-tighter">Total Semua Pengeluaran</span>
                        <span class="text-lg">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- LABA RUGI BERSIH BOX -->
        <div class="mt-16 p-8 rounded-[2.5rem] flex flex-col sm:flex-row justify-between items-center gap-4 border-4 border-dashed {{ $laba_rugi >= 0 ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
            <div>
                <h3 class="text-gray-500 font-black uppercase text-[10px] tracking-[0.3em]">Laba / Rugi Bersih (Net Profit)</h3>
                <p class="text-sm text-gray-400 font-medium italic mt-1">*Penghitungan otomatis berdasarkan data transaksi tersimpan.</p>
            </div>
            <span class="text-2xl font-black {{ $laba_rugi >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                Rp {{ number_format($laba_rugi, 0, ',', '.') }}
            </span>
        </div>

        <!-- TABEL RINCIAN PENJUALAN -->
        <div class="mt-20 space-y-6">
            <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest text-center border-b pb-4">Lampiran Rincian Transaksi Penjualan</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="text-gray-400 uppercase font-black tracking-tighter border-b">
                            <th class="py-4 px-2">No</th>
                            <th class="py-4 px-2">Tanggal</th>
                            <th class="py-4 px-2 text-center">ID Transaksi</th>
                            <th class="py-4 px-2">Kasir</th>
                            <th class="py-4 px-2 text-right">Penjualan Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($list_penjualan as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-2 text-gray-400">{{ $index + 1 }}</td>
                            <td class="py-4 px-2 font-bold">{{ $item->created_at->format('d/m/y H:i') }}</td>
                            <td class="py-4 px-2 text-center font-mono font-bold text-[#cc9966] uppercase">{{ $item->kode_transaksi }}</td>
                            <td class="py-4 px-2 font-medium">{{ $item->user->name ?? 'System' }}</td>
                            <td class="py-4 px-2 text-right font-black text-gray-700">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TANDA TANGAN -->
        <div class="hidden print:grid grid-cols-2 mt-24 text-center text-xs font-bold uppercase tracking-widest">
            <div class="space-y-20">
                <p>Dicetak Oleh,</p>
                <p class="underline underline-offset-8 decoration-2">{{ Auth::user()->name }}</p>
            </div>
            <div class="space-y-20">
                <p>Diketahui Oleh (Owner),</p>
                <p class="underline underline-offset-8 decoration-2">( .................................. )</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        aside, nav, header, .print\:hidden { display: none !important; }
        body { background-color: white !important; -webkit-print-color-adjust: exact; }
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        @page { size: A4; margin: 1.5cm; }
        .rounded-\[3rem\], .rounded-\[2\.5rem\] { border-radius: 0 !important; }
        .bg-white { border: none !important; }
    }
</style>
@endsection
