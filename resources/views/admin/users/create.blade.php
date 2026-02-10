@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto px-4">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah User Baru</h1>
                <p class="text-gray-500 mt-1">Isi data user admin, petugas, atau peminjam</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm leading-5">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <!-- TOAST SUKSES -->
        @if (session('success'))
            <div class="fixed top-6 right-6 z-50">
                <div
                    class="flex items-center gap-3 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm font-medium text-green-900 shadow-md">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600">
                        <i class="ri-checkbox-circle-fill text-lg"></i>
                    </div>
                    <span class="flex-1 truncate">{{ session('success') }}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-700">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- FORM CREATE USER -->
        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Nama lengkap user">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        placeholder="user@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Dropdown Custom -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="relative">
                        <button type="button"
                            class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror"
                            id="roleDropdownBtn">
                            <span id="roleDropdownLabel">{{ old('role') ? ucfirst(old('role')) : 'Pilih Role' }}</span>
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </button>
                        <ul id="roleDropdownMenu"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto text-sm">
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="petugas">Petugas</li>
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer" data-value="peminjam">Peminjam</li>
                        </ul>
                        <input type="hidden" name="role" id="roleDropdownInput" value="{{ old('role') }}">
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit & Reset -->
                <div class="flex justify-end gap-2">
                    <button type="button" id="resetBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm leading-5">
                        <i class="ri-refresh-line"></i> Batal
                    </button>
                    <button type="button" id="submitBtn"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm leading-5">
                        <i class="ri-check-line"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- MODAL KONFIRMASI -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-xl p-6 w-96">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Simpan</h2>
            <p class="text-gray-700 mb-6">Apakah data sudah benar? Pastikan semua field sudah diisi dengan benar.</p>
            <div class="flex justify-end gap-2">
                <button id="cancelModal" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                <button id="confirmModalBtn"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <script>
        // Dropdown custom
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

        // Reset form
        document.getElementById('resetBtn').addEventListener('click', () => {
            const form = document.getElementById('createUserForm');
            form.reset();
            const roleInput = document.getElementById('roleDropdownInput');
            const roleLabel = document.getElementById('roleDropdownLabel');
            roleInput.value = '';
            roleLabel.textContent = 'Pilih Role';
        });

        // Modal konfirmasi sebelum submit
        const submitBtn = document.getElementById('submitBtn');
        const confirmModal = document.getElementById('confirmModal');
        const cancelModal = document.getElementById('cancelModal');
        const confirmModalBtn = document.getElementById('confirmModalBtn');

        submitBtn.addEventListener('click', () => {
            confirmModal.classList.remove('hidden');
        });

        cancelModal.addEventListener('click', () => {
            confirmModal.classList.add('hidden');
        });

        confirmModalBtn.addEventListener('click', () => {
            document.getElementById('createUserForm').submit();
        });
    </script>
@endsection
