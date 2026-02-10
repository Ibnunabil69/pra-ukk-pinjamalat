<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\LogsActivity; // ⬅️ panggil trait

class PeminjamanController extends Controller
{
    use LogsActivity; // ⬅️ aktifkan trait

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
        $request->validate(
            [
                'alat_id' => 'required|exists:alats,id',
                'jumlah'  => 'required|integer|min:1',
                'tanggal_kembali_target' => 'required|date|after:today',
            ],
            [
                'tanggal_kembali_target.required' => 'Tanggal kembali target wajib diisi.',
                'tanggal_kembali_target.date' => 'Tanggal kembali target harus berupa tanggal.',
                'tanggal_kembali_target.after' => 'Tanggal kembali target harus setelah hari ini.',
            ]
        );

        $alat = Alat::findOrFail($request->alat_id);

        if ($request->jumlah > $alat->stok) {
            return back()->with('error', 'Stok alat tidak mencukupi');
        }

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $alat->id,
            'jumlah'  => $request->jumlah,
            'status'  => 'menunggu',
            'tanggal_kembali_target' => $request->tanggal_kembali_target,
        ]);

        // ⬅️ LOG AKTIVITAS
        $this->logActivity(
            "Mengajukan peminjaman alat '{$alat->nama}' sebanyak {$request->jumlah} unit (ID Peminjaman #{$peminjaman->id})"
        );

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

        // ⬅️ LOG AKTIVITAS
        $this->logActivity(
            "Mengajukan pengembalian alat '{$peminjaman->alat->nama}' sebanyak {$peminjaman->jumlah} unit (ID Peminjaman #{$peminjaman->id})"
        );

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

        // ⬅️ LOG AKTIVITAS
        $this->logActivity(
            "Membatalkan peminjaman alat '{$peminjaman->alat->nama}' sebanyak {$peminjaman->jumlah} unit (ID Peminjaman #{$id})"
        );

        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    // DASHBOARD PEMINJAM
    public function dashboard()
    {
        $userId = Auth::id();

        if (!$userId) {
            abort(403, 'User belum login');
        }

        $menunggu = Peminjaman::where('user_id', $userId)
            ->where('status', 'menunggu')
            ->count();

        $aktif = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $selesai = Peminjaman::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        return view('peminjam.dashboard', compact(
            'menunggu',
            'aktif',
            'selesai'
        ));
    }
}
