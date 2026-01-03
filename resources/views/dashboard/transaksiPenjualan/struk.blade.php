@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex flex-col items-center py-10 print:bg-white print:py-0">

        <!-- Tombol Aksi -->
        <div class="mb-6 flex space-x-4 print:hidden">
            <a href="{{ route('penjualan.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-xl shadow hover:bg-gray-600 transition text-sm font-bold">
                &larr; Kembali ke Kasir
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 bg-[#7a3939] text-white rounded-xl shadow hover:opacity-90 transition flex items-center text-sm font-bold">
                Cetak Struk
            </button>
        </div>

        <!-- AREA STRUK -->
        <div
            class="bg-white w-[380px] p-8 shadow-2xl relative text-gray-800 font-mono text-sm print:shadow-none print:w-full print:p-0">

            <!-- Header -->
            <div class="text-center mb-6 border-b-2 border-dashed border-gray-300 pb-6">
                <h1 class="text-2xl font-black uppercase tracking-tighter text-gray-900">Access Coffee</h1>
                <p class="text-[10px] text-gray-500 leading-tight mt-1">Padang Pariaman, Sumatera Barat</p>
            </div>

            <!-- Info Transaksi -->
            <div class="mb-4 text-[11px] space-y-1">
                <div class="flex justify-between">
                    <span>No. TRX</span>
                    <span class="font-bold">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tanggal</span>
                    <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between border-b border-dashed border-gray-100 pb-2">
                    <span>Kasir</span>
                    <span class="uppercase">{{ $transaksi->user->name ?? 'Admin' }}</span>
                </div>
            </div>

            <!-- Tabel Item -->
            <div class="mb-4">
                <table class="w-full text-[11px]">
                    <thead>
                        <tr class="text-left border-b border-gray-100">
                            <th class="py-2">Item</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($transaksi->items as $item)
    @php
        // Cari nama variasi dengan mencocokkan harga_satuan di transaksi
        // dengan harga yang ada di daftar varian menu tersebut
        $variantTerpilih = $item->menu->variants
            ->where('harga', $item->harga_satuan)
            ->first();
    @endphp
    <tr>
        <td class="py-3">
            <!-- Nama Menu Utama -->
            <div class="font-bold text-gray-900 uppercase leading-tight">
                {{ $item->menu->nama_menu }}
            </div>

            <!-- Nama Variasi Terdeteksi (Hasil pencocokan harga) -->
            @if($variantTerpilih)
                <div class="text-[10px] text-[#7a3939] font-bold uppercase mt-0.5">
                    {{ $variantTerpilih->nama_variasi }}
                </div>
            @endif

            <div class="text-[9px] text-gray-400">
                @ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
            </div>

            @if($item->diskon > 0)
                <div class="text-[9px] text-red-500 italic">
                    Disc: -Rp {{ number_format($item->diskon, 0, ',', '.') }}
                </div>
            @endif
        </td>
        <td class="py-3 text-center text-gray-600 text-xs">x{{ $item->jumlah }}</td>
        <td class="py-3 text-right font-black text-gray-900 text-xs">
            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
        </td>
    </tr>
@endforeach
                    </tbody>
                </table>
            </div>

            <!-- Kalkulasi -->
            <div class="pt-4 border-t-2 border-dashed border-gray-200 space-y-2 text-xs">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                </div>

                @if ($transaksi->potongan > 0)
                    <div class="flex justify-between text-red-500">
                        <span>Hemat (Promo)</span>
                        <span>- Rp {{ number_format($transaksi->potongan, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div
                    class="flex justify-between text-lg font-black text-black pt-2 border-t border-dashed border-gray-200 mt-2">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="mt-4 pt-4 border-t border-gray-100 space-y-1 text-xs">
                <div class="flex justify-between">
                    <span>Tunai / Bayar</span>
                    <span>Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-emerald-600 uppercase">
                    <span>Kembalian</span>
                    <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="text-center mt-10 text-[10px] space-y-2 text-gray-400 uppercase tracking-tighter">
                <p class="font-bold text-gray-700">*** TERIMA KASIH ***</p>
                <p>Access Coffee Station</p>
            </div>

        </div>
    </div>

    <style>
        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }

            body * {
                visibility: hidden;
            }

            .print\:hidden,
            nav,
            header {
                display: none !important;
            }

            .bg-white,
            .bg-white * {
                visibility: visible;
            }

            .bg-white {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection
