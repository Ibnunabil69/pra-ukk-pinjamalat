@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Ajukan Peminjaman</h1>
            <p class="text-sm sm:text-medium text-gray-500 mt-1">
                Isi form di bawah ini untuk mengajukan peminjaman alat
            </p>
        </div>

        <!-- ALERT -->
        @if (session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <div class="bg-white rounded-xl border shadow-sm p-6 sm:p-8">
            <form method="POST" action="{{ url('/peminjam/peminjaman') }}">
                @csrf

                <!-- ALAT -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Alat
                    </label>
                    <input type="text" value="{{ $alat->nama }}" class="w-full rounded-lg border-gray-300 bg-gray-100"
                        readonly>
                </div>

                <!-- KATEGORI -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori
                    </label>
                    <input type="text" value="{{ $alat->kategori->nama ?? '-' }}"
                        class="w-full rounded-lg border-gray-300 bg-gray-100" readonly>
                </div>

                <!-- STOK -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Stok Tersedia
                    </label>
                    <input type="text" value="{{ $alat->stok }}" class="w-full rounded-lg border-gray-300 bg-gray-100"
                        readonly>
                </div>

                <!-- TANGGAL TARGET KEMBALI -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Target Kembali
                    </label>
                    <input type="date" name="tanggal_kembali_target" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        value="{{ old('tanggal_kembali_target') }}"
                        class="w-full rounded-lg border-gray-300 @error('tanggal_kembali_target') border-red-500 @enderror"
                        required>
                    @error('tanggal_kembali_target')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-amber-600 mt-2 flex items-center gap-1.5 font-medium leading-relaxed">
                        <i class="ri-information-line text-sm"></i>
                        <span>Penting: Keterlambatan pengembalian akan dikenakan denda sebesar <strong>Rp 2.000 / hari</strong>.</span>
                    </p>
                </div>

                <!-- HIDDEN -->
                <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                <input type="hidden" name="jumlah" value="1">

                <!-- BUTTON -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2 rounded-lg bg-primary-600
                               text-white font-medium hover:bg-primary-700 text-sm">
                        Ajukan Peminjaman
                    </button>

                    <a href="/peminjam/alat"
                        class="w-full sm:w-auto px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50 text-center text-sm font-medium">
                        Kembali
                    </a>

                </div>
            </form>
        </div>

    </div>
@endsection