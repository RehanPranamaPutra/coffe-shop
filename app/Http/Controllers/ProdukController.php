<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::latest()->get();
        return view('dashboard.produk.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer',
            'kategori' => 'nullable',
            'status' => 'required',
            'deskripsi' => 'nullable',
            'gambar' => 'required|image|mimes:jpg,webp,jpeg,png'
        ]);

        $validated['slug'] = Str::slug($validated['nama_menu']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Menu::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $produk)
    {
        return view('dashboard.produk.show',compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $produk)
    {
        return view('dashboard.produk.edit',compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $produk)
    {
         $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:255',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $validated['slug'] = Str::slug($validated['nama_menu']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
