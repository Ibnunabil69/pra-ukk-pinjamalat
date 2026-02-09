@extends('layouts.petugas')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Petugas</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold">Peminjaman Hari Ini</h2>
            <p class="text-2xl">5</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold">Pengembalian</h2>
            <p class="text-2xl">3</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold">Alat Tersedia</h2>
            <p class="text-2xl">20</p>
        </div>
    </div>
@endsection
