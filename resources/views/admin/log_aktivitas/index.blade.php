@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Log Aktivitas</h1>
                <p class="text-gray-500 mt-1">Pantau semua aktivitas pengguna di sistem.</p>
            </div>
        </div>

        <!-- FILTER FORM -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Dari Tanggal -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    class="w-full h-10 pl-3 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Sampai Tanggal -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}"
                    class="w-full h-10 pl-3 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Submit & Reset -->
            <div class="flex gap-2 ml-auto">
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm leading-5">
                    <i class="ri-filter-3-line"></i> Filter
                </button>
                <a href=""
                    class="inline-flex items-center gap-1.5 px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm leading-5">
                    <i class="ri-refresh-line"></i> Reset
                </a>
            </div>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($aktivitas as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">
                                {{ $loop->iteration + ($aktivitas->currentPage() - 1) * $aktivitas->perPage() }}</td>
                            <td class="px-6 py-3">{{ $log->user->name }}</td>
                            <td class="px-6 py-3">{{ $log->deskripsi }}</td>
                            <td class="px-6 py-3">{{ $log->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">Belum ada aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION CUSTOM -->
        @if ($aktivitas->lastPage() > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 text-sm text-gray-700 gap-2 sm:gap-0">

                <!-- Info item -->
                <div class="whitespace-nowrap">
                    Menampilkan {{ $aktivitas->firstItem() ?? 0 }} - {{ $aktivitas->lastItem() ?? 0 }} dari
                    {{ $aktivitas->total() ?? 0 }} log
                </div>

                <!-- Links -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-1">

                    {{-- First & Previous --}}
                    @if ($aktivitas->onFirstPage())
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</span>
                    @else
                        <a href="{{ $aktivitas->appends(request()->query())->url(1) }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&laquo;</a>
                        <a href="{{ $aktivitas->appends(request()->query())->previousPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&lsaquo;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $pageStart = max($aktivitas->currentPage() - 2, 1);
                        $pageEnd = min($aktivitas->currentPage() + 2, $aktivitas->lastPage());
                        $mobileStart = max($aktivitas->currentPage() - 1, 1);
                        $mobileEnd = min($aktivitas->currentPage() + 1, $aktivitas->lastPage());
                    @endphp

                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <a href="{{ $aktivitas->appends(request()->query())->url($i) }}"
                            class="hidden sm:inline-block px-3 py-1 rounded-lg {{ $i == $aktivitas->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @for ($i = $mobileStart; $i <= $mobileEnd; $i++)
                        <a href="{{ $aktivitas->appends(request()->query())->url($i) }}"
                            class="sm:hidden px-2 py-1 rounded-lg {{ $i == $aktivitas->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next & Last --}}
                    @if ($aktivitas->hasMorePages())
                        <a href="{{ $aktivitas->appends(request()->query())->nextPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&rsaquo;</a>
                        <a href="{{ $aktivitas->appends(request()->query())->url($aktivitas->lastPage()) }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&raquo;</a>
                    @else
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&rsaquo;</span>
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&raquo;</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection
