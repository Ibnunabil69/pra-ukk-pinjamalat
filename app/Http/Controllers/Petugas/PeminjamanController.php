<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\LogsActivity;

class PeminjamanController extends Controller
{
    use LogsActivity;

    // =========================
    // DAFTAR PEMINJAMAN MENUNGGU
    // =========================
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $peminjamans = Peminjaman::with(['user', 'alat.kategori'])
            ->whereIn('status', [
                'menunggu',
                'dipinjam',
                'menunggu_pengembalian'
            ])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->whereHas('user', function ($u) use ($request) {
                        $u->where('name', 'like', '%' . $request->search . '%');
                    })
                        ->orWhereHas('alat', function ($a) use ($request) {
                            $a->where('nama', 'like', '%' . $request->search . '%')
                              ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->tanggal, function ($q) use ($request) {
                $q->whereDate('created_at', $request->tanggal);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

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

        $peminjaman = Peminjaman::with(['alat', 'user'])->findOrFail($id);

        // Validasi stok
        if ($peminjaman->jumlah > $peminjaman->alat->stok) {
            return back()->with('error', 'Stok alat tidak mencukupi');
        }

        // Kurangi stok
        $peminjaman->alat->decrement('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali_target' => $request->tanggal_kembali_target,
        ]);

        // Perbarui status fisik alat
        $peminjaman->alat->update(['status' => 'dipinjam']);

        // LOG AKTIVITAS
        if ($peminjaman->alat && $peminjaman->user) {
            $this->logActivity(
                "Menyetujui peminjaman alat '{$peminjaman->alat->nama}' oleh {$peminjaman->user->name} (ID Peminjaman #{$peminjaman->id})"
            );
        }

        return back()->with('success', 'Peminjaman disetujui');
    }

    // =========================
    // TOLAK PEMINJAMAN
    // =========================
    public function reject($id)
    {
        $peminjaman = Peminjaman::with(['alat', 'user'])->findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        // LOG AKTIVITAS
        if ($peminjaman->alat && $peminjaman->user) {
            $this->logActivity(
                "Menolak peminjaman alat '{$peminjaman->alat->nama}' oleh {$peminjaman->user->name} (ID Peminjaman #{$peminjaman->id})"
            );
        }

        return back()->with('success', 'Pengajuan ditolak');
    }

    // =========================
    // PROSES PENGEMBALIAN
    // =========================
    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['alat', 'user'])->findOrFail($id);

        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        $tanggalKembali = Carbon::now();
        $targetKembali = Carbon::parse($peminjaman->tanggal_kembali_target);
        
        // Hitung selisih hari jika telat (tanggal pengembalian lebih besar dari target)
        $denda = 0;
        $tanggalKembaliHanyaTanggal = $tanggalKembali->copy()->startOfDay();
        $targetHanyaTanggal = $targetKembali->copy()->startOfDay();

        if ($tanggalKembaliHanyaTanggal->greaterThan($targetHanyaTanggal)) {
            $selisihHari = $tanggalKembaliHanyaTanggal->diffInDays($targetHanyaTanggal);
            $denda = $selisihHari * 2000; // Denda Rp 2.000 per hari
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => $tanggalKembali,
            'denda' => $denda,
        ]);

        // Kembalikan status fisik alat
        $peminjaman->alat->update(['status' => 'tersedia']);

        // LOG AKTIVITAS
        if ($peminjaman->alat && $peminjaman->user) {
            $this->logActivity(
                "Memproses pengembalian alat '{$peminjaman->alat->nama}' dari {$peminjaman->user->name} (ID Peminjaman #{$peminjaman->id})"
            );
        }

        return back()->with('success', 'Pengembalian berhasil diproses');
    }

    public function dashboard()
    {
        // KPI
        $totalAlat = \App\Models\Alat::count();
        $menunggu = \App\Models\Peminjaman::where('status', 'menunggu')->count();
        $pengembalianHariIni = \App\Models\Peminjaman::where('status', 'dikembalikan')
            ->whereDate('tanggal_kembali', \Carbon\Carbon::today())
            ->count();

        // Aktivitas terbaru
        $aktivitas = \App\Models\Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_pengembalian', 'dikembalikan'])
            ->latest()
            ->take(4)
            ->get();

        // Ringkasan cepat
        $totalPeminjaman = \App\Models\Peminjaman::count();
        $dikembalikan = \App\Models\Peminjaman::where('status', 'dikembalikan')->count();
        $ditolak = \App\Models\Peminjaman::where('status', 'ditolak')->count();

        return view('petugas.dashboard', compact(
            'totalAlat',
            'menunggu',
            'pengembalianHariIni',
            'aktivitas',
            'totalPeminjaman',
            'dikembalikan',
            'ditolak'
        ));
    }
}
