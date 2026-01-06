@extends('layouts.app')

@section('title', 'Atur Varian Harga')

@section('content')
{{-- Tambahkan x-data untuk mengelola state Modal Edit --}}
<div class="container mx-auto" x-data="{ openEdit: false, editData: {} }">
    <!-- Breadcrumb -->
    <nav class="mb-4 flex text-sm text-gray-500">
        <a href="{{ route('produk.index') }}" class="hover:text-[#cc9966]">Daftar Menu</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800 font-bold">Varian {{ $produk->nama_menu }}</span>
    </nav>

    @if(session('success'))
        <div class="bg-emerald-500 text-white p-4 mb-4 rounded-xl shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Varian -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-lg font-bold text-[#7a3939] mb-4">Tambah Harga/Varian</h3>
            <form action="{{ route('produk.varian.store', $produk->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Variasi</label>
                        <input type="text" name="nama_variasi" placeholder="Contoh: Cold Arabica" required class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" placeholder="20000" required class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input type="number" name="stok" placeholder="20"  required class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                    <button type="submit" class="w-full bg-[#cc9966] text-white py-3 rounded-xl font-bold hover:bg-[#b38659] transition shadow-lg">
                        Simpan Variasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Varian Terdaftar -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center gap-4">
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                <h3 class="font-bold text-gray-800">Daftar Harga untuk {{ $produk->nama_menu }}</h3>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Varian</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($variants as $v)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $v->nama_variasi }}</td>
                        <td class="px-6 py-4 text-[#7a3939] font-bold">Rp {{ number_format($v->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $v->stok }} pcs</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <button @click="editData = @js($v); openEdit = true" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('produk.varian.destroy', [$produk->id, $v->id]) }}" method="POST" onsubmit="return confirm('Hapus varian ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada varian harga.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL EDIT VARIAN --}}
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl" @click.away="openEdit = false">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-[#7a3939]">Edit Varian Harga</h3>
                <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form :action="'{{ url('produk/'.$produk->id.'/varian') }}/' + editData.id" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Variasi</label>
                        <input type="text" name="nama_variasi" x-model="editData.nama_variasi" required
                               class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" x-model="editData.harga" required
                               class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stok" x-model="editData.stok" required
                               class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966]">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" @click="openEdit = false" class="px-4 py-2 text-gray-500">Batal</button>
                    <button type="submit" class="bg-[#7a3939] text-white px-6 py-2 rounded-xl hover:opacity-90 transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
