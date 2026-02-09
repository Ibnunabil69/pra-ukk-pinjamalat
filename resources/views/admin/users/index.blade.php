@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manajemen User</h1>
                <p class="text-gray-500 mt-1">Kelola akun user admin, petugas, dan peminjam</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm leading-5">
                <i class="ri-add-line"></i> Tambah User
            </a>
        </div>

        <!-- FILTER FORM -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Search -->
            <div class="flex-1 min-w-[220px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari User</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                        class="w-full h-10 pl-10 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i
                        class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <!-- Role Dropdown Custom -->
            <div class="flex-1 min-w-[150px] relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <div class="relative">
                    <button type="button"
                        class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="roleDropdownBtn">
                        <span id="roleDropdownLabel">{{ request('role') ?? 'Semua Role' }}</span>
                        <i class="ri-arrow-down-s-line text-gray-400"></i>
                    </button>
                    <ul id="roleDropdownMenu"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto text-sm">
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="">Semua Role</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="admin">Admin</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="petugas">Petugas</li>
                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="peminjam">Peminjam</li>
                    </ul>
                    <input type="hidden" name="role" id="roleDropdownInput" value="{{ request('role') }}">
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
                <a href="{{ route('admin.users.index') }}"
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
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-6 py-3">{{ $user->name }}</td>
                            <td class="px-6 py-3">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-start">
                                @php
                                    switch ($user->role) {
                                        case 'admin':
                                            $color = 'bg-red-100 text-red-700';
                                            break;
                                        case 'petugas':
                                            $color = 'bg-blue-100 text-blue-700';
                                            break;
                                        case 'peminjam':
                                            $color = 'bg-green-100 text-green-700';
                                            break;
                                        default:
                                            $color = 'bg-gray-100 text-gray-700';
                                    }
                                @endphp
                                <span class="px-2 py-1 rounded-full text-sm font-medium {{ $color }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm leading-5">
                                    <i class="ri-pencil-line"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm leading-5">
                                        <i class="ri-delete-bin-line"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">Belum ada user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION CUSTOM -->
        <!-- PAGINATION CUSTOM RESPONSIVE -->
        @if ($users->lastPage() > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 text-sm text-gray-700 gap-2 sm:gap-0">

                <!-- Info item -->
                <div class="whitespace-nowrap">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() ?? 0 }} user
                </div>

                <!-- Links -->
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-1">

                    {{-- First & Previous --}}
                    @if ($users->onFirstPage())
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
                        <span
                            class="px-2 sm:px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&lsaquo;</span>
                    @else
                        <a href="{{ $users->appends(request()->query())->url(1) }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&laquo;</a>
                        <a href="{{ $users->appends(request()->query())->previousPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&lsaquo;</a>
                    @endif

                    {{-- Page Numbers (hanya tampil 5 halaman di desktop, 3 di mobile) --}}
                    @php
                        $pageStart = max($users->currentPage() - 2, 1);
                        $pageEnd = min($users->currentPage() + 2, $users->lastPage());
                        $mobileStart = max($users->currentPage() - 1, 1);
                        $mobileEnd = min($users->currentPage() + 1, $users->lastPage());
                    @endphp

                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <a href="{{ $users->appends(request()->query())->url($i) }}"
                            class="hidden sm:inline-block px-3 py-1 rounded-lg {{ $i == $users->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @for ($i = $mobileStart; $i <= $mobileEnd; $i++)
                        <a href="{{ $users->appends(request()->query())->url($i) }}"
                            class="sm:hidden px-2 py-1 rounded-lg {{ $i == $users->currentPage() ? 'bg-blue-600 text-white' : 'bg-white border hover:bg-gray-50' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next & Last --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->appends(request()->query())->nextPageUrl() }}"
                            class="px-2 sm:px-3 py-1 rounded-lg bg-white border hover:bg-gray-50">&rsaquo;</a>
                        <a href="{{ $users->appends(request()->query())->url($users->lastPage()) }}"
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

        setupDropdown('roleDropdownBtn', 'roleDropdownMenu', 'roleDropdownLabel', 'roleDropdownInput');
        setupDropdown('pageDropdownBtn', 'pageDropdownMenu', 'pageDropdownLabel', 'pageDropdownInput');
    </script>
@endsection
