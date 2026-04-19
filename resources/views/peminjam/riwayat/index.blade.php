@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <style>
        .poppins-enforced,
        .poppins-enforced *:not(i) {
            font-family: 'Poppins', sans-serif !important;
        }

        .font-mono,
        .font-mono * {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }

        @media (min-width: 768px) {
            .desktop-only {
                display: block !important;
            }

            .mobile-only {
                display: none !important;
            }
        }

        @media (max-width: 767px) {
            .desktop-only {
                display: none !important;
            }

            .mobile-only {
                display: block !important;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto poppins-enforced">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Riwayat Peminjaman
            </h1>
            <p class="text-xs sm:text-base text-gray-500 mt-1">
                Daftar pengajuan dan status peminjaman alat Anda
            </p>
        </div>

        <!-- TABLE DESKTOP -->
        <div class="desktop-only bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nama Alat</th>
                            <th class="px-6 py-3 text-center font-semibold">Jumlah</th>
                            <th class="px-6 py-3 text-center font-semibold">Pinjam</th>
                            <th class="px-6 py-3 text-center font-semibold">Kembali</th>
                            <th class="px-6 py-3 text-center font-semibold">Status</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($peminjamans as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-900">{{ $item->alat->nama }}</div>
                                    <div class="text-[11px] font-mono text-gray-500 mt-0.5">{{ $item->alat->kode_alat }}</div>
                                </td>
                                <td class="px-6 py-3 text-center">{{ $item->jumlah }}</td>
                                <td class="px-6 py-3 text-center">
                                    {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ $item->tanggal_kembali_target ? \Carbon\Carbon::parse($item->tanggal_kembali_target)->format('d/m/Y') : '-' }}
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-3 text-center">
                                    @php
                                        $badge = match ($item->status) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                                            'dipinjam' => 'bg-blue-100 text-blue-700',
                                            'menunggu_pengembalian' => 'bg-orange-100 text-orange-700',
                                            'dikembalikan', 'disetujui' => 'bg-green-100 text-green-700',
                                            'ditolak' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <span class="px-2 py-1 rounded-full text-xs {{ $badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>

                                <!-- AKSI -->
                                <td class="px-6 py-3 text-center">
                                    @if ($item->status === 'dipinjam')
                                        <form method="POST"
                                            action="{{ route('peminjam.peminjaman.ajukan_pengembalian', $item->id) }}"
                                            class="form-kembali">
                                            @csrf
                                            <button class="px-3 py-2 bg-yellow-600 text-white rounded-lg text-xs">
                                                Kembalikan
                                            </button>
                                        </form>

                                    @elseif ($item->status === 'menunggu')
                                        <form method="POST" action="{{ route('peminjam.peminjaman.batalkan', $item->id) }}"
                                            class="form-batal">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 bg-red-600 text-white rounded-lg text-xs">
                                                Batal
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500">
                                    Belum ada riwayat peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MOBILE -->
        <div class="mobile-only space-y-4">
            @forelse ($peminjamans as $item)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 flex justify-end">
                        @php
                            $badge = match ($item->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                'dipinjam' => 'bg-blue-100 text-blue-700',
                                'menunggu_pengembalian' => 'bg-orange-100 text-orange-700',
                                'dikembalikan', 'disetujui' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold whitespace-nowrap {{ $badge }}">
                            {{ str_replace('_', ' ', ucfirst($item->status)) }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight pr-24">
                            {{ $item->alat->nama }}
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span
                                class="text-[11px] font-mono bg-gray-50 border border-gray-200 px-2 py-0.5 rounded text-gray-500">
                                {{ $item->alat->kode_alat }}
                            </span>
                            <span class="text-gray-300 text-xs">|</span>
                            <span class="text-gray-500 text-xs font-medium">Jumlah: {{ $item->jumlah }}</span>
                        </div>
                    </div>

                    <!-- Receipt Detail Section -->
                    <div class="mt-4 p-4 bg-gray-50/70 rounded-2xl border border-dashed border-gray-200">
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400 uppercase font-semibold tracking-wider">Tgl Pinjam</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400 uppercase font-semibold tracking-wider">Target Kembali</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $item->tanggal_kembali_target ? \Carbon\Carbon::parse($item->tanggal_kembali_target)->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400 uppercase font-semibold tracking-wider">Tgl
                                    Dikembalikan</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-400 uppercase font-semibold tracking-wider">Telat</span>
                                <span
                                    class="text-xs font-semibold {{ $item->telat_hari > 0 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $item->telat_hari }} Hari
                                </span>
                            </div>
                            <div class="pt-2 border-t border-gray-200 border-dashed flex justify-between items-center">
                                <span class="text-sm text-gray-500 uppercase font-semibold tracking-widest">Biaya Denda</span>
                                <span class="text-xs font-bold {{ $item->denda > 0 ? 'text-red-600' : 'text-gray-900' }}">
                                    Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    @if ($item->status === 'dipinjam')
                        <form method="POST" action="{{ route('peminjam.peminjaman.ajukan_pengembalian', $item->id) }}"
                            class="form-kembali">
                            @csrf
                            <button
                                class="w-full py-2 mt-2 flex items-center justify-center gap-2 bg-yellow-600 text-white rounded-xl text-sm font-semibold hover:bg-yellow-700 transition">
                                <i class="ri-refresh-line text-lg"></i>
                                Ajukan Pengembalian
                            </button>
                        </form>
                    @elseif ($item->status === 'menunggu')
                        <form method="POST" action="{{ route('peminjam.peminjaman.batalkan', $item->id) }}" class="form-batal">
                            @csrf
                            @method('DELETE')
                            <button
                                class="w-full py-2 mt-2 flex items-center justify-center gap-2 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                                <i class="ri-close-circle-line text-lg"></i>
                                Batalkan Peminjaman
                            </button>
                        </form>
                    @endif

                </div>
            @empty
                <div class="bg-white py-12 px-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="ri-history-line text-3xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada riwayat peminjaman</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ✅ SWEET ALERT (SATU SAJA) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Konfirmasi Pembatalan (Style Identic dengan Modal Logout)
        document.querySelectorAll('.form-batal').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    html: `
                            <div class="bg-white text-left">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                                        <i class="ri-alert-line text-xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-lg">
                                        Konfirmasi Pembatalan
                                    </h3>
                                </div>

                                <p class="text-sm text-gray-600 mb-6">
                                    Batal meminjam alat ini? Pengajuan akan dihapus dari daftar riwayat peminjaman Anda secara permanen.
                                </p>

                                <div class="flex justify-end gap-3">
                                    <button type="button" id="swal-batal-close"
                                        class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition">
                                        Tutup
                                    </button>
                                    <button type="button" id="swal-batal-confirm"
                                        class="px-4 py-2 rounded-lg text-sm bg-red-600 text-white font-medium hover:bg-red-700 transition shadow-lg shadow-red-500/20">
                                        Ya, Batalkan
                                    </button>
                                </div>
                            </div>
                        `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'rounded-2xl border-none shadow-2xl p-0 w-[92%] sm:w-full max-w-sm overflow-hidden',
                        htmlContainer: 'p-0 m-0'
                    },
                    didOpen: () => {
                        document.getElementById('swal-batal-confirm').onclick = () => Swal.clickConfirm();
                        document.getElementById('swal-batal-close').onclick = () => Swal.clickDeny();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Konfirmasi Pengembalian (Style Identic dengan Modal Logout)
        document.querySelectorAll('.form-kembali').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    html: `
                            <div class="bg-white w-full text-left">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                                        <i class="ri-checkbox-circle-line text-xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-lg">
                                        Ajukan Pengembalian?
                                    </h3>
                                </div>

                                <p class="text-sm text-gray-600 mb-6">
                                    Pastikan alat sudah dalam kondisi baik dan siap untuk dikembalikan langsung ke petugas terkait.
                                </p>

                                <div class="flex justify-end gap-3">
                                    <button type="button" id="swal-kembali-close"
                                        class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition">
                                        Nanti Saja
                                    </button>
                                    <button type="button" id="swal-kembali-confirm"
                                        class="px-4 py-2 rounded-lg text-sm bg-green-600 text-white font-medium hover:bg-green-700 transition shadow-lg shadow-green-500/20">
                                        Ya, Ajukan!
                                    </button>
                                </div>
                            </div>
                        `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'rounded-2xl border-none shadow-2xl p-0 w-[92%] sm:w-full max-w-sm overflow-hidden',
                        htmlContainer: 'p-0 m-0'
                    },
                    didOpen: () => {
                        document.getElementById('swal-kembali-confirm').onclick = () => Swal.clickConfirm();
                        document.getElementById('swal-kembali-close').onclick = () => Swal.clickDeny();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection