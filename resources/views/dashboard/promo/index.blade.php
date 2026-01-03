@extends('layouts.app')

@section('title', 'Manajemen Promo')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Promo Berjalan</h2>
            <p class="text-sm text-gray-500">Kelola diskon khusus untuk varian menu tertentu.</p>
        </div>
        <a href="{{ route('promo.create') }}" class="bg-[#cc9966] hover:bg-[#b38659] text-white px-5 py-2.5 rounded-xl shadow-lg transition-all flex items-center gap-2 font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Buat Promo Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-[#7a3939] uppercase text-[10px] tracking-widest font-black">
                    <th class="px-6 py-4">Menu & Variasi</th>
                    <th class="px-6 py-4">Diskon</th>
                    <th class="px-6 py-4">Periode</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($promos as $promo)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $promo->variant->menu->nama_menu }}</div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $promo->variant->nama_variasi }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-red-50 text-red-600 font-black px-3 py-1 rounded-lg">
                            {{ $promo->jenis_promo == 'persen' ? $promo->nilai_diskon . '%' : 'Rp ' . number_format($promo->nilai_diskon) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        <div>{{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y, H:i') }}</div>
                        <div class="text-[10px] italic">s/d {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="{{ $promo->status == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }} text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                            {{ $promo->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('promo.edit', $promo->id) }}" class="text-blue-500 hover:text-blue-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                            </a>
                            <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus promo ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada promo yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-50">
            {{ $promos->links() }}
        </div>
    </div>
</div>
@endsection
