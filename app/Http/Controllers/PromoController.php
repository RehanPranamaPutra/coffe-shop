<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Promo;
use App\Models\MenuVariant; // Import Model Varian
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        // Eager load ke variant dan menu agar bisa menampilkan nama menu di tabel promo
        $promos = Promo::with('variant.menu')->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.promo.index', compact('promos'));
    }

    public function create()
    {
        // Ambil semua varian beserta data menu induknya untuk dropdown
        $variants = MenuVariant::with('menu')->get();
        return view('dashboard.promo.create', compact('variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Ubah dari menu_id ke menu_variant_id
            'menu_variant_id' => 'required|exists:menu_variants,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        // Konversi format datetime-local ke format Database
        $validated['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->toDateTimeString();
        $validated['tanggal_selesai'] = Carbon::parse($request->tanggal_selesai)->toDateTimeString();

        $validated['status'] = $validated['status'] ?? 'aktif';

        Promo::create($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit(Promo $promo)
    {
        // Load varian untuk dropdown pilihan
        $variants = MenuVariant::with('menu')->get();

        // Konversi tanggal agar bisa dibaca oleh input datetime-local HTML
        $promo->tanggal_mulai = Carbon::parse($promo->tanggal_mulai)->format('Y-m-d\TH:i');
        $promo->tanggal_selesai = Carbon::parse($promo->tanggal_selesai)->format('Y-m-d\TH:i');

        return view('dashboard.promo.edit', compact('promo', 'variants'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'menu_variant_id' => 'required|exists:menu_variants,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Konversi ulang format tanggal untuk database
        $validated['tanggal_mulai'] = Carbon::parse($request->tanggal_mulai)->toDateTimeString();
        $validated['tanggal_selesai'] = Carbon::parse($request->tanggal_selesai)->toDateTimeString();

        $promo->update($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil diperbarui!');
    }
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promo.index')->with('success', 'Promo berhasil dihapus!');
    }
}
