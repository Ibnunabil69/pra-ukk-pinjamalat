@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman</h1>
            <p class="text-gray-500 mt-1">
                Daftar pengajuan dan status peminjaman alat Anda
            </p>
        </div>

        <!-- ALERT -->
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama Alat</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-3 text-center">Target Kembali</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $item)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-4 py-3 font-medium">
                                {{ $item->alat->nama }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jumlah }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->tanggal_kembali_target ? \Carbon\Carbon::parse($item->tanggal_kembali_target)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @php
                                    $badge = match ($item->status) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'dikembalikan' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <span class="px-2 py-1 rounded-full text-xs {{ $badge }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->status === 'dipinjam')
                                    <form method="POST"
                                        action="{{ route('peminjam.peminjaman.ajukan_pengembalian', $item->id) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-yellow-600 text-white rounded text-xs">
                                            Ajukan Pengembalian
                                        </button>
                                    </form>
                                @elseif ($item->status === 'menunggu')
                                    <form method="POST" action="{{ route('peminjam.peminjaman.batalkan', $item->id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 bg-red-600 text-white rounded text-xs">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada riwayat peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
