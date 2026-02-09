<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =========================
// CONTROLLER ADMIN
// =========================
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;

// =========================
// CONTROLLER PETUGAS
// =========================
use App\Http\Controllers\Petugas\AlatController as PetugasAlatController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;

// =========================
// CONTROLLER PEMINJAM
// =========================
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect('/login'));

/*
|--------------------------------------------------------------------------
| DASHBOARD UNIVERSAL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => view('admin.dashboard'),
        'petugas' => view('petugas.dashboard'),
        'peminjam' => view('peminjam.dashboard'),
        default => abort(403),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // MASTER DATA
    Route::resource('users', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('alat', AlatController::class);

    // LAPORAN PEMINJAMAN
    Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('petugas')->name('petugas.')->group(function () {

    // DAFTAR ALAT
    Route::get('alat', [PetugasAlatController::class, 'index'])->name('alat.index');

    // PEMINJAMAN
    Route::get('peminjaman', [PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman/{peminjaman}/approve', [PetugasPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{peminjaman}/reject', [PetugasPeminjamanController::class, 'reject'])->name('peminjaman.reject');

    // DAFTAR PENGEMBALIAN
    Route::get('pengembalian', [PetugasPeminjamanController::class, 'pengembalianIndex'])->name('pengembalian.index');

    // PROSES PENGEMBALIAN
    Route::post('pengembalian/{peminjaman}/proses', [PetugasPeminjamanController::class, 'prosesPengembalian'])->name('pengembalian.proses');

    // DETAIL PENGEMBALIAN
    Route::get('pengembalian/{peminjaman}', [PetugasPeminjamanController::class, 'showPengembalian'])->name('pengembalian.show');
    Route::post('pengembalian/{peminjaman}/proses-konfirmasi', [PetugasPeminjamanController::class, 'prosesPengembalian'])->name('pengembalian.proses-konfirmasi');

    Route::get('laporan-peminjaman', [PetugasLaporanController::class, 'index'])
        ->name('laporan-peminjaman');

    Route::get('laporan/cetak', [PetugasLaporanController::class, 'cetak'])
        ->name('laporan.cetak');
});

/*
|--------------------------------------------------------------------------
| PEMINJAM
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('peminjam')->name('peminjam.')->group(function () {

    // DAFTAR ALAT
    Route::get('alat', [PeminjamPeminjamanController::class, 'daftarAlat'])->name('alat.index');

    // AJUKAN PEMINJAMAN
    Route::get('alat/{id}/ajukan', [PeminjamPeminjamanController::class, 'ajukan'])->name('peminjaman.ajukan');
    Route::post('peminjaman', [PeminjamPeminjamanController::class, 'store'])->name('peminjaman.store');

    // RIWAYAT PEMINJAMAN
    Route::get('riwayat', [PeminjamPeminjamanController::class, 'riwayat'])->name('riwayat.index');

    // AJUKAN PENGEMBALIAN
    Route::post('peminjaman/{id}/ajukan-pengembalian', [PeminjamPeminjamanController::class, 'ajukanPengembalian'])->name('peminjaman.ajukan_pengembalian');

    // BATALKAN PEMINJAMAN
    Route::delete('peminjaman/{id}/batalkan', [PeminjamPeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
