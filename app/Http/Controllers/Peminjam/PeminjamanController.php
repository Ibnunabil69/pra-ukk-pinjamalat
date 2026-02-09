<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // DAFTAR ALAT
    public function daftarAlat()
    {
        $alat = Alat::with('kategori')->get();
        return view('peminjam.alat.index', compact('alat'));
    }

    // FORM AJUKAN PEMINJAMAN
    public function ajukan($id)
    {
        $alat = Alat::with('kategori')->findOrFail($id);
        return view('peminjam.alat.ajukan', compact('alat'));
    }

    // SIMPAN PENGAJUAN PEMINJAMAN
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah'  => 'required|integer|min:1',
            'tanggal_kembali_target' => 'required|date|after:today',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Stok alat tidak mencukupi');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $alat->id,
            'jumlah'  => $request->jumlah,
            'status'  => 'menunggu',
            'tanggal_kembali_target' => $request->tanggal_kembali_target,
        ]);

        return redirect()->route('peminjam.riwayat.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim');
    }

    // RIWAYAT PEMINJAMAN
    public function riwayat()
    {
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('peminjam.riwayat.index', compact('peminjamans'));
    }

    // AJUKAN PENGEMBALIAN
    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $peminjaman->update([
            'status' => 'menunggu_pengembalian',
        ]);

        return back()->with('success', 'Pengajuan pengembalian berhasil dikirim');
    }

    // BATALKAN PEMINJAMAN
    public function batalkan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Peminjaman tidak bisa dibatalkan.');
        }

        $peminjaman->delete();

        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}
