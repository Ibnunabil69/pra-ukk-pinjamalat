<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use App\Models\Peminjaman;


class PeminjamanController extends Controller
{
    // Laporan peminjaman untuk admin
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Dashboard Admin
    public function dashboard()
    {
        // KPI
        $totalUser = User::count();
        $totalAlat = Alat::count();
        $totalKategori = Kategori::count();

        // Ringkasan Cepat
        $dikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();
        $sedangDipinjam = Peminjaman::whereIn('status', ['dipinjam', 'disetujui'])->count();

        // Aktivitas terbaru
        $aktivitas = LogAktivitas::with('user')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalAlat',
            'totalKategori',
            'dikembalikan',
            'ditolak',
            'sedangDipinjam',
            'aktivitas'
        ));
    }

    public function logAktivitas()
    {
        $aktivitas = LogAktivitas::with('user')->latest()->paginate(10); // bisa pagination
        return view('admin.log_aktivitas.index', compact('aktivitas'));
    }
}
