@extends('layouts.app') {{-- Pastikan layout mengarah ke file sidebar Anda --}}

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto" x-data="{ openAdd: false, openEdit: false, editData: {id: '', nama: ''} }">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kategori Menu</h2>
            <p class="text-sm text-gray-500">Kelompokkan menu Anda (Coffee, Non-Coffee, dll)</p>
        </div>
        <button @click="openAdd = true" class="bg-[#cc9966] hover:bg-[#b38659] text-white px-4 py-2 rounded-xl shadow-lg transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Alert Notification -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">No</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">Nama Kategori</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600">Jumlah Menu</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $index => $cat)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $cat->nama_kategori }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-[#7a3939]/10 text-[#7a3939] text-xs font-bold px-3 py-1 rounded-full">
                            {{ $cat->menus_count }} Item
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <!-- Edit Button -->
                            <button @click="openEdit = true; editData = {id: '{{ $cat->id }}', nama: '{{ $cat->nama_kategori }}'}"
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('kategori.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
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
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah (Alpine.js) -->
    <div x-show="openAdd" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl" @click.away="openAdd = false">
            <h3 class="text-xl font-bold text-[#7a3939] mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required placeholder="Contoh: Coffee"
                        class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] transition">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openAdd = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Batal</button>
                    <button type="submit" class="bg-[#cc9966] text-white px-6 py-2 rounded-xl hover:bg-[#b38659]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit (Alpine.js) -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl" @click.away="openEdit = false">
            <h3 class="text-xl font-bold text-[#7a3939] mb-4">Edit Kategori</h3>
            <form :action="'{{ url('kategori') }}/' + editData.id" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required x-model="editData.nama"
                        class="w-full border-gray-300 rounded-xl focus:ring-[#cc9966] focus:border-[#cc9966] transition">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openEdit = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Batal</button>
                    <button type="submit" class="bg-[#7a3939] text-white px-6 py-2 rounded-xl hover:opacity-90">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
