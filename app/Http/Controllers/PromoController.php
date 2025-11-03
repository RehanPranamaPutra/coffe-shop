<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        // pakai paginate agar tidak berat di view
        $promos = Promo::with('menu')->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.promo.index', compact('promos'));
    }

    public function create()
    {
        $menus = Menu::all(['id', 'nama_menu']);
        return view('dashboard.promo.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:aktif,nonaktif', // boleh kosong => default aktif
        ]);

        // Pastikan format datetime dari HTML (datetime-local) di-convert ke format DB jika perlu
        // Jika input datang seperti "2025-10-27T21:00" gunakan Carbon
        if ($request->has('tanggal_mulai')) {
            $validated['tanggal_mulai'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('tanggal_mulai'))->toDateTimeString();
        }
        if ($request->has('tanggal_selesai')) {
            $validated['tanggal_selesai'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('tanggal_selesai'))->toDateTimeString();
        }

        // default status jika tidak dikirim
        $validated['status'] = $validated['status'] ?? 'aktif';

        Promo::create($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function show(Promo $promo)
    {
        $promo->load('menu');
        return view('dashboard.promo.show', compact('promo'));
    }

    public function edit(Promo $promo)
    {
        $menus = Menu::all(['id', 'nama_menu']);
        $promo->load('menu');
        return view('dashboard.promo.edit', compact('promo', 'menus'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jenis_promo' => 'required|in:persen,nominal',
            'nilai_diskon' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Convert datetime-local if dikirim dalam format Y-m-d\TH:i
        if ($request->has('tanggal_mulai')) {
            $validated['tanggal_mulai'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('tanggal_mulai'))->toDateTimeString();
        }
        if ($request->has('tanggal_selesai')) {
            $validated['tanggal_selesai'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('tanggal_selesai'))->toDateTimeString();
        }

        $promo->update($validated);

        return redirect()->route('promo.index')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promo.index')->with('success', 'Promo berhasil dihapus!');
    }
}
