@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-4">✏️ Edit Transaksi Pembelian</h1>

    <form method="POST" action="{{ route('pembelian.update', $transaksiPembelian->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border rounded p-2"
                placeholder="Masukkan nama barang"
                value="{{ old('nama_barang', $transaksiPembelian->nama_barang) }}" required>
        </div> 

        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <input type="text" name="kategori" class="w-full border rounded p-2"
                placeholder="Masukkan kategori barang"
                value="{{ old('kategori', $transaksiPembelian->kategori) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="w-full border rounded p-2"
                placeholder="0" min="1" step="1"
                value="{{ old('jumlah', $transaksiPembelian->jumlah) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Harga Satuan</label>
            <input type="number" name="harga" id="harga" class="w-full border rounded p-2"
                placeholder="0.00" min="0" step="0.01"
                value="{{ old('harga', $transaksiPembelian->harga) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Total</label>
            <input type="hidden" id="total_raw" name="total" value="{{ $transaksiPembelian->total }}">
            <input type="text" id="total" class="w-full border rounded p-2 bg-gray-100"
                value="{{ number_format($transaksiPembelian->total, 2, ',', '.') }}" readonly>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('pembelian.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
        </div>
    </form>
</div>

<script>
    const jumlahInput = document.getElementById('jumlah');
    const hargaInput = document.getElementById('harga');
    const totalInput = document.getElementById('total');
    const totalRawInput = document.getElementById('total_raw');

    function hitungTotal() {
        let jumlah = parseFloat(jumlahInput.value) || 0;
        let harga = parseFloat(hargaInput.value) || 0;

        // Validasi minimal
        if(jumlah < 1) jumlah = 1;
        if(harga < 0) harga = 0;

        jumlahInput.value = jumlah;
        hargaInput.value = harga;

        const total = jumlah * harga;

        totalInput.value = total.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        totalRawInput.value = total; // nilai asli untuk server
    }

    jumlahInput.addEventListener('input', hitungTotal);
    hargaInput.addEventListener('input', hitungTotal);

    // Hitung awal saat load
    hitungTotal();
</script>
@endsection
