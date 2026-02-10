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
        <!-- MODAL -->
        <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm z-50">

            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 relative">

                <!-- CLOSE -->
                <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl leading-none">
                    &times;
                </button>

                @foreach ($peminjamans as $peminjaman)
                    <div id="modal-content-{{ $peminjaman->id }}" class="hidden">

                        <!-- HEADER -->
                        <div class="mb-5">
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ $peminjaman->alat->nama }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                Detail pengajuan peminjaman
                            </p>
                        </div>

                        <!-- INFO -->
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Peminjam</span>
                                <span class="font-medium text-gray-900">
                                    {{ $peminjaman->user->name }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Kategori</span>
                                <span class="text-gray-700">
                                    {{ $peminjaman->alat->kategori->nama ?? '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Jumlah</span>
                                <span class="text-gray-700">
                                    {{ $peminjaman->jumlah }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Status</span>
                                <span class="font-semibold capitalize text-gray-800">
                                    {{ $peminjaman->status }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal Pengajuan</span>
                                <span class="text-gray-700">
                                    {{ $peminjaman->created_at->format('d M Y') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Target Kembali</span>
                                <span class="text-gray-700">
                                    {{ $peminjaman->tanggal_kembali_target?->format('d M Y') ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- ACTION -->
                        @if (strtolower($peminjaman->status) === 'menunggu')
                            <div class="mt-6 pt-4 border-t space-y-4">

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">
                                        Tanggal Kembali Target
                                    </label>
                                    <input type="date" id="tanggal-{{ $peminjaman->id }}"
                                        value="{{ $peminjaman->tanggal_kembali_target?->format('Y-m-d') }}"
                                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                        class="w-full rounded-lg border-gray-300 text-sm
           focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="flex gap-3">
                                    <!-- REJECT -->
                                    <form action="{{ route('petugas.peminjaman.reject', $peminjaman) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full rounded-lg border border-red-500 py-2
                                           text-red-600 font-medium hover:bg-red-50 transition">
                                            Tolak
                                        </button>
                                    </form>

                                    <!-- APPROVE -->
                                    <form action="{{ route('petugas.peminjaman.approve', $peminjaman) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <input type="hidden" name="tanggal_kembali_target"
                                            id="hidden-tanggal-{{ $peminjaman->id }}">
                                        <button type="submit"
                                            class="w-full rounded-lg bg-blue-600 py-2
                                           text-white font-medium hover:bg-blue-700 transition">
                                            Setujui
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endif

                        @if (in_array(strtolower($peminjaman->status), ['dipinjam', 'menunggu_pengembalian']))
                            <div class="mt-6 pt-4 border-t space-y-3">

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Target Kembali</span>
                                    <span class="text-gray-700">
                                        {{ $peminjaman->tanggal_kembali_target?->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Telat</span>
                                    <span class="font-medium text-red-600">
                                        {{ $peminjaman->telat_hari }} hari
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Denda</span>
                                    <span class="font-semibold text-red-600">
                                        Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                    </span>
                                </div>

                                <form method="POST" action="{{ route('petugas.pengembalian.proses', $peminjaman) }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full mt-3 rounded-lg bg-green-600 py-2
                       text-white font-medium hover:bg-green-700 transition">
                                        Proses Pengembalian
                                    </button>
                                </form>

                            </div>
                        @endif


                    </div>
                @endforeach

            </div>
        </div>

    </div>

    <script>
        function showModal(id) {
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.querySelectorAll('[id^="modal-content-"]').forEach(el => {
                el.classList.add('hidden');
            });

            const content = document.getElementById('modal-content-' + id);
            content.classList.remove('hidden');

            const dateInput = document.getElementById('tanggal-' + id);
            const hiddenInput = document.getElementById('hidden-tanggal-' + id);

            if (dateInput && hiddenInput) {
                hiddenInput.value = dateInput.value;
                dateInput.addEventListener('change', function() {
                    hiddenInput.value = this.value;
                });
            }
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection
