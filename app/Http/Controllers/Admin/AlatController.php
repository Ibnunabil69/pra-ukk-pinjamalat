<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // Tampil semua alat
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

        // Filter pencarian
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Pagination
        $alats = $query->paginate($request->perPage ?? 10);

        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();

        return view('admin.alat.index', compact('alats', 'kategoris'));
    }

    // Form tambah alat
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    // Simpan alat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam',
        ]);

        Alat::create($request->all());

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    // Form edit alat
    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    // Update data alat
    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam',
        ]);

        $alat->update($request->all());

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    // Hapus alat
    public function destroy(Alat $alat)
    {
        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
