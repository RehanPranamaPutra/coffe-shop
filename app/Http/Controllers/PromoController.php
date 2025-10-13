<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data promo, sekalian load relasi 'menu'
        // Jika Anda menggunakan pagination, ganti all() dengan paginate(10)
        $promos = Promo::with('menu')->get();

        // 2. Kirim data ke view yang Anda buat
        return view('dashboard.promo.index', compact('promos'));
            
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Ambil daftar menu yang tersedia untuk dropdown/pilihan
        $menus = Menu::all(['id', 'nama_menu']);

        return view('dashboard.promo.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input sesuai dengan kolom di DB Anda
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date|after_or_equal:today', // Harus mulai hari ini atau di masa depan
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Buat data promo baru
        Promo::create($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        // Eager load relasi 'menu'
        $promo->load('menu');
        return view('dashboard.promo.show',compact('promo'));
        // return view('promo.show', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        
        // // Ambil daftar menu yang tersedia untuk dropdown/pilihan
        $menus = Menu::all(['id', 'nama_menu']);
        $promo->load('menu'); // Load relasi menu untuk tampilan

        return view('dashboard.promo.edit', compact('promo', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        //  // Validasi data, pastikan aturannya sama dengan store
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            // Saat update, kita mungkin ingin mengizinkan tanggal mulai di masa lalu
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // // Perbarui data promo
        $promo->update($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
         $promo->delete();

        return redirect()->route('promo.index')->with('success', 'Promo berhasil dihapus!');
    }
}
