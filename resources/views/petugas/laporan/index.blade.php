@extends('layouts.petugas')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Laporan Peminjaman</h1>
                <p class="text-gray-500 mt-1">Riwayat semua peminjaman alat</p>
            </div>
        </div>


        <form method="GET" action="{{ route('petugas.laporan-peminjaman') }}"
            class="bg-white border rounded-xl p-5 mb-6 flex flex-wrap items-end gap-4">

            <!-- Search -->
            <div class="flex-1 min-w-[220px]">
                <label class="block text-sm font-medium mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama peminjam / alat..."
                    class="w-full h-10 px-3 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status -->
            <div class="flex-1 min-w-[180px]">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full h-10 border rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    @foreach (['menunggu', 'dipinjam', 'menunggu_pengembalian', 'dikembalikan', 'ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dari -->
            <div class="flex-1 min-w-[160px]">
                <label class="block text-sm font-medium mb-1">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    max="{{ request('to') ?? \Carbon\Carbon::today()->format('Y-m-d') }}"
                    class="w-full h-10 px-3 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex-1 min-w-[160px]">
                <label class="block text-sm font-medium mb-1">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}" min="{{ request('from') }}"
                    max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                    class="w-full h-10 px-3 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex flex-wrap gap-2 ml-auto">

                <!-- Filter -->
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    Filter
                </button>

                <!-- Reset -->
                <a href="{{ route('petugas.laporan-peminjaman') }}"
                    class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-100">
                    Reset
                </a>

                <!-- Cetak PDF -->
                <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                    Cetak PDF
                </a>

            </div>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Nama Alat</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-center">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-center">Denda</th> <!-- Tambahan kolom -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($peminjamans as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $item->user->name }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $item->alat->nama }}</td>
                            <td class="px-6 py-3 text-center">{{ $item->jumlah }}</td>
                            <td class="px-6 py-3 text-center">
                                @php
                                    $color = match (strtolower($item->status)) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'menunggu_pengembalian' => 'bg-orange-100 text-orange-700',
                                        'dikembalikan', 'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                {{ $item->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                {{ $item->tanggal_kembali?->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-center text-red-600 font-semibold">
                                Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada riwayat peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $peminjamans->links() }}
        </div>

    </div>
@endsection
