<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan kolom di tabel `promos`.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_id',
        'jenis_promo', // enum: 'persen', 'nominal'
        'nilai_diskon',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * The attributes that should be cast.
     * Mengubah kolom tanggal/waktu menjadi instance Carbon.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'nilai_diskon' => 'decimal:2',
    ];

    /**
     * Mendefinisikan relasi: Promo ini terkait dengan satu Menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        // Asumsi Model Menu berada di App\Models\Menu
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Accessor untuk mendapatkan status promo.
     * Berguna di controller atau view untuk menentukan apakah promo Aktif/Akan Datang/Kadaluarsa.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        $now = now();

        if ($this->tanggal_mulai->gt($now)) {
            return 'Akan Datang';
        }

        if ($this->tanggal_selesai->lt($now)) {
            return 'Kadaluarsa';
        }

        return 'Aktif';
    }
}
