@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-md">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center gap-2">
            🛒 Tambah Transaksi Pembelian
        </h1>

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 border border-red-300 p-3 rounded-lg">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pembelian.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}"
                       class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                           class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="0" min="1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan (Rp)</label>
                    <input type="number" step="0.01" name="harga" id="harga" value="{{ old('harga') }}"
                           class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="0" min="0" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total (Otomatis)</label>
                <input type="text" id="total" name="total"
                       class="w-full border border-gray-300 rounded-lg p-2.5 bg-gray-100 text-gray-600"
                       readonly>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('pembelian.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg font-medium transition">
                   Batal
                </a>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const jumlahInput = document.getElementById('jumlah');
    const hargaInput = document.getElementById('harga');
    const totalInput = document.getElementById('total');

    function hitungTotal() {
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const harga = parseFloat(hargaInput.value) || 0;
        const total = jumlah * harga;
        totalInput.value = total ? total.toLocaleString('id-ID') : '';
    }

    jumlahInput.addEventListener('input', hitungTotal);
    hargaInput.addEventListener('input', hitungTotal);
</script>
@endsection
