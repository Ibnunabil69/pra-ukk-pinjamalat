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
        'denda',
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

    /**
     * Accessor untuk menghitung jumlah hari keterlambatan
     */
    public function getTelatHariAttribute()
    {
        if (!$this->tanggal_kembali_target) return 0;
        
        $target = \Carbon\Carbon::parse($this->tanggal_kembali_target)->startOfDay();
        
        // Jika sudah dikembalikan, pakai tanggal_kembali untuk hitung telat
        // Jika belum, pakai hari ini
        $kembali = $this->tanggal_kembali 
            ? \Carbon\Carbon::parse($this->tanggal_kembali)->startOfDay() 
            : \Carbon\Carbon::now()->startOfDay();

        if ($kembali->greaterThan($target)) {
            return $kembali->diffInDays($target);
        }
        return 0;
    }

    /**
     * Accessor untuk denda (kalkulasi on-the-fly jika belum dikembalikan)
     */
    public function getDendaAttribute($value)
    {
        // Jika sudah dikembalikan, ambil data denda yang fix dari database
        if ($this->status === 'dikembalikan') {
            return $value;
        }
        
        // Jika belum, hitung sementara berdasarkan hari ini
        return $this->telat_hari * 2000;
    }
}
