@extends('layouts.petugas')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- WELCOME -->
        <div class="bg-white rounded-2xl border shadow-sm p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">
                    Selamat datang, <span class="text-primary-600">{{ auth()->user()->name }}</span> 👋
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Semoga harimu produktif. Berikut ringkasan aktivitas hari ini.
                </p>
            </div>

            <div class="hidden sm:flex w-12 h-12 rounded-xl bg-primary-50 text-primary-600 items-center justify-center">
                <i class="ri-hand-heart-line text-xl"></i>
            </div>
        </div>

        <!-- KPI -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- MENUNGGU PERSETUJUAN -->
            <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $menunggu ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                        <i class="ri-time-line text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('petugas.peminjaman.index', ['status' => 'menunggu']) }}"
                    class="text-xs text-yellow-600 font-medium hover:underline">Lihat Detail →</a>
            </div>

            <!-- PENGEMBALIAN HARI INI -->
            <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Pengembalian Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pengembalianHariIni ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="ri-arrow-go-back-line text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="text-xs text-green-600 font-medium hover:underline">Lihat Detail →</a>
            </div>

            <!-- TOTAL ALAT -->
            <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Alat</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAlat ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <i class="ri-tools-line text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('petugas.alat.index') }}"
                    class="text-xs text-indigo-600 font-medium hover:underline">Lihat Detail →</a>
            </div>

        </div>


        <!-- CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- AKTIVITAS -->
            <div class="lg:col-span-2 bg-white rounded-2xl border shadow-sm">
                <div class="px-6 py-4 border-b">
                    <h2 class="font-semibold text-gray-900">
                        Aktivitas Terbaru
                    </h2>
                </div>

                <div class="divide-y">
                    @forelse ($aktivitas ?? [] as $item)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $item->user->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $item->alat->nama }}
                                </p>
                            </div>
                            <span class="text-xs text-gray-400">
                                {{ $item->created_at->locale('id')->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada aktivitas terbaru
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- QUICK INFO -->
            <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-gray-900">
                    Ringkasan Cepat
                </h2>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Peminjaman</span>
                    <span class="font-medium text-gray-900">
                        {{ $totalPeminjaman ?? 0 }}
                    </span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Sudah Dikembalikan</span>
                    <span class="font-medium text-green-600">
                        {{ $dikembalikan ?? 0 }}
                    </span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ditolak</span>
                    <span class="font-medium text-red-600">
                        {{ $ditolak ?? 0 }}
                    </span>
                </div>
            </div>

        </div>

    </div>
@endsection
