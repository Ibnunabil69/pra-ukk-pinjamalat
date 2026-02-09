<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // =========================
    // DAFTAR PEMINJAMAN MENUNGGU
    // Route: petugas.peminjaman.index
    // =========================
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10); // ← paginasi

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    // =========================
    // SETUJUI PEMINJAMAN
    // =========================
    public function approve(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali_target' => 'required|date|after:today',
        ]);

        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        if ($peminjaman->jumlah > $peminjaman->alat->stok) {
            return back()->with('error', 'Stok alat tidak mencukupi');
        }

        $peminjaman->alat->decrement('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali_target' => $request->tanggal_kembali_target,
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // =========================
    // TOLAK PEMINJAMAN
    // =========================
    public function reject($id)
    {
        Peminjaman::findOrFail($id)->update([
            'status' => 'ditolak',
        ]);

        return back()->with('success', 'Pengajuan ditolak');
    }

    // =========================
    // DAFTAR PENGEMBALIAN
    // Route: petugas.pengembalian.index
    // =========================
    public function pengembalianIndex()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'menunggu_pengembalian') // ← ambil yang menunggu pengembalian
            ->latest()
            ->paginate(10);

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }


    // =========================
    // PROSES PENGEMBALIAN
    // =========================
    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        // Tambah stok alat kembali
        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => Carbon::now(),
        ]);

        return back()->with('success', 'Pengembalian berhasil diproses');
    }

    // =========================
    // DETAIL PENGEMBALIAN
    // =========================
    public function showPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])->findOrFail($id);
        return view('petugas.pengembalian.show', compact('peminjaman'));
    }
}
