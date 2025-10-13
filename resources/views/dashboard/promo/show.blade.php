@extends('layouts.app')

@php
    $pageTitle = 'Detail Promo';
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>';

    // Logic status menggunakan Accessor yang kita buat di Model Promo
    $statusClass = [
        'Aktif' => 'bg-green-500 text-white',
        'Akan Datang' => 'bg-yellow-500 text-gray-900',
        'Kadaluarsa' => 'bg-red-500 text-white',
    ];
    $status = $promo->status;

    // Format Diskon
    if ($promo->jenis_promo === 'persen') {
        $diskonDisplay = number_format($promo->nilai_diskon, 0) . ' %';
        $jenisPromoText = 'Persentase';
    } else {
        $diskonDisplay = 'Rp ' . number_format($promo->nilai_diskon, 0, ',', '.');
        $jenisPromoText = 'Nominal';
    }
@endphp

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('promo.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-[#7a3939] font-semibold transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Promo
            </a>
        </div>

        {{-- Detail Card --}}
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-100">

            {{-- Header Card dengan Status --}}
            <div class="p-6 bg-gradient-to-r from-[#7a3939] to-[#cc9966] flex justify-between items-center">
                <h3 class="text-3xl font-extrabold text-white">Promo: {{ $promo->menu->nama_menu ?? 'Produk Dihapus' }}</h3>
                <span class="px-4 py-1 rounded-full text-sm font-bold shadow-md {{ $statusClass[$status] ?? 'bg-gray-500 text-white' }}">
                    {{ $status }}
                </span>
            </div>

            {{-- Detail Content --}}
            <div class="p-8 space-y-6">

                {{-- Section Diskon --}}
                <div class="border-b pb-4">
                    <p class="text-lg font-bold text-gray-700 mb-1">Nilai Diskon</p>
                    <p class="text-4xl font-extrabold text-[#7a3939]">{{ $diskonDisplay }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">

                    {{-- Informasi Produk --}}
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">Produk Terkait (ID)</p>
                        <p class="text-gray-900 font-semibold">{{ $promo->menu->nama_menu ?? 'Produk Tidak Ditemukan' }}</p>
                        <p class="text-xs text-gray-500">ID Menu: {{ $promo->menu_id }}</p>
                    </div>

                    {{-- Jenis Promo --}}
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">Jenis Promo</p>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white {{ $promo->jenis_promo === 'persen' ? 'bg-blue-600' : 'bg-purple-600' }}">
                            {{ $jenisPromoText }}
                        </span>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">Mulai Berlaku</p>
                        <p class="text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                        <p class="text-sm text-gray-500">Pukul: {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->isoFormat('HH:mm') }} WIB</p>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="space-y-2">
                        <p class="text-sm font-bold text-gray-700">Berakhir Pada</p>
                        <p class="text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                         <p class="text-sm text-gray-500">Pukul: {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->isoFormat('HH:mm') }} WIB</p>
                    </div>
                </div>

            </div>

            {{-- Footer / Action Buttons --}}
            <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                 <form action="{{ route('promo.destroy', $promo->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus promo ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200 shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('promo.edit', $promo->id) }}"
                    class="px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-200 shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Promo
                </a>
            </div>
        </div>
    </div>
@endsection
