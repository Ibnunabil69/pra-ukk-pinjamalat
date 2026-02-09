@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen Alat</h1>
                <p class="text-gray-500 mt-1">Kelola alat dan stoknya</p>
            </div>
            <a href="{{ route('admin.alat.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm leading-5">
                <i class="ri-add-line"></i> Tambah Alat
            </a>
        </div>

        <!-- FILTER FORM -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Search -->
            <div class="flex-1 min-w-[220px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Alat</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama alat..."
                        class="w-full h-10 pl-10 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i
                        class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <!-- Kategori Dropdown -->
            <div class="flex-1 min-w-[150px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
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
                <a href="{{ route('admin.alat.index') }}"
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
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Nama Alat</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($alats as $alat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">{{ $loop->iteration + ($alats->currentPage() - 1) * $alats->perPage() }}
                            </td>
                            <td class="px-6 py-3">{{ $alat->nama }}</td>
                            <td class="px-6 py-3">{{ $alat->kategori->nama ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $alat->stok }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $color =
                                        $alat->status === 'tersedia'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-yellow-100 text-yellow-700';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-sm font-medium {{ $color }}">
                                    {{ ucfirst($alat->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.alat.edit', $alat) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm leading-5">
                                        <i class="ri-pencil-line"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST"
                                        onsubmit="return confirm('Hapus alat ini?')">
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
                            <td colspan="6" class="py-12 text-center text-gray-500">Belum ada alat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION CUSTOM -->
        @if ($alats->lastPage() > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 text-sm text-gray-700 gap-2 sm:gap-0">

                <!-- Info item -->
                <div class="whitespace-nowrap">
                    Menampilkan {{ $alats->firstItem() ?? 0 }} - {{ $alats->lastItem() ?? 0 }} dari
                    {{ $alats->total() ?? 0 }} alat
                </div>

                <!-- Links -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-1">

                    {{-- First & Previous --}}
                    @if ($alats->onFirstPage())
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</span>
                    @else
                        <a href="{{ $alats->appends(request()->query())->url(1) }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&laquo;</a>
                        <a href="{{ $alats->appends(request()->query())->previousPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&lsaquo;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $pageStart = max($alats->currentPage() - 2, 1);
                        $pageEnd = min($alats->currentPage() + 2, $alats->lastPage());
                        $mobileStart = max($alats->currentPage() - 1, 1);
                        $mobileEnd = min($alats->currentPage() + 1, $alats->lastPage());
                    @endphp

                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <a href="{{ $alats->appends(request()->query())->url($i) }}"
                            class="hidden sm:inline-block px-3 py-1 rounded-lg {{ $i == $alats->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @for ($i = $mobileStart; $i <= $mobileEnd; $i++)
                        <a href="{{ $alats->appends(request()->query())->url($i) }}"
                            class="sm:hidden px-2 py-1 rounded-lg {{ $i == $alats->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next & Last --}}
                    @if ($alats->hasMorePages())
                        <a href="{{ $alats->appends(request()->query())->nextPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&rsaquo;</a>
                        <a href="{{ $alats->appends(request()->query())->url($alats->lastPage()) }}"
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
