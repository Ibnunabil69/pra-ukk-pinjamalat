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

        <!-- FILTER -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Cari Nama Alat -->
            <div class="flex-1 min-w-[220px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Alat</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama alat..."
                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
            </div>

            <!-- Kategori -->
            <div class="flex-1 min-w-[180px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Stok -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <select name="stok" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm">
                    <option value="">Semua</option>
                    <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>
                        Habis
                    </option>
                </select>
            </div>

            <!-- Per Page -->
            <div class="flex-1 min-w-[120px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                <select name="perPage" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm">
                    @foreach ([5, 10, 25, 50] as $n)
                        <option value="{{ $n }}" {{ request('perPage', 10) == $n ? 'selected' : '' }}>
                            {{ $n }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action -->
            <div class="flex gap-2 ml-auto">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm hover:bg-primary-700">
                    Filter
                </button>
                <a href="{{ route('peminjam.alat.index') }}" class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>

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
