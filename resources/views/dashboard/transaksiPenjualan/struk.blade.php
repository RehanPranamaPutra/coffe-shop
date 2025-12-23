@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center py-10 print:bg-white print:py-0">

    <!-- Tombol Aksi (Hilang saat Print) -->
    <div class="mb-6 flex space-x-4 print:hidden">
        <a href="{{ route('penjualan.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-600 transition">
            &larr; Kembali ke Menu
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Struk
        </button>
    </div>

    <!-- AREA STRUK -->
    <div class="bg-white w-[380px] p-6 shadow-xl relative text-gray-800 font-mono text-sm print:shadow-none print:w-full print:p-0">

        <!-- Header Toko -->
        <div class="text-center mb-4 border-b-2 border-dashed border-gray-300 pb-4">
            <h1 class="text-2xl font-bold uppercase tracking-widest text-gray-900">Accsess Coffe</h1>
            <p class="text-xs text-gray-500">Jl. Contoh No. 123, Jakarta</p>
            <p class="text-xs text-gray-500">Telp: 0812-3456-7890</p>
        </div>

        <!-- Info Transaksi -->
        <div class="mb-4 text-xs">
            <div class="flex justify-between">
                <span>No. Transaksi</span>
                <span class="font-bold">{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="flex justify-between mt-1">
                <span>Tanggal</span>
                <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between mt-1">
                <span>Kasir</span>
                <span>{{ $transaksi->user->name ?? 'Admin' }}</span> <!-- Relasi User -->
            </div>
        </div>

        <!-- Tabel Item -->
        <div class="border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-left">
                        <th class="pb-2">Item</th>
                        <th class="pb-2 text-center">Qty</th>
                        <th class="pb-2 text-right">Harga</th>
                        <th class="pb-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->items as $item)
                        <!-- Baris Produk Utama -->
                        <tr>
                            <td class="pt-2 font-semibold" colspan="4">{{ $item->menu->nama_menu }}</td>
                        </tr>
                        <tr>
                            <td class="pb-1"></td>
                            <td class="pb-1 text-center">{{ $item->jumlah }}</td>
                            <td class="pb-1 text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="pb-1 text-right font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>

                        <!-- Baris Diskon Per Item (Jika Ada) -->
                        @if($item->diskon > 0)
                            <tr class="text-gray-500 italic">
                                <td colspan="3" class="text-right pr-2 text-[10px]">Diskon Item:</td>
                                <td class="text-right text-[10px]">-{{ number_format($item->diskon, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Kalkulasi Harga -->
        <div class="space-y-2 text-xs mb-4 border-b-2 border-dashed border-gray-300 pb-4">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>

            @if($transaksi->potongan > 0)
            <div class="flex justify-between text-red-500">
                <span>Potongan (Promo)</span>
                <span>- Rp {{ number_format($transaksi->potongan, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="flex justify-between text-base font-bold text-black pt-2 border-t border-dashed border-gray-200 mt-2">
                <span>TOTAL BAYAR</span>
                <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Pembayaran -->
        <div class="space-y-2 text-xs mb-6">
            <div class="flex justify-between">
                <span>Tunai / Dibayar</span>
                <span>Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs space-y-1">
            <p>*** TERIMA KASIH ***</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
            <p class="pt-2 font-bold">WIFI: Cafe_ABC / Pass: kopi123</p>

            <!-- Barcode (Opsional - Simulasi) -->
            <div class="mt-4 flex justify-center opacity-70">
                <svg class="h-10 w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
                    <path d="M0 0h1v10H0zm2 0h1v10H2zm2 0h2v10H4zm3 0h1v10H7zm2 0h1v10H9zm2 0h3v10h-3zm4 0h1v10h-1zm2 0h1v10h-1zm2 0h2v10h-2zm3 0h1v10h-1zm2 0h1v10h-1zm2 0h3v10h-3zm4 0h1v10h-1z" fill="black"/>
                </svg>
            </div>
        </div>

        <!-- Kertas Sobek Effect (Hiasan Bawah) -->
        <div class="absolute -bottom-1 left-0 w-full h-2 bg-transparent bg-[length:20px_20px] bg-[radial-gradient(circle,transparent_50%,#f3f4f6_50%)] bg-[position:-10px_-10px] print:hidden"></div>
    </div>
</div>

<style>
    @media print {
        @page {
            margin: 0;
            size: auto;
        }
        body * {
            visibility: hidden;
        }
        .print\:hidden {
            display: none !important;
        }
        /* Hanya tampilkan area struk */
        .bg-white, .bg-white * {
            visibility: visible;
        }
        .bg-white {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm; /* Standar lebar kertas thermal */
            box-shadow: none;
        }
    }
</style>
@endsection
