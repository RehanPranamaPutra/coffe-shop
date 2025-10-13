@extends('layouts.app')

@php
    $pageTitle = 'Manajemen Produk';
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    </svg>';
@endphp

@section('content')
    <div class="space-y-4 sm:space-y-6">
        {{-- Success Message Toast --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-xl flex items-center gap-2 sm:gap-3 animate-fade-in max-w-sm">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold text-sm sm:text-base">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Header Section dengan Statistik --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            {{-- Total Produk --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg sm:rounded-xl p-4 sm:p-6 text-white shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex-1">
                        <p class="text-blue-100 text-xs sm:text-sm font-medium">Total Produk</p>
                        <h3 class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $menus->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-2 sm:p-3 rounded-lg w-fit">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Produk Tersedia --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg sm:rounded-xl p-4 sm:p-6 text-white shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex-1">
                        <p class="text-green-100 text-xs sm:text-sm font-medium">Tersedia</p>
                        <h3 class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $menus->where('status', 'Tersedia')->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-2 sm:p-3 rounded-lg w-fit">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stok Menipis --}}
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg sm:rounded-xl p-4 sm:p-6 text-white shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex-1">
                        <p class="text-yellow-100 text-xs sm:text-sm font-medium">Stok < 10</p>
                        <h3 class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $menus->where('stok', '<', 10)->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-2 sm:p-3 rounded-lg w-fit">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tidak Tersedia --}}
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg sm:rounded-xl p-4 sm:p-6 text-white shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex-1">
                        <p class="text-red-100 text-xs sm:text-sm font-medium">Tidak Tersedia</p>
                        <h3 class="text-2xl sm:text-3xl font-bold mt-1 sm:mt-2">{{ $menus->where('status', 'Tidak Tersedia')->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-2 sm:p-3 rounded-lg w-fit">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-lg sm:rounded-xl shadow-lg overflow-hidden">
            {{-- Toolbar --}}
            <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-4 sm:p-6">
                <div class="flex flex-col gap-3 sm:gap-4">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Daftar Produk</h3>
                        <p class="text-white/80 text-xs sm:text-sm mt-1">Kelola semua produk kopi Anda</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                        {{-- Search Bar --}}
                        <div class="relative flex-1">
                            <input type="text" placeholder="Cari produk..."
                                class="pl-10 pr-4 py-2 sm:py-2.5 rounded-lg border-0 focus:ring-2 focus:ring-white/50 w-full text-sm sm:text-base"
                                id="searchInput">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 top-2.5 sm:top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        {{-- Add Button --}}
                        <a href="{{ route('produk.create') }}"
                            class="bg-white text-[#7a3939] px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition duration-200 flex items-center justify-center gap-2 shadow-lg text-sm sm:text-base whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">Tambah Produk</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View (Hidden on Mobile) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="productTable">
                        @forelse($menus as $menu)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                {{-- Produk Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                            class="w-16 h-16 rounded-lg object-cover shadow-md">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $menu->nama_menu }}</p>
                                            <p class="text-sm text-gray-500 line-clamp-1">{{ $menu->deskripsi ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="px-6 py-4">
                                    @if ($menu->kategori)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $menu->kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>

                                {{-- Harga --}}
                                <td class="px-6 py-4">
                                    <p class="font-bold text-[#7a3939]">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                </td>

                                {{-- Stok --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold
                                        {{ $menu->stok < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $menu->stok }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($menu->status === 'Tersedia')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('produk.show', $menu->id) }}"
                                            class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200"
                                            title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('produk.edit', $menu->id) }}"
                                            class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('produk.destroy', $menu->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-gray-500 font-semibold">Belum ada produk</p>
                                        <p class="text-gray-400 text-sm mt-1">Mulai tambahkan produk pertama Anda</p>
                                        <a href="{{ route('produk.create') }}"
                                            class="mt-4 px-6 py-2 bg-[#7a3939] text-white rounded-lg hover:bg-[#8d4343] transition duration-200">
                                            Tambah Produk
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="md:hidden divide-y divide-gray-200" id="productCards">
                @forelse($menus as $menu)
                    <div class="p-4 hover:bg-gray-50 transition duration-150">
                        <div class="flex gap-3">
                            {{-- Product Image --}}
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}"
                                class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg object-cover shadow-md flex-shrink-0">

                            {{-- Product Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base line-clamp-2">{{ $menu->nama_menu }}</h4>
                                    @if ($menu->status === 'Tersedia')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                            Habis
                                        </span>
                                    @endif
                                </div>

                                @if ($menu->kategori)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 mb-2">
                                        {{ $menu->kategori }}
                                    </span>
                                @endif

                                <div class="flex items-center justify-between mt-2">
                                    <div>
                                        <p class="font-bold text-[#7a3939] text-sm sm:text-base">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">
                                            Stok:
                                            <span class="font-semibold {{ $menu->stok < 10 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $menu->stok }}
                                            </span>
                                        </p>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('produk.show', $menu->id) }}"
                                            class="p-1.5 sm:p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200"
                                            title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('produk.edit', $menu->id) }}"
                                            class="p-1.5 sm:p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('produk.destroy', $menu->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 sm:p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-500 font-semibold text-sm">Belum ada produk</p>
                        <p class="text-gray-400 text-xs mt-1">Mulai tambahkan produk pertama Anda</p>
                        <a href="{{ route('produk.create') }}"
                            class="mt-4 inline-block px-6 py-2 bg-[#7a3939] text-white rounded-lg hover:bg-[#8d4343] transition duration-200 text-sm">
                            Tambah Produk
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Enhanced Search Script untuk Table dan Card View --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();

            // Search for desktop table
            const tableRows = document.querySelectorAll('#productTable tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });

            // Search for mobile cards
            const cards = document.querySelectorAll('#productCards > div');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
@endsection
