<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_target',
        'tanggal_kembali',
        'status',
    ];

    // Convert field tanggal menjadi Carbon otomatis
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali_target' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    /**
     * Relasi ke User (peminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Alat
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
