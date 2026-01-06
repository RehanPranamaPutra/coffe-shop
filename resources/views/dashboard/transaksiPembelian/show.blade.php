@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            📋 Detail Transaksi Pembelian
        </h1>

        <div class="space-y-4">
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Nama Barang</span>
                <span class="text-gray-800 font-semibold">{{ ucfirst($transaksiPembelian->nama_barang) }}</span>
            </div> 

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Kategori</span>
                <span class="text-gray-800">{{ ucfirst($transaksiPembelian->kategori) }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Jumlah</span>
                <span class="text-gray-800">{{ $transaksiPembelian->jumlah }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Harga Satuan</span>
                <span class="text-gray-800">Rp {{ number_format($transaksiPembelian->harga, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Total</span>
                <span class="text-indigo-700 font-bold">Rp {{ number_format($transaksiPembelian->total, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Tanggal Input</span>
                <span class="text-gray-800">{{ $transaksiPembelian->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('pembelian.edit', $transaksiPembelian->id) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg font-medium transition">
               ✏️ Edit
            </a>

            <a href="{{ route('pembelian.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2.5 rounded-lg font-medium transition">
               ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
