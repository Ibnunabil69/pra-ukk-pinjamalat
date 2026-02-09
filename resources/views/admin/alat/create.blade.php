@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto px-4">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tambah Alat Baru</h1>
                <p class="text-gray-500 mt-1">Isi data alat baru</p>
            </div>
            <a href="{{ route('admin.alat.index') }}"
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

        <!-- FORM CREATE ALAT -->
        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <form action="{{ route('admin.alat.store') }}" method="POST" id="createAlatForm">
                @csrf

                <!-- Nama Alat -->
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Alat</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama alat">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kategori_id') border-red-500 @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}"
                        class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stok') border-red-500 @enderror"
                        placeholder="Masukkan jumlah stok" min="0">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                    @error('status')
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
            <p class="text-gray-700 mb-6">Apakah data alat sudah benar? Pastikan semua kolom sudah sesuai.</p>
            <div class="flex justify-end gap-2">
                <button id="cancelModal" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                <button id="confirmModalBtn"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">Ya, Simpan</button>
            </div>
        </div>
    </div>

    <script>
        // Reset form
        document.getElementById('resetBtn').addEventListener('click', () => {
            document.getElementById('createAlatForm').reset();
        });

        // Modal konfirmasi
        const submitBtn = document.getElementById('submitBtn');
        const confirmModal = document.getElementById('confirmModal');
        const cancelModal = document.getElementById('cancelModal');
        const confirmModalBtn = document.getElementById('confirmModalBtn');

        submitBtn.addEventListener('click', () => confirmModal.classList.remove('hidden'));
        cancelModal.addEventListener('click', () => confirmModal.classList.add('hidden'));
        confirmModalBtn.addEventListener('click', () => document.getElementById('createAlatForm').submit());
    </script>
@endsection
