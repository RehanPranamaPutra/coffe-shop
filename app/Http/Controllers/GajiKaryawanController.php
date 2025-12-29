<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GajiKaryawanController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('roleOwner')) {
            // 1. Siapkan Query Dasar
            $query = GajiKaryawan::with('user');

            // 2. Cek apakah ada filter bulan yang dikirim dari View
            if ($request->has('filter_bulan') && $request->filter_bulan != '') {
                $query->where('bulan', $request->filter_bulan);
            }

            // 3. Hitung Total Pengeluaran (Berdasarkan hasil filter)
            // clone() digunakan agar query perhitungan tidak mengganggu query paginasi
            $totalPengeluaran = $query->clone()->sum('jumlah_gaji');

            // 4. Ambil data dengan pagination
            $gajis = $query->latest('tanggal_bayar')->paginate(10);

            // Append query string agar saat pindah halaman (page 2), filter tetap aktif
            $gajis->appends($request->all());

            $users = User::all();

            return view('dashboard.gajiKaryawan.index', compact('gajis', 'users', 'totalPengeluaran'));
        }
        abort(403);
    }

    public function store(Request $request)
    {
        if (Gate::allows('roleOwner')) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'bulan' => 'required',
                'jumlah_gaji' => 'required',
                'tanggal_bayar' => 'required|date'
            ]);

            $rawGaji = preg_replace('/[^0-9]/', '', $request->jumlah_gaji);

            GajiKaryawan::create([
                'user_id' => $request->user_id,
                'bulan' => $request->bulan,
                'jumlah_gaji' => $rawGaji,
                'tanggal_bayar' => $request->tanggal_bayar,
                'keterangan' => $request->keterangan
            ]);

            return back()->with('success', 'Data gaji berhasil di simpan');
        }
        abort(403);
    }

    public function destroy($id)
    {
        if (Gate::allows('roleOwner')) {
            GajiKaryawan::findOrFail($id)->delete();
            return back()->with('success', 'Data gaji dihapus');
        }abort(403);
    }
}
