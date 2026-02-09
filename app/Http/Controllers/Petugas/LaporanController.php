<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'alat.kategori')
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        return view('petugas.laporan.index', compact('peminjamans'));
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to = $request->to;

        $peminjamans = Peminjaman::with('user', 'alat.kategori')
            ->whereDate('tanggal_pinjam', '>=', $from)
            ->whereDate('tanggal_pinjam', '<=', $to)
            ->orderBy('tanggal_pinjam', 'asc')
            ->get();

        return view('petugas.laporan.cetak', compact('peminjamans', 'from', 'to'));
    }
}
