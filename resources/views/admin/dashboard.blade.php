@extends('layouts.admin')

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

            <!-- TOTAL USER -->
            <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Total User</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalUser ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="ri-user-line text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 font-medium hover:underline">
                    Lihat Detail →
                </a>
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
                <a href="{{ route('admin.alat.index') }}" class="text-xs text-indigo-600 font-medium hover:underline">
                    Lihat Detail →
                </a>
            </div>

            <!-- TOTAL KATEGORI -->
            <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalKategori ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <i class="ri-folder-line text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.kategori.index') }}" class="text-xs text-purple-600 font-medium hover:underline">
                    Lihat Detail →
                </a>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- AKTIVITAS TERBARU (4 TERAKHIR) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border shadow-sm">
                <div class="px-6 py-4 border-b">
                    <h2 class="font-semibold text-gray-900">Aktivitas Terbaru</h2>
                </div>

                <div class="divide-y">
                    @forelse ($aktivitas->take(4) as $item)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->deskripsi }}</p>
                            </div>
                            <span
                                class="text-xs text-gray-400">{{ $item->created_at->locale('id')->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada aktivitas terbaru
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RINGKASAN CEPAT -->
            <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-4">
                <h2 class="font-semibold text-gray-900">Ringkasan Cepat</h2>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Sudah Dikembalikan</span>
                    <span class="font-medium text-green-600">{{ $dikembalikan ?? 0 }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ditolak</span>
                    <span class="font-medium text-red-600">{{ $ditolak ?? 0 }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Sedang Dipinjam</span>
                    <span class="font-medium text-yellow-600">{{ $sedangDipinjam ?? 0 }}</span>
                </div>
            </div>

        </div>

    </div>
@endsection
