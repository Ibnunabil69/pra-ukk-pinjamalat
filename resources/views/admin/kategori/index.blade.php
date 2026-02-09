@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Kategori</h1>
                <p class="text-gray-500 mt-1">Kelola kategori alat</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm leading-5">
                <i class="ri-add-line"></i> Tambah Kategori
            </a>
        </div>

        <!-- FILTER FORM -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Search -->
            <div class="flex-1 min-w-[220px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Kategori</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama kategori..."
                        class="w-full h-10 pl-10 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i
                        class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <!-- Page Size Dropdown Custom -->
            <div class="flex-1 min-w-[120px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                <div class="relative">
                    <button type="button"
                        class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="pageDropdownBtn">
                        <span id="pageDropdownLabel">{{ request('perPage') ?? 10 }}</span>
                        <i class="ri-arrow-down-s-line text-gray-400"></i>
                    </button>
                    <ul id="pageDropdownMenu"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto text-sm">
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="5">5</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="10">10</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="25">25</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="50">50</li>
                    </ul>
                    <input type="hidden" name="perPage" id="pageDropdownInput" value="{{ request('perPage') ?? 10 }}">
                </div>
            </div>

            <!-- Submit & Reset -->
            <div class="flex gap-2 ml-auto">
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm leading-5">
                    <i class="ri-filter-3-line"></i> Filter
                </button>
                <a href="{{ route('admin.kategori.index') }}"
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
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Kategori
                        </th>
                        <th class="px-6 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kategoris as $kategori)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">
                                {{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                            <td class="px-6 py-3">{{ $kategori->nama }}</td>
                            <td class="px-0 py-3">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm leading-5">
                                        <i class="ri-pencil-line"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST"
                                        onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm leading-5">
                                            <i class="ri-delete-bin-line"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-500">Belum ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION CUSTOM -->
        @if ($kategoris->lastPage() > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 text-sm text-gray-700 gap-2 sm:gap-0">

                <!-- Info item -->
                <div class="whitespace-nowrap">
                    Menampilkan {{ $kategoris->firstItem() ?? 0 }} - {{ $kategoris->lastItem() ?? 0 }} dari
                    {{ $kategoris->total() ?? 0 }} kategori
                </div>

                <!-- Links -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-1">

                    {{-- First & Previous --}}
                    @if ($kategoris->onFirstPage())
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</span>
                    @else
                        <a href="{{ $kategoris->appends(request()->query())->url(1) }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&laquo;</a>
                        <a href="{{ $kategoris->appends(request()->query())->previousPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&lsaquo;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $pageStart = max($kategoris->currentPage() - 2, 1);
                        $pageEnd = min($kategoris->currentPage() + 2, $kategoris->lastPage());
                        $mobileStart = max($kategoris->currentPage() - 1, 1);
                        $mobileEnd = min($kategoris->currentPage() + 1, $kategoris->lastPage());
                    @endphp

                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <a href="{{ $kategoris->appends(request()->query())->url($i) }}"
                            class="hidden sm:inline-block px-3 py-1 rounded-lg {{ $i == $kategoris->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @for ($i = $mobileStart; $i <= $mobileEnd; $i++)
                        <a href="{{ $kategoris->appends(request()->query())->url($i) }}"
                            class="sm:hidden px-2 py-1 rounded-lg {{ $i == $kategoris->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next & Last --}}
                    @if ($kategoris->hasMorePages())
                        <a href="{{ $kategoris->appends(request()->query())->nextPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&rsaquo;</a>
                        <a href="{{ $kategoris->appends(request()->query())->url($kategoris->lastPage()) }}"
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

    <!-- JS Custom Dropdown -->
    <script>
        function setupDropdown(btnId, menuId, labelId, inputId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const label = document.getElementById(labelId);
            const input = document.getElementById(inputId);

            btn.addEventListener('click', () => menu.classList.toggle('hidden'));

            menu.querySelectorAll('li').forEach(item => {
                item.addEventListener('click', () => {
                    label.textContent = item.textContent;
                    input.value = item.getAttribute('data-value');
                    menu.classList.add('hidden');
                });
            });

            document.addEventListener('click', e => {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        }

        setupDropdown('pageDropdownBtn', 'pageDropdownMenu', 'pageDropdownLabel', 'pageDropdownInput');
    </script>
@endsection
