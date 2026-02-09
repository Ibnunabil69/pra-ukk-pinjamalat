@extends('layouts.petugas')

@section('title', 'Pengembalian Alat')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Pengembalian Alat</h1>
                <p class="text-gray-500 mt-1">Kelola pengajuan pengembalian alat oleh peminjam</p>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Alat</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-center">Target Kembali</th>
                        <th class="px-6 py-3 text-center">Telat</th>
                        <th class="px-6 py-3 text-center">Denda</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
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
                                {{ \Carbon\Carbon::parse($item->tanggal_kembali_target)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">{{ $item->telat_hari }} hari</td>
                            <td class="px-6 py-3 text-center text-red-600 font-semibold">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <button onclick="showModal({{ $item->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada pengajuan pengembalian saat ini
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

        <!-- MODAL -->
        <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

                @foreach ($peminjamans as $item)
                    <div id="modal-content-{{ $item->id }}" class="hidden">
                        <h2 class="text-lg font-bold mb-2">{{ $item->alat->nama }}</h2>
                        <p><strong>Peminjam:</strong> {{ $item->user->name }}</p>
                        <p><strong>Qty:</strong> {{ $item->jumlah }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($item->status) }}</p>
                        <p><strong>Target Kembali:</strong>
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali_target)->format('d-m-Y') }}</p>
                        <p><strong>Telat:</strong> {{ $item->telat_hari }} hari</p>
                        <p><strong>Denda:</strong> Rp {{ number_format($item->denda, 0, ',', '.') }}</p>

                        @if (strtolower($item->status) === 'menunggu_pengembalian')
                            <form method="POST" action="{{ route('petugas.pengembalian.proses', $item) }}" class="mt-3">
                                @csrf
                                <button type="submit"
                                    class="w-full px-3 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                    Proses Pengembalian
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        function showModal(id) {
            document.getElementById('modal').style.display = 'flex';
            document.querySelectorAll('[id^="modal-content-"]').forEach(el => el.style.display = 'none');
            document.getElementById('modal-content-' + id).style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
@endsection
