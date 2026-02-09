@extends('layouts.peminjam')

@section('title', 'Daftar Alat')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Alat</h1>
            <p class="text-gray-500 mt-1">
                Pilih alat yang tersedia untuk diajukan peminjamannya
            </p>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Alat</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">Kategori</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Stok</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alat as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->nama }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->kategori->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->stok > 0)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                           bg-green-100 text-green-700">
                                        {{ $item->stok }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                           bg-red-100 text-red-700">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->stok > 0)
                                    <a href="{{ url('/peminjam/alat/' . $item->id . '/ajukan') }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5
                   bg-primary-600 text-white text-xs font-medium
                   rounded-lg hover:bg-primary-700 transition">
                                        <i class="ri-add-circle-line"></i>
                                        Ajukan
                                    </a>
                                @else
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5
                   bg-gray-300 text-gray-500 text-xs font-medium
                   rounded-lg cursor-not-allowed"
                                        disabled>
                                        <i class="ri-add-circle-line"></i>
                                        Ajukan
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada alat yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
