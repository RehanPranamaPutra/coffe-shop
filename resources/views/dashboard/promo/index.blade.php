@extends('layouts.app')

@php
    $pageTitle = 'Manajemen Promo';
    $headerIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-1.052-1.332L5 15.77a2 2 0 01-1-1.751V7.76a2 2 0 011-1.751l5-2.618a2 2 0 012 0l5 2.618a2 2 0 011 1.75v5.474a1.76 1.76 0 01-1.052 1.332v-13.36M18 17a2 2 0 11-4 0 2 2 0 014 0zM15 17h6" />
    </svg>';
@endphp

@section('content')
    <div class="space-y-6">
        {{-- Success Message Toast (Sama seperti produk) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl flex items-center gap-3 animate-fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Header Section dengan Statistik Promo --}}
        @php
            $now = now();
            // Asumsi: status promo ditentukan berdasarkan tanggal_mulai dan tanggal_selesai
            $promoAktif = $promos->where('tanggal_mulai', '<=', $now)->where('tanggal_selesai', '>=', $now)->count();
            $promoAkanDatang = $promos->where('tanggal_mulai', '>', $now)->count();
            $promoKadaluarsa = $promos->where('tanggal_selesai', '<', $now)->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Promo --}}
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">Total Promo</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $promos->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h.01M7 21h.01M17 3h.01M17 21h.01M10 7h.01M10 3h.01M10 21h.01M14 7h.01M14 3h.01M14 21h.01M18 10h.01M18 14h.01M18 18h.01M18 6h.01M6 10h.01M6 14h.01M6 18h.01M6 6h.01M12 12h.01M12 16h.01M12 20h.01M12 4h.01M16 12h.01M8 12h.01" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Promo Aktif --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Promo Aktif</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $promoAktif }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Promo Akan Datang --}}
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Akan Datang</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $promoAkanDatang }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h.01M10 11h.01M12 11h.01M14 11h.01M16 11h.01M3 20h18M3 8h18M3 8V6a2 2 0 012-2h14a2 2 0 012 2v2M3 8v10a2 2 0 002 2h14a2 2 0 002-2v-10" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Promo Kadaluarsa --}}
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Kadaluarsa</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $promoKadaluarsa }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        ---

        {{-- Main Content Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Toolbar --}}
            <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-white">Daftar Promo Aktif</h3>
                        <p class="text-white/80 text-sm mt-1">Kelola semua diskon dan promosi</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Search Bar --}}
                        <div class="relative">
                            <input type="text" placeholder="Cari promo..."
                                class="pl-10 pr-4 py-2.5 rounded-lg border-0 focus:ring-2 focus:ring-white/50 w-full sm:w-64"
                                id="searchInput">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        {{-- Add Button --}}
                        <a href="{{ route('promo.create') }}"
                            class="bg-white text-[#7a3939] px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition duration-200 flex items-center justify-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Promo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Diskon
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Periode
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="promoTable">
                        @forelse($promos as $promo)
                            @php
                                $isAktif = $promo->tanggal_mulai <= $now && $promo->tanggal_selesai >= $now;
                                $isAkanDatang = $promo->tanggal_mulai > $now;
                                $isKadaluarsa = $promo->tanggal_selesai < $now;

                                if ($isAktif) {
                                    $statusText = 'Aktif';
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif ($isAkanDatang) {
                                    $statusText = 'Akan Datang';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                } else {
                                    $statusText = 'Kadaluarsa';
                                    $statusClass = 'bg-red-100 text-red-800';
                                }

                                // Format nilai diskon
                                if ($promo->jenis_promo === 'persen') {
                                    $diskonDisplay = number_format($promo->nilai_diskon, 0) . ' %';
                                    $jenisClass = 'bg-blue-100 text-blue-800';
                                } else {
                                    // Nominal
                                    $diskonDisplay = 'Rp ' . number_format($promo->nilai_diskon, 0, ',', '.');
                                    $jenisClass = 'bg-purple-100 text-purple-800';
                                }

                                // Format tanggal
                                $tglMulai = \Carbon\Carbon::parse($promo->tanggal_mulai)->isoFormat('D MMM YY');
                                $tglSelesai = \Carbon\Carbon::parse($promo->tanggal_selesai)->isoFormat('D MMM YY');
                            @endphp

                            <tr class="hover:bg-gray-50 transition duration-150">
                                {{-- Produk Info (Asumsi Model Promo memiliki relasi 'menu') --}}
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $promo->menu->nama_menu ?? 'Produk Dihapus' }}</p>
                                    <p class="text-sm text-gray-500">({{ $promo->menu_id }})</p>
                                </td>

                                {{-- Diskon --}}
                                <td class="px-6 py-4">
                                    <p class="font-bold text-lg text-[#7a3939]">{{ $diskonDisplay }}</p>
                                </td>

                                {{-- Jenis --}}
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $jenisClass }}">
                                        {{ ucfirst($promo->jenis_promo) }}
                                    </span>
                                </td>

                                {{-- Periode --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $tglMulai }} &mdash; {{ $tglSelesai }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                        <span class="w-2 h-2 {{ str_contains($statusClass, 'green') ? 'bg-green-500' : (str_contains($statusClass, 'yellow') ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full"></span>
                                        {{ $statusText }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Detail --}}
                                        <a href="{{ route('promo.show', $promo->id) }}"
                                            class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200"
                                            title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('promo.edit', $promo->id) }}"
                                            class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('promo.destroy', $promo->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus promo ini? Tindakan ini tidak dapat dibatalkan.')"
                                            class="inline-block">
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
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5.882V19.24a1.76 1.76 0 01-1.052-1.332L5 15.77a2 2 0 01-1-1.751V7.76a2 2 0 011-1.751l5-2.618a2 2 0 012 0l5 2.618a2 2 0 011 1.75v5.474a1.76 1.76 0 01-1.052 1.332v-13.36M18 17a2 2 0 11-4 0 2 2 0 014 0zM15 17h6" />
                                        </svg>
                                        <p class="text-gray-500 font-semibold">Belum ada promo yang dibuat</p>
                                        <p class="text-gray-400 text-sm mt-1">Buat diskon menarik untuk meningkatkan penjualan!</p>
                                        <a href="{{ route('promo.create') }}"
                                            class="mt-4 px-6 py-2 bg-[#7a3939] text-white rounded-lg hover:bg-[#8d4343] transition duration-200">
                                            Tambah Promo Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (jika diperlukan) --}}
            {{-- @if ($promos->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $promos->links() }}
                </div>
            @endif --}}
        </div>
    </div>

    {{-- Simple Search Script (disesuaikan untuk mencari di nama produk dan periode) --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#promoTable tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                // Mencari di semua kolom teks
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
@endsection