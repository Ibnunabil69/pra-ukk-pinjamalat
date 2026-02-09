<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Tabel yang dipakai, kalau nama tabel bukan "kategoris" otomatis
    // protected $table = 'kategoris';

    // Mass assignable attributes
    protected $fillable = ['nama'];

    // Relasi ke Alat
    public function alats()
    {
        return $this->hasMany(Alat::class);
    }
}
