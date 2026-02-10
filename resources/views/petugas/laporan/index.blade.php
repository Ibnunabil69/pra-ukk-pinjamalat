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


        <form action="{{ route('petugas.laporan.cetak') }}" method="GET" target="_blank"
            class="bg-white border rounded-xl p-4 mb-6 flex flex-col sm:flex-row sm:items-end gap-4">

            <!-- Periode -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Dari tanggal
                </label>
                <input type="date" name="from" required
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Sampai tanggal
                </label>
                <input type="date" name="to" required
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Button -->
            <div>
                <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Cetak PDF
                </button>
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
                            <td class="px-6 py-3">{{ $item->alat->nama }}</td>
                            <td class="px-6 py-3 text-center">{{ $item->jumlah }}</td>
                            <td class="px-6 py-3 text-center">
                                @php
                                    $color = match (strtolower($item->status)) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        'dikembalikan' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-sm {{ $color }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ $item->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-center">
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
