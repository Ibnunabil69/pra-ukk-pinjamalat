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

        <!-- FILTER FORM -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Cari Nama Alat -->
            <div class="flex-1 min-w-[220px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Alat</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama alat..."
                    class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status -->
            <div class="flex-1 min-w-[180px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="menunggu_pengembalian"
                        {{ request('status') == 'menunggu_pengembalian' ? 'selected' : '' }}>
                        Menunggu Pengembalian
                    </option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan
                    </option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Tanggal Pinjam -->
            <div class="flex-1 min-w-[160px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ request('tanggal_pinjam') }}"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm">
            </div>

            <!-- Tampilkan -->
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
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">
                    Reset
                </a>
            </div>

        </form>


        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam
                        </th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Alat</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam
                        </th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali
                        </th>
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
                                @if ($p->status == 'menunggu')
                                    <span class="px-2 py-1 rounded-lg bg-yellow-100 text-yellow-700">Menunggu</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="px-2 py-1 rounded-lg bg-blue-100 text-blue-700">Dipinjam</span>
                                @elseif($p->status == 'menunggu_pengembalian')
                                    <span class="px-2 py-1 rounded-lg bg-orange-100 text-orange-700">Menunggu
                                        Pengembalian</span>
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
    @if ($peminjamans->lastPage() > 1)
        <div class="flex flex-col sm:flex-row justify-between items-center mt-4 text-sm text-gray-700 gap-2 sm:gap-0">

            <!-- Info item -->
            <div class="whitespace-nowrap">
                Menampilkan {{ $peminjamans->firstItem() ?? 0 }} - {{ $peminjamans->lastItem() ?? 0 }}
                dari {{ $peminjamans->total() ?? 0 }} data peminjaman
            </div>

            <!-- Links -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-1">

                {{-- First & Previous --}}
                @if ($peminjamans->onFirstPage())
                    <span class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
                    <span class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</span>
                @else
                    <a href="{{ $peminjamans->appends(request()->query())->url(1) }}"
                        class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&laquo;</a>
                    <a href="{{ $peminjamans->appends(request()->query())->previousPageUrl() }}"
                        class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&lsaquo;</a>
                @endif

                {{-- Page Numbers --}}
                @php
                    $pageStart = max($peminjamans->currentPage() - 2, 1);
                    $pageEnd = min($peminjamans->currentPage() + 2, $peminjamans->lastPage());
                    $mobileStart = max($peminjamans->currentPage() - 1, 1);
                    $mobileEnd = min($peminjamans->currentPage() + 1, $peminjamans->lastPage());
                @endphp

                {{-- Desktop --}}
                @for ($i = $pageStart; $i <= $pageEnd; $i++)
                    <a href="{{ $peminjamans->appends(request()->query())->url($i) }}"
                        class="hidden sm:inline-block px-3 py-1 rounded-lg
                   {{ $i == $peminjamans->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Mobile --}}
                @for ($i = $mobileStart; $i <= $mobileEnd; $i++)
                    <a href="{{ $peminjamans->appends(request()->query())->url($i) }}"
                        class="sm:hidden px-2 py-1 rounded-lg
                   {{ $i == $peminjamans->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Next & Last --}}
                @if ($peminjamans->hasMorePages())
                    <a href="{{ $peminjamans->appends(request()->query())->nextPageUrl() }}"
                        class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&rsaquo;</a>
                    <a href="{{ $peminjamans->appends(request()->query())->url($peminjamans->lastPage()) }}"
                        class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&raquo;</a>
                @else
                    <span class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&rsaquo;</span>
                    <span class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&raquo;</span>
                @endif

            </div>
        </div>
    @endif

@endsection
