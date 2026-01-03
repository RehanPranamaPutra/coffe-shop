<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Menu;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function index()
    {
        // Mengambil menu beserta kategori dan variannya
        $menus = Menu::with(['category', 'variants'])->latest()->get();
        $categories = Categories::all();
        return view('dashboard.produk.index', compact('menus', 'categories'));
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
        $request->validate([
            'nama_menu' => 'required|max:255',
            'categories_id' => 'required|exists:categories,id',
            'gambar' => 'required|image|mimes:jpg,jpeg,png.webp|max:2048',
        ]);

        try {
            $path = $request->file('gambar')->store('produk', 'public');

            Menu::create([
                'nama_menu' => $request->nama_menu,
                'slug' => Str::slug($request->nama_menu),
                'categories_id' => $request->categories_id,
                'deskripsi' => $request->deskripsi,
                'gambar' => $path,
                'status' => 'Tersedia'
            ]);

            return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika gagal simpan ke DB, kembalikan dengan pesan error sistem
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan ke database: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $produk)
    {
        return view('dashboard.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $produk)
    {
        return view('dashboard.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $produk)
    {
        $request->validate([
            'nama_menu' => 'required|max:255',
            'categories_id' => 'required|exists:categories,id',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            // Data Dasar
            $data = [
                'nama_menu' => $request->nama_menu,
                'slug' => Str::slug($request->nama_menu),
                'categories_id' => $request->categories_id,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
            ];

            // Jika User upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama dari storage
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar);
                }

                // Simpan gambar baru
                $data['gambar'] = $request->file('gambar')->store('produk', 'public');
            }

            // Update ke database
            $produk->update($data);

            return redirect()->route('produk.index')->with('success', 'Menu berhasil diperbarui!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui menu: ' . $e->getMessage())->withInput();
        }
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
