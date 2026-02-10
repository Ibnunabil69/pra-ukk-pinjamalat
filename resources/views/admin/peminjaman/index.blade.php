@extends('layouts.admin')

@section('title', 'Monitoring Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Monitoring Peminjaman</h1>
            <p class="text-gray-500 mt-1">Pantau status alat yang sedang dipinjam dan yang telah dikembalikan.</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Alat</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peminjamans as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $p->user->name }}</td>
                        <td class="px-6 py-3">{{ $p->alat->nama }}</td>
                        <td class="px-6 py-3">{{ $p->jumlah }}</td>
                        <td class="px-6 py-3">
                            @if($p->status == 'menunggu')
                                <span class="px-2 py-1 rounded-lg bg-yellow-100 text-yellow-700">Menunggu</span>
                            @elseif($p->status == 'dipinjam')
                                <span class="px-2 py-1 rounded-lg bg-blue-100 text-blue-700">Dipinjam</span>
                            @elseif($p->status == 'menunggu_pengembalian')
                                <span class="px-2 py-1 rounded-lg bg-orange-100 text-orange-700">Menunggu Pengembalian</span>
                            @elseif($p->status == 'dikembalikan')
                                <span class="px-2 py-1 rounded-lg bg-green-100 text-green-700">Dikembalikan</span>
                            @elseif($p->status == 'ditolak')
                                <span class="px-2 py-1 rounded-lg bg-red-100 text-red-700">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500">Belum ada data peminjaman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
