<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pembelians';

    protected $fillable = [
        'user_id',
        'nama_barang',
        'kategori',
        'jumlah',
        'harga',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
