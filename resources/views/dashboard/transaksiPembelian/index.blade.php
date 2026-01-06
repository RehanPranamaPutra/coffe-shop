@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">📦 Daftar Transaksi Pembelian</h1>
                <p class="text-gray-500 mt-1">Ringkasan semua transaksi pembelian barang.</p>
            </div>
            <a href="{{ route('pembelian.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg shadow transition-all">
               + Tambah Pembelian
            </a> 
        </div>

        <!-- Pencarian & Filter -->
        <form method="GET" action="{{ route('pembelian.index') }}" class="bg-white p-5 rounded-xl shadow mb-6 flex flex-col sm:flex-row gap-4 sm:items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Barang</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Masukkan nama barang..."
                       class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex-1">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Filter Kategori</label>
                <select name="kategori" id="kategori"
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Kategori</option>
                    @php
                        $kategoriList = collect($transaksiPembelian)->pluck('kategori')->unique()->filter();
                    @endphp
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ ucfirst($kategori) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition-all">
                    🔍 Cari
                </button>
                @if(request()->has('search') || request()->has('kategori'))
                    <a href="{{ route('pembelian.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-5 py-2.5 rounded-lg shadow transition-all">
                        🔄 Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel -->
        @php
            $data = $transaksiPembelian
                ->when(request('search'), fn($q) => $q->filter(fn($item) => str_contains(strtolower($item->nama_barang), strtolower(request('search')))))
                ->when(request('kategori'), fn($q) => $q->where('kategori', request('kategori')));
        @endphp

        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <table class="min-w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Nama Barang</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Kategori</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Jumlah</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Harga</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Total</th>
                        <th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $p)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-5 py-3">{{ $index + 1 }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ ucfirst($p->nama_barang) }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ ucfirst($p->kategori) }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $p->jumlah }}</td>
                            <td class="px-5 py-3 text-gray-700">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-gray-700 font-semibold">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 flex justify-center gap-3">
                                <a href="{{ route('pembelian.show', $p->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
                                <a href="{{ route('pembelian.edit', $p->id) }}"
                                   class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                                <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
