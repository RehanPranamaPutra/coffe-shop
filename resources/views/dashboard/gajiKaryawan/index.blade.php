@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Notifikasi Sukses -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
        <p class="font-bold">Berhasil!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- 📝 KOLOM KIRI: Form Input Gaji -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center gap-3 mb-6 border-b pb-4">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Input Gaji</h2>
                </div>

                <form action="{{ route('gaji.store') }}" method="POST">
                    @csrf

                    <!-- Pilih Karyawan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Karyawan</label>
                        <select name="user_id" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>-- Pilih Karyawan --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Periode & Tanggal -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Gaji</label>
                            <input type="month" name="bulan" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tgl Bayar</label>
                            <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" required class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- Nominal Gaji -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Gaji (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="text" id="input-gaji" name="jumlah_gaji" required
                                   class="w-full pl-10 p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-lg font-bold text-gray-800"
                                   placeholder="0">
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="3" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Bonus lembur, Potongan kasbon..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow transition transform active:scale-95">
                        Simpan Data Gaji
                    </button>
                </form>
            </div>
        </div>

        <!-- 📋 KOLOM KANAN: Tabel Riwayat -->
<div class="w-full lg:w-2/3 flex flex-col gap-6">

    <!-- CARD BARU: Filter & Ringkasan Pengeluaran -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-5">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <!-- Form Filter -->
            <form method="GET" action="{{ route('gaji.index') }}" class="w-full md:w-auto flex items-center gap-2">
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="month" name="filter_bulan" value="{{ request('filter_bulan') }}"
                           class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full"
                           onchange="this.form.submit()"> <!-- Submit otomatis saat ganti bulan -->
                </div>

                @if(request('filter_bulan'))
                    <a href="{{ route('gaji.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Ringkasan Total -->
            <div class="text-right w-full md:w-auto">
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Pengeluaran {{ request('filter_bulan') ? \Carbon\Carbon::createFromFormat('Y-m', request('filter_bulan'))->translatedFormat('F Y') : 'Keseluruhan' }}</p>
                <p class="text-2xl font-bold text-indigo-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat (Sama seperti sebelumnya, tapi tanpa margin top karena sudah diurus parent flex gap) -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex-1">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Riwayat Pembayaran</h2>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">
                {{ $gajis->total() }} Data Ditemukan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-3">Karyawan</th>
                        <th class="px-6 py-3">Periode</th>
                        <th class="px-6 py-3">Tgl Bayar</th>
                        <th class="px-6 py-3 text-right">Jumlah</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($gajis as $gaji)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $gaji->user->name ?? 'User Terhapus' }}
                            @if($gaji->keterangan)
                                <p class="text-xs text-gray-400 mt-1 italic">{{ Str::limit($gaji->keterangan, 20) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $gaji->bulan)->translatedFormat('F Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($gaji->tanggal_bayar)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">
                            Rp {{ number_format($gaji->jumlah_gaji, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('gaji.destroy', $gaji->id) }}" method="POST" onsubmit="return confirm('Hapus data gaji ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 bg-gray-50/50">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p>Tidak ada data gaji untuk periode ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t">
            {{ $gajis->links() }}
        </div>
    </div>
</div>

<script>
    // Script Format Rupiah Otomatis pada Input
    const inputGaji = document.getElementById('input-gaji');

    inputGaji.addEventListener('input', function(e) {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value) {
            this.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            this.value = '';
        }
    });
</script>
@endsection
