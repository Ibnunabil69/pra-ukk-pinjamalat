<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Traits\LogsActivity; // ⬅️ panggil trait

class LaporanController extends Controller
{
    use LogsActivity; // ⬅️ aktifkan trait

    // Tampilkan laporan dengan pagination
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'alat.kategori')
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        // ⬅️ LOG AKTIVITAS
        $this->logActivity("Melihat daftar laporan peminjaman");

        return view('petugas.laporan.index', compact('peminjamans'));
    }

    // Cetak laporan berdasarkan periode
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

        // ⬅️ LOG AKTIVITAS
        $this->logActivity("Mencetak laporan peminjaman dari {$from} sampai {$to}");

        return view('petugas.laporan.cetak', compact('peminjamans', 'from', 'to'));
    }
}
