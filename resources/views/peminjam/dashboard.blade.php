@extends('layouts.peminjam')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Peminjam</h1>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold">Peminjaman Aktif</h2>
            <p class="text-2xl">1</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold">Total Riwayat</h2>
            <p class="text-2xl">4</p>
        </div>
    </div>
@endsection
