@extends('layouts.peminjam')

@section('content')
    <div class="space-y-6">

        <!-- WELCOME -->
        <div class="bg-white rounded-2xl border shadow-sm p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Selamat datang, <span class="text-primary-600">{{ auth()->user()->name }}</span> 👋
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Mau pinjam alat apa hari ini?
                </p>
            </div>

            <div class="hidden sm:flex w-12 h-12 rounded-xl bg-primary-50 text-primary-600 items-center justify-center">
                <i class="ri-hand-heart-line text-xl"></i>
            </div>
        </div>

        <!-- CTA PINJAM -->
        <div
            class="rounded-2xl p-6
               bg-gradient-to-r from-primary-50 to-white
               border shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    Ajukan Peminjaman Alat
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Lihat daftar alat dan ajukan peminjaman dengan mudah.
                </p>
            </div>

            <a href="{{ route('peminjam.alat.index') }}"
                class="inline-flex items-center justify-center gap-2
                  px-5 py-2.5 rounded-xl
                  bg-primary-600 text-white font-medium
                  hover:bg-primary-700 transition">
                <i class="ri-add-circle-line"></i>
                Pinjam Alat
            </a>
        </div>

        <!-- STATUS PEMINJAMAN -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <!-- Menunggu -->
            <div class="bg-white rounded-2xl border p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                    <i class="ri-time-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Menunggu</p>
                    <p class="text-xl font-semibold text-gray-900">
                        {{ $menunggu ?? 0 }}
                    </p>
                </div>
            </div>

            <!-- Aktif -->
            <div class="bg-white rounded-2xl border p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="ri-box-3-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="text-xl font-semibold text-gray-900">
                        {{ $aktif ?? 0 }}
                    </p>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white rounded-2xl border p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="ri-checkbox-circle-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Selesai</p>
                    <p class="text-xl font-semibold text-gray-900">
                        {{ $selesai ?? 0 }}
                    </p>
                </div>
            </div>

        </div>

        <!-- RIWAYAT -->
        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Riwayat Peminjaman
                </h3>
                <a href="{{ route('peminjam.riwayat.index') }}" class="text-sm text-primary-600 hover:underline">
                    Lihat Semua
                </a>
            </div>

            <p class="text-sm text-gray-500">
                Lihat status dan detail peminjaman yang pernah kamu ajukan.
            </p>
        </div>

    </div>
@endsection
