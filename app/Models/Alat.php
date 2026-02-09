<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori_id',
        'stok',
        'status',
    ];

    /**
     * Relasi ke kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Otomatis set status berdasarkan stok
     * - stok > 0  => tersedia
     * - stok == 0 => kosong
     */
    protected static function booted()
    {
        static::saving(function ($alat) {
            $alat->status = $alat->stok > 0 ? 'tersedia' : 'kosong';
        });
    }
}
