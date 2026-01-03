<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::withCount('menus')->get(); // Menghitung berapa menu di tiap kategori
        return view('dashboard.kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori|max:255',
        ]);

        Categories::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Categories $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:categories,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Categories $kategori)
    {
        // Cek jika kategori masih punya menu, sebaiknya jangan dihapus dulu
        if ($kategori->menus()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk!');
        }

        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
