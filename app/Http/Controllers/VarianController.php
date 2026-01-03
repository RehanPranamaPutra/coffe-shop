<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuVariant;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Menu $produk)
    {
        $variants = $produk->variants;
        return view('dashboard.produk.varian', compact('produk', 'variants'));
    }

    public function store(Request $request, Menu $produk)
    {
        $request->validate([
            'nama_variasi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $produk->variants()->create($request->all());

        return redirect()->back()->with('success', 'Harga variasi berhasil ditambahkan!');
    }

    public function update(Request $request, Menu $produk, MenuVariant $varian)
{
    $request->validate([
        'nama_variasi' => 'required|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
    ]);

    $varian->update([
        'nama_variasi' => $request->nama_variasi,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->back()->with('success', 'Varian berhasil diperbarui!');
}

    public function destroy(Menu $produk, MenuVariant $varian)
    {
        $varian->delete();
        return redirect()->back()->with('success', 'Variasi berhasil dihapus.');
    }
}
