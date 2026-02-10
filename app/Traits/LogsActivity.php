<?php

namespace App\Traits;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Simpan log aktivitas
     *
     * @param string $deskripsi
     * @return void
     */
    public function logActivity(string $deskripsi)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'deskripsi' => $deskripsi,
            ]);
        }
    }
}
