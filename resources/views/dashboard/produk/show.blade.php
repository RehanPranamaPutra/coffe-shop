@extends('layouts.app')

@php
    $pageTitle = 'Detail Produk';
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>';
@endphp

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('produk.index') }}"
           class="inline-flex items-center gap-2 text-gray-600 hover:text-[#7a3939] font-semibold transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Produk
        </a>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column - Image & Actions --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Image Card --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="aspect-square">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama_menu }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-white rounded-xl shadow-lg p-6 space-y-3">
                <h3 class="font-bold text-gray-700 mb-4">Aksi</h3>

                {{-- Edit Button --}}
                <a href="{{ route('produk.edit', $produk->id) }}"
                   class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Produk
                </a>

                {{-- Delete Button --}}
                <form action="{{ route('produk.destroy', $produk->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Produk
                    </button>
                </form>
            </div>

            {{-- Info Card --}}
            <div class="bg-gradient-to-br from-[#7a3939] to-[#cc9966] rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-bold text-lg">Informasi</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <p><span class="text-white/70">Dibuat:</span> {{ $produk->created_at->format('d M Y, H:i') }}</p>
                    <p><span class="text-white/70">Diupdate:</span> {{ $produk->updated_at->format('d M Y, H:i') }}</p>
                    <p><span class="text-white/70">Slug:</span> {{ $produk->slug }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column - Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Product Info Card --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $produk->nama_menu }}</h1>
                            @if($produk->kategori)
                                <span class="inline-block px-3 py-1 bg-white/20 text-white text-sm font-semibold rounded-full">
                                    {{ $produk->kategori }}
                                </span>
                            @endif
                        </div>
                        <div class="text-right">
                            @if($produk->status === 'Tersedia')
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white text-sm font-bold rounded-full">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white text-sm font-bold rounded-full">
                                    <span class="w-2 h-2 bg-white rounded-full"></span>
                                    Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div class="p-6 space-y-6">
                    {{-- Price & Stock --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Price --}}
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-200">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Harga</p>
                                    <p class="text-2xl font-bold text-[#7a3939]">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Stock --}}
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-200">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-green-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Stok Tersedia</p>
                                    <p class="text-2xl font-bold {{ $produk->stok < 10 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $produk->stok }} Unit
                                    </p>
                                    @if($produk->stok < 10)
                                        <p class="text-xs text-red-600 font-semibold mt-1">⚠️ Stok Menipis!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($produk->deskripsi)
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="font-bold text-gray-700">Deskripsi Produk</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi }}</p>
                    </div>
                    @endif

                    {{-- Additional Info Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Status --}}
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            <p class="font-bold text-sm {{ $produk->status === 'Tersedia' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $produk->status }}
                            </p>
                        </div>

                        {{-- Category --}}
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <p class="text-xs text-gray-500 mb-1">Kategori</p>
                            <p class="font-bold text-sm text-gray-700">{{ $produk->kategori ?? '-' }}</p>
                        </div>

                        {{-- Price per Unit --}}
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-xs text-gray-500 mb-1">Harga/Unit</p>
                            <p class="font-bold text-sm text-[#7a3939]">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>

                        {{-- Total Value --}}
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-gray-500 mb-1">Nilai Total</p>
                            <p class="font-bold text-sm text-blue-600">Rp {{ number_format($produk->harga * $produk->stok, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock Alert --}}
            @if($produk->stok < 10)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-yellow-800 mb-1">Peringatan Stok Menipis</h3>
                        <p class="text-sm text-yellow-700">Stok produk ini tinggal {{ $produk->stok }} unit. Segera lakukan restocking untuk menghindari kehabisan stok.</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Out of Stock Alert --}}
            @if($produk->status === 'Tidak Tersedia')
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-red-800 mb-1">Produk Tidak Tersedia</h3>
                        <p class="text-sm text-red-700">Produk ini sedang tidak tersedia untuk dijual. Ubah status menjadi "Tersedia" untuk mengaktifkan kembali.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
