<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    protected $fillable = [
        'user_id',
        'bulan',
        'jumlah_gaji',
        'tanggal_bayar',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
