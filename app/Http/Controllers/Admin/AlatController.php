<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Traits\LogsActivity; // <--- import trait

class AlatController extends Controller
{
    use LogsActivity; // <--- pakai trait

    // Tampil semua alat
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

        // Filter pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
            });
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

    // Simpan alat baru (Dukungan Bulk Create)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_alat' => 'nullable|string|max:50|unique:alats,kode_alat',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:1', // Jumlah unit yang ingin dibuat
            'status' => 'required|in:tersedia,dipinjam',
        ]);

        $jumlah = (int) $request->stok;
        $namaAsli = $request->nama;

        // Loop untuk membuat unit satu per satu
        for ($i = 1; $i <= $jumlah; $i++) {
            $data = $request->all();
            
            // Jika lebih dari 1 unit, tambahkan akhiran angka (misal: Palu 1, Palu 2)
            if ($jumlah > 1) {
                $data['nama'] = $namaAsli . ' ' . $i;
                // Kosongkan kode_alat agar digenerate unik oleh Modal Booted
                $data['kode_alat'] = null; 
            }

            // Set stok per record selalu 1
            $data['stok'] = 1;

            $alat = Alat::create($data);
        }

        // Catat log
        $this->logActivity("Menambahkan massal alat '{$namaAsli}' sebanyak {$jumlah} unit");

        return redirect()->route('admin.alat.index')->with('success', "{$jumlah} unit {$namaAsli} berhasil ditambahkan secara unik.");
    }

    // Form edit alat
    public function edit(Alat $alat)
    {
        // CEK STATUS: Jika sedang dipinjam, tidak boleh diedit
        if ($alat->status === 'dipinjam') {
            return redirect()->route('admin.alat.index')->with('error', 'Alat yang sedang dipinjam tidak dapat diubah datanya.');
        }

        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    // Update data alat
    public function update(Request $request, Alat $alat)
    {
        // CEK STATUS: Keamanan server side
        if ($alat->status === 'dipinjam') {
            return redirect()->route('admin.alat.index')->with('error', 'Alat yang sedang dipinjam tidak dapat diubah datanya.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_alat' => 'nullable|string|max:50|unique:alats,kode_alat,' . $alat->id,
            'kategori_id' => 'required|exists:kategoris,id',
            // Stok dan Status dihapus dari proteksi manual di sini
        ]);

        // Update hanya data identitas
        $alat->update($request->only(['nama', 'kode_alat', 'kategori_id']));

        // Catat log
        $this->logActivity("Mengubah alat '{$alat->nama}'");

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    // Hapus alat
    public function destroy(Alat $alat)
    {
        $nama = $alat->nama;
        $alat->delete();

        // Catat log
        $this->logActivity("Menghapus alat '{$nama}'");

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
