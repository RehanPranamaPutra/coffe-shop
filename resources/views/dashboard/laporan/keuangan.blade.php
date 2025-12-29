@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 max-w-7xl mx-auto space-y-6">

    <!-- HEADER ACTION (Hanya muncul di layar) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-6 print:hidden">
        <div>
            <h1 class="text-3xl font-black text-[#7a3939]">Laporan Keuangan</h1>
            <p class="text-gray-500 text-sm">Kelola dan pantau arus kas masuk dan keluar.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button onclick="window.print()" class="flex items-center gap-2 bg-[#7a3939] text-white px-5 py-2.5 rounded-xl hover:bg-[#5a2a2a] transition shadow-lg font-bold">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2"/></svg>
                Cetak Laporan Resmi
            </button>
        </div>
    </div>

    <!-- FILTER TANGGAL (Hanya muncul di layar) -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 print:hidden">
        <form action="{{ route('laporan.keuangan') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs font-bold text-gray-400 uppercase mb-1 block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $start->format('Y-m-d') }}" class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966]">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs font-bold text-gray-400 uppercase mb-1 block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $end->format('Y-m-d') }}" class="w-full border-gray-200 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966]">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#cc9966] text-white px-6 py-2 rounded-xl font-bold hover:bg-[#b38659] transition shadow-md">Tampilkan</button>
                <a href="{{ route('laporan.keuangan') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-xl font-bold hover:bg-gray-200 transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- ============================================================== -->
    <!-- TAMPILAN LAPORAN STANDAR (MUNCUL SAAT CETAK & LAYAR) -->
    <!-- ============================================================== -->
    <div class="bg-white p-2 sm:p-10 rounded-3xl shadow-sm print:shadow-none print:p-0">

        <!-- KOP SURAT (Hanya muncul saat cetak) -->
        <div class="hidden print:block text-center border-b-4 border-double border-black pb-4 mb-8">
            <h1 class="text-3xl font-bold uppercase">Access Coffe</h1>
            <p class="text-sm">Jl. Akses Bandara Internasional Minangkabau No.9, Katapiang, Kec. Batang Anai, Kabupaten Padang Pariaman, Sumatera Barat 25586 | No. Telp: +62 812-7056-2674</p>
            <p class="text-sm italic">Email: support@tokoanda.com</p>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-2xl font-black uppercase underline decoration-[#cc9966]">Laporan Laba Rugi</h2>
            <p class="text-gray-600">Periode: {{ $start->format('d F Y') }} s/d {{ $end->format('d F Y') }}</p>
        </div>

        <!-- RINGKASAN FORMAL (Grid 2 Kolom) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <!-- SEKSI PENDAPATAN -->
            <div class="space-y-4">
                <h3 class="font-bold border-b-2 border-[#cc9966] pb-1 text-[#7a3939] uppercase text-sm tracking-widest">A. Pendapatan (Incomes)</h3>
                <div class="flex justify-between text-sm">
                    <span>Total Penjualan Kotor</span>
                    <span>Rp {{ number_format($pemasukan + $total_diskon_diberikan, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-red-600">
                    <span>Potongan Harga / Promo</span>
                    <span>(Rp {{ number_format($total_diskon_diberikan, 0, ',', '.') }})</span>
                </div>
                <div class="flex justify-between font-bold border-t pt-2 text-emerald-700">
                    <span>Total Pendapatan Bersih</span>
                    <span>Rp {{ number_format($pemasukan, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- SEKSI PENGELUARAN -->
            <div class="space-y-4">
                <h3 class="font-bold border-b-2 border-[#cc9966] pb-1 text-[#7a3939] uppercase text-sm tracking-widest">B. Pengeluaran (Expenses)</h3>
                <div class="flex justify-between text-sm">
                    <span>Pembelian Stok Barang</span>
                    <span>Rp {{ number_format($pengeluaran_barang, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Beban Gaji Karyawan</span>
                    <span>Rp {{ number_format($pengeluaran_gaji, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold border-t pt-2 text-red-700">
                    <span>Total Pengeluaran</span>
                    <span>Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- TOTAL LABA RUGI AKHIR -->
        <div class="mt-10 p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-[#cc9966] flex justify-between items-center">
            <h3 class="text-xl font-black uppercase text-gray-700">Laba Rugi Bersih (Net Profit)</h3>
            <span class="text-1xl font-black {{ $laba_rugi >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                Rp {{ number_format($laba_rugi, 0, ',', '.') }}
            </span>
        </div>

        <!-- TABEL RINCIAN (Hanya Penjualan untuk memperpendek laporan resmi) -->
        <div class="mt-12 space-y-4">
            <h3 class="font-bold text-center uppercase text-sm">Rincian Transaksi Penjualan</h3>
            <table class="w-full border-collapse border border-gray-300 text-xs">
                <thead>
                    <tr class="bg-gray-100 uppercase">
                        <th class="border border-gray-300 px-3 py-2">No</th>
                        <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                        <th class="border border-gray-300 px-3 py-2">Kode Invoice</th>
                        <th class="border border-gray-300 px-3 py-2">Kasir</th>
                        <th class="border border-gray-300 px-3 py-2 text-right">Total Netto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_penjualan as $index => $item)
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border border-gray-300 px-3 py-2 font-mono uppercase">{{ $item->kode_transaksi }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $item->user->name ?? '-' }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-3 py-2 text-right uppercase">Total Akumulasi</td>
                        <td class="border border-gray-300 px-3 py-2 text-right">Rp {{ number_format($pemasukan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- TANDA TANGAN (Hanya muncul saat cetak) -->
        <div class="hidden print:grid grid-cols-2 mt-20 text-center">
            <div>
                <p class="mb-20">Disiapkan Oleh (Admin/Kasir),</p>
                <p class="font-bold underline">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <p class="mb-20">Disetujui Oleh (Owner),</p>
                <p class="font-bold underline">(........................................)</p>
            </div>
        </div>

        <!-- FOOTER CETAK -->
        {{-- <div class="hidden print:block mt-10 text-[10px] text-gray-400 italic text-center">
            Dicetak otomatis oleh sistem pada {{ now()->format('d/m/Y H:i:s') }}
        </div> --}}

    </div>
</div>

<!-- CSS KHUSUS CETAK -->
<style>
    @media print {
        /* Hilangkan elemen dashboard */
        aside, nav, header, .print\:hidden {
            display: none !important;
        }

        /* Atur Layout Body */
        body {
            background-color: white !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact;
        }

        /* Pastikan konten utama mengambil lebar penuh */
        main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* Sembunyikan Scrollbar */
        ::-webkit-scrollbar {
            display: none;
        }

        /* Ukuran Kertas A4 */
        @page {
            size: A4;
            margin: 2cm;
        }

        /* Perbaiki Warna saat Print */
        .text-emerald-700 { color: #047857 !important; }
        .text-red-700 { color: #b91c1c !important; }
        .bg-gray-50 { background-color: #f9fafb !important; }
        .border-[#cc9966] { border-color: #cc9966 !important; }
    }
</style>
@endsection
