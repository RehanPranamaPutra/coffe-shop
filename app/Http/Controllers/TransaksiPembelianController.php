<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiPembelianController extends Controller
{
    public function index()
    {
        $transaksiPembelian = TransaksiPembelian::all();
        return view('dashboard.transaksipembelian.index', compact('transaksiPembelian'));
    }

    public function create()
    {
        return view('dashboard.transaksipembelian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        TransaksiPembelian::create([
            'user_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'total' => $request->jumlah * $request->harga,
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $transaksiPembelian = TransaksiPembelian::findOrFail($id);
        return view('dashboard.transaksipembelian.edit', compact('transaksiPembelian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $transaksiPembelian = TransaksiPembelian::findOrFail($id);

        $transaksiPembelian->update([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'total' => $request->jumlah * $request->harga,
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksiPembelian = TransaksiPembelian::findOrFail($id);
        $transaksiPembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function show($id)
    {
        $transaksiPembelian = TransaksiPembelian::findOrFail($id);
        return view('dashboard.transaksipembelian.show', compact('transaksiPembelian'));
    }
}
