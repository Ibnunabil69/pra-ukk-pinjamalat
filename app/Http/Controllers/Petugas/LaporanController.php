<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Traits\LogsActivity;

class LaporanController extends Controller
{
    use LogsActivity;

    // 📊 HALAMAN LAPORAN + FILTER
    public function index(Request $request)
    {
        $query = Peminjaman::with('user', 'alat.kategori');

        // 🔍 SEARCH (nama peminjam / alat)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('alat', function ($q2) use ($request) {
                        $q2->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📌 STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 📅 TANGGAL
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->paginate(10);

        // biar pagination tetap bawa filter
        $peminjamans->appends($request->all());

        $this->logActivity("Melihat laporan peminjaman dengan filter");

        return view('petugas.laporan.index', compact('peminjamans'));
    }

    // 🧾 CETAK PDF (ikut semua filter)
    public function cetak(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $query = Peminjaman::with('user', 'alat.kategori');

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('alat', function ($q2) use ($request) {
                        $q2->where('nama_alat', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📌 STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 📅 TANGGAL (WAJIB untuk cetak)
        $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);

        $peminjamans = $query->orderBy('tanggal_pinjam', 'asc')->get();

        $this->logActivity(
            "Cetak laporan | Dari: {$request->from} - {$request->to} | Search: {$request->search} | Status: {$request->status}"
        );

        return view('petugas.laporan.cetak', [
            'peminjamans' => $peminjamans,
            'from' => $request->from,
            'to' => $request->to
        ]);
    }
}
