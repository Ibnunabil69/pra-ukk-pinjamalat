<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // Daftar alat untuk petugas
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

        // Search
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $alats = $query->paginate($request->perPage ?? 10)
            ->withQueryString();

        // ⬅️ INI YANG KURANG
        $kategoris = Kategori::orderBy('nama')->get();

        return view('petugas.alat.index', compact('alats', 'kategoris'));
    }

    // Method tambahan nanti bisa ditambahkan di sini
    // misal: validasi pengembalian, update stok, dsb
}
