@extends('layouts.petugas')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Peminjaman</h1>
                <p class="text-gray-500 mt-1">Kelola pengajuan peminjaman dan lakukan persetujuan</p>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Nama Alat</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($peminjamans as $peminjaman)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $peminjaman->user->name }}</td>
                            <td class="px-6 py-3">{{ $peminjaman->alat->nama }}</td>
                            <td class="px-6 py-3">{{ $peminjaman->alat->kategori->nama ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-3 text-center">
                                @php
                                    $color = match (strtolower($peminjaman->status)) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        'dikembalikan' => 'bg-indigo-100 text-indigo-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-sm {{ $color }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <button onclick="showModal({{ $peminjaman->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada peminjaman saat ini
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

        <!-- SIMPLE MODAL -->
        <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

                @foreach ($peminjamans as $peminjaman)
                    <div id="modal-content-{{ $peminjaman->id }}" class="hidden">
                        <h2 class="text-lg font-bold mb-2">{{ $peminjaman->alat->nama }}</h2>
                        <p><strong>Peminjam:</strong> {{ $peminjaman->user->name }}</p>
                        <p><strong>Kategori:</strong> {{ $peminjaman->alat->kategori->nama ?? '-' }}</p>
                        <p><strong>Qty:</strong> {{ $peminjaman->jumlah }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($peminjaman->status) }}</p>
                        <p><strong>Tanggal pengajuan:</strong> {{ $peminjaman->created_at->format('d-m-Y') }}</p>
                        <p><strong>Tanggal target kembali:</strong>
                            {{ $peminjaman->tanggal_kembali_target?->format('d-m-Y') ?? '-' }}</p>

                        @if (strtolower($peminjaman->status) === 'menunggu')
                            <div class="mt-3 space-y-2">
                                <!-- Input tanggal -->
                                <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Kembali Target:</label>
                                <input type="date" name="tanggal_kembali_target"
                                    value="{{ old('tanggal_kembali_target', $peminjaman->tanggal_kembali_target?->format('Y-m-d')) }}"
                                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                <div class="flex gap-2">
                                    <!-- Form Reject -->
                                    <form action="{{ route('petugas.peminjaman.reject', $peminjaman) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-3 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                            Tolak
                                        </button>
                                    </form>

                                    <!-- Form Approve -->
                                    <form action="{{ route('petugas.peminjaman.approve', $peminjaman) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <input type="hidden" name="tanggal_kembali_target"
                                            value="{{ old('tanggal_kembali_target', $peminjaman->tanggal_kembali_target?->format('Y-m-d')) }}">
                                        <button type="submit"
                                            class="w-full px-3 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                            Setujui
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        function showModal(id) {
            document.getElementById('modal').style.display = 'flex';
            // Hide all content
            document.querySelectorAll('[id^="modal-content-"]').forEach(el => el.style.display = 'none');
            // Show current content
            document.getElementById('modal-content-' + id).style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
@endsection
