<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode_alat',
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
     * Relasi ke peminjaman
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Otomatis set status berdasarkan stok
     */
    protected static function booted()
    {
        static::creating(function ($alat) {
            // Generate kode_alat otomatis jika kosong
            // PENTING: Untuk bulk create, kita butuh logika yang tidak tabrakan
            if (empty($alat->kode_alat)) {
                $count = static::count();
                $alat->kode_alat = 'ALT-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
                
                // Cek lagi jika sudah ada (antisipasi collision)
                while (static::where('kode_alat', $alat->kode_alat)->exists()) {
                    $count++;
                    $alat->kode_alat = 'ALT-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
                }
            }
        });

    }
}
