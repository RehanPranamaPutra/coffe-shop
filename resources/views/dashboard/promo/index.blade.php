@extends('layouts.app')

@php
    $pageTitle = 'Manajemen Promo';
@endphp

@section('content')
<div class="space-y-4 sm:space-y-6">

    {{-- Success Toast --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Statistik Promo --}}
    @php
        $now = now();
        $promoAktif = $promos->where('tanggal_mulai', '<=', $now)->where('tanggal_selesai', '>=', $now)->count();
        $promoAkanDatang = $promos->where('tanggal_mulai', '>', $now)->count();
        $promoKadaluarsa = $promos->where('tanggal_selesai', '<', $now)->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Promo --}}
        <div class="bg-gradient-to-br from-[#7a3939] to-[#cc9966] text-white rounded-xl p-5 shadow-lg">
            <p class="text-sm">Total Promo</p>
            <h3 class="text-3xl font-bold">{{ $promos->count() }}</h3>
        </div>

        {{-- Aktif --}}
        <div class="bg-gradient-to-br from-[#7a3939] to-[#cc9966] text-white rounded-xl p-5 shadow-lg">
            <p class="text-sm">Promo Aktif</p>
            <h3 class="text-3xl font-bold">{{ $promoAktif }}</h3>
        </div>

        {{-- Akan Datang --}}
        <div class="bg-gradient-to-br from-[#7a3939] to-[#cc9966] text-white rounded-xl p-5 shadow-lg">
            <p class="text-sm">Akan Datang</p>
            <h3 class="text-3xl font-bold">{{ $promoAkanDatang }}</h3>
        </div>

        {{-- Kadaluarsa --}}
        <div class="bg-gradient-to-br from-[#7a3939] to-[#cc9966] text-white rounded-xl p-5 shadow-lg">
            <p class="text-sm">Kadaluarsa</p>
            <h3 class="text-3xl font-bold">{{ $promoKadaluarsa }}</h3>
        </div>

    </div>

    {{-- Card Container --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        {{-- Header Toolbar --}}
        <div class="bg-gradient-to-r from-[#7a3939] to-[#cc9966] p-5">
            <div class="flex flex-col sm:flex-row sm:justify-between gap-3">

                {{-- Title --}}
                <div>
                    <h3 class="text-xl font-bold text-white">Daftar Promo</h3>
                    <p class="text-white/80 text-sm">Semua daftar promo (aktif / akan datang / kadaluarsa)</p>
                </div>

                {{-- Search --}}
                <div class="flex-1 relative">
                    <input id="searchInput" type="text"
                        class="pl-10 pr-4 py-2 rounded-lg w-full focus:ring-2 focus:ring-white/50"
                        placeholder="Cari promo...">
                    <svg class="w-5 h-5 text-gray-200 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                {{-- Add --}}
                <a href="{{ route('promo.create') }}"
                    class="bg-white text-[#7a3939] px-4 py-2 rounded-lg font-semibold shadow hover:bg-gray-50 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Promo
                </a>

            </div>
        </div>

        {{-- TABLE DESKTOP --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm" id="promoTable">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="p-3">Menu</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Diskon</th>
                        <th class="p-3">Periode</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($promos as $promo)
                        @php
                            if ($promo->tanggal_mulai > now()) {
                                $status = 'Akan Datang';
                                $badge = 'bg-blue-100 text-blue-700';
                            } elseif ($promo->tanggal_selesai < now()) {
                                $status = 'Kadaluarsa';
                                $badge = 'bg-red-100 text-red-700';
                            } else {
                                $status = 'Aktif';
                                $badge = 'bg-green-100 text-green-700';
                            }
                        @endphp

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-medium">{{ $promo->menu->nama_menu }}</td>
                            <td class="p-3">{{ ucfirst($promo->jenis_promo) }}</td>
                            <td class="p-3">
                                {{ $promo->jenis_promo == 'persen' ? $promo->nilai_diskon.'%' : 'Rp '.number_format($promo->nilai_diskon,0,',','.') }}
                            </td>
                            <td class="p-3">
                                {{ $promo->tanggal_mulai->format('d M Y H:i') }} —
                                {{ $promo->tanggal_selesai->format('d M Y H:i') }}
                            </td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="p-3 text-center flex gap-2 justify-center">

                                <a href="{{ route('promo.edit', $promo->id) }}"
                                    class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg">Edit</a>

                                <form action="{{ route('promo.destroy', $promo->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-100 text-red-700 rounded-lg">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="md:hidden space-y-4 p-4" id="promoCards">

            @foreach ($promos as $promo)
                @php
                    if ($promo->tanggal_mulai > now()) {
                        $status = 'Akan Datang';
                        $badge = 'bg-blue-100 text-blue-700';
                    } elseif ($promo->tanggal_selesai < now()) {
                        $status = 'Kadaluarsa';
                        $badge = 'bg-red-100 text-red-700';
                    } else {
                        $status = 'Aktif';
                        $badge = 'bg-green-100 text-green-700';
                    }
                @endphp

                <div class="border rounded-xl p-4 shadow-sm bg-white">
                    <h4 class="font-bold text-lg">{{ $promo->menu->nama_menu }}</h4>

                    <p class="text-sm text-gray-600 mt-1">
                        {{ ucfirst($promo->jenis_promo) }} -
                        {{ $promo->jenis_promo == 'persen'
                          ? $promo->nilai_diskon.'%'
                          : 'Rp '.number_format($promo->nilai_diskon,0,',','.') }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $promo->tanggal_mulai->format('d M Y H:i') }} —
                        {{ $promo->tanggal_selesai->format('d M Y H:i') }}
                    </p>

                    <span class="px-3 py-1 mt-2 inline-block rounded-full text-xs font-semibold {{ $badge }}">
                        {{ $status }}
                    </span>

                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('promo.edit', $promo->id) }}"
                            class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-sm w-full text-center">
                            Edit
                        </a>

                        <form action="{{ route('promo.destroy', $promo->id) }}" method="POST"
                              onsubmit="return confirm('Hapus promo ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm w-full">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $promos->links() }}
        </div>

    </div>
</div>

<script>
    // SEARCH
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let value = this.value.toLowerCase();

        // Table rows
        document.querySelectorAll("#promoTable tbody tr").forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
        });

        // Cards
        document.querySelectorAll("#promoCards > div").forEach(card => {
            card.style.display = card.textContent.toLowerCase().includes(value) ? "" : "none";
        });
    });
</script>

@endsection
