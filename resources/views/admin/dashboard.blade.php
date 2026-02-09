@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-text-primary">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total User -->
        <div class="bg-surface p-6 rounded-2xl shadow-soft">
            <h2 class="font-semibold text-text-secondary mb-2">Total User</h2>
            <p class="text-3xl font-bold text-text-primary">10</p>
        </div>

        <!-- Total Alat -->
        <div class="bg-surface p-6 rounded-2xl shadow-soft">
            <h2 class="font-semibold text-text-secondary mb-2">Total Alat</h2>
            <p class="text-3xl font-bold text-text-primary">25</p>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="bg-surface p-6 rounded-2xl shadow-soft">
            <h2 class="font-semibold text-text-secondary mb-2">Peminjaman Aktif</h2>
            <p class="text-3xl font-bold text-text-primary">7</p>
        </div>
    </div>
@endsection
