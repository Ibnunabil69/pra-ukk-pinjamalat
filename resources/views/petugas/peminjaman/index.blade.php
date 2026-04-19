@extends('layouts.petugas')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Peminjaman</h1>
                <p class="text-gray-500 mt-1">Kelola pengajuan peminjaman dan lakukan persetujuan</p>
            </div>
            
            <!-- TOMBOL SCAN BARCODE (MOBILE FRIENDLY) -->
            <button type="button" onclick="jalankanKameraScanner()"
                class="flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold shadow-lg hover:bg-primary-700 transition active:scale-95">
                <i class="ri-qr-scan-2-line text-xl"></i>
                <span>Scan Barcode</span>
            </button>
        </div>

        <!-- FILTER -->
        <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm mb-6 flex flex-wrap items-end gap-4">

            <!-- Cari Nama Peminjam / Alat -->
            <div class="flex-1 min-w-[220px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Nama peminjam / alat / barcode..."
                        class="w-full h-10 pl-10 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="ri-search-line"></i>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="flex-1 min-w-[180px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    @foreach (['menunggu', 'dipinjam', 'menunggu_pengembalian', 'dikembalikan', 'ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Pengajuan -->
            <div class="flex-1 min-w-[160px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm">
            </div>

            <!-- Per Page -->
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
                <a href="{{ route('petugas.peminjaman.index') }}"
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
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Peminjam</th>
                        <th class="px-6 py-3 text-left">Nama Alat</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($peminjamans as $peminjaman)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $peminjaman->user->name }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">{{ $peminjaman->alat->nama }}</td>
                            <td class="px-6 py-3">{{ $peminjaman->alat->kategori->nama ?? '-' }}</td>
                            <td class="px-6 py-3 text-center">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-3 text-center">
                                @php
                                    $color = match (strtolower($peminjaman->status)) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'menunggu_pengembalian' => 'bg-orange-100 text-orange-700',
                                        'dikembalikan', 'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <button onclick="bukaModalDetail({{ $peminjaman->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 transition shadow-sm">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada peminjaman saat ini
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

        <!-- ============================================================= -->
        <!-- MODAL AREA - PLACED AT THE VERY END OF CONTENT -->
        <!-- ============================================================= -->

        <!-- 1. MODAL SCANNER (PREMIUM UI - SOLID FOCUS) -->
        <div id="ID_MODAL_SCANNER" class="fixed inset-0 hidden items-center justify-center bg-black z-[100] p-0 sm:p-4 text-white">
            <div class="bg-gray-900 w-full h-full sm:h-auto sm:max-w-md sm:rounded-3xl shadow-2xl relative overflow-hidden flex flex-col border-none sm:border sm:border-gray-700">
                
                <!-- HEADER SCANNER (SOLID) -->
                <div class="p-5 border-b border-gray-800 flex justify-between items-center bg-gray-900">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="ri-qr-scan-2-line text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white leading-tight">Scanner Aktif</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Live Detection</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Tombol Mirror -->
                        <button onclick="toggleMirror()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 transition-all border border-gray-700">
                            <i class="ri-reflect-line"></i>
                            <span class="text-xs font-medium">Mirror</span>
                        </button>

                        <button onclick="tutupKameraScanner()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 transition-all border border-red-500/20">
                            <i class="ri-close-line"></i>
                            <span class="text-xs font-medium">Tutup</span>
                        </button>
                    </div>
                </div>

                <!-- SELECT KAMERA (PROMINENT) -->
                <div id="camera-selection-area" class="px-5 py-3 bg-gray-800/50 border-b border-gray-800 flex items-center gap-3">
                    <div class="flex items-center gap-2 text-blue-400">
                        <i class="ri-camera-switch-line"></i>
                        <span class="text-[10px] uppercase font-bold tracking-wider">Sumber:</span>
                    </div>
                    <select id="camera-select" class="bg-gray-900 text-xs text-white border border-gray-700 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 flex-1 outline-none cursor-pointer">
                        <option value="">Mencari Kamera...</option>
                    </select>
                </div>
                
                <!-- AREA KAMERA (FIXED RATIO) -->
                <div class="relative flex-1 bg-black flex items-center justify-center overflow-hidden min-h-[400px]">
                    <!-- Kotak Pembidik & Animasi (SANGAT JELAS) -->
                    <div class="absolute inset-0 z-30 flex items-center justify-center pointer-events-none">
                        <div class="w-64 h-64 border-2 border-white/20 rounded-3xl relative">
                            <!-- Garis Scan Merah (VIBRANT) -->
                            <div class="absolute inset-x-0 h-[3px] bg-red-600 shadow-[0_0_15px_rgba(220,38,38,1)] animate-scan-line"></div>
                            
                            <!-- Sudut-sudut (TEBAL) -->
                            <div class="absolute -top-1 -left-1 w-8 h-8 border-t-4 border-l-4 border-blue-500 rounded-tl-xl shadow-lg"></div>
                            <div class="absolute -top-1 -right-1 w-8 h-8 border-t-4 border-r-4 border-blue-500 rounded-tr-xl shadow-lg"></div>
                            <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-4 border-l-4 border-blue-500 rounded-bl-xl shadow-lg"></div>
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-4 border-r-4 border-blue-500 rounded-br-xl shadow-lg"></div>
                        </div>
                    </div>

                    <!-- Loader (Muncul sampai kamera nyala) -->
                    <div id="scanner-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 z-20">
                        <div class="w-12 h-12 border-4 border-white/10 border-t-blue-500 rounded-full animate-spin"></div>
                        <p class="mt-4 text-sm text-gray-400 font-medium">Memulai Kamera...</p>
                    </div>

                    <div id="reader" class="w-full h-full bg-black"></div>
                </div>
                
                <!-- FOOTER SCANNER (SOLID) -->
                <div class="p-6 text-center bg-gray-900 border-t border-gray-800">
                    <p class="text-sm text-gray-300">Posisikan Barcode di dalam kotak pembidik</p>
                    <p class="text-xs text-gray-500 mt-2">Pastikan pencahayaan cukup</p>
                </div>
            </div>
        </div>

        <style>
            @keyframes scan-line {
                0% { top: 0%; opacity: 0.1; }
                50% { opacity: 1; }
                100% { top: 100%; opacity: 0.1; }
            }
            #reader video {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                border-radius: 0px !important;
                transition: transform 0.3s ease;
            }
            .mirrored video {
                transform: scaleX(-1) !important;
            }
        </style>

        <!-- 2. MODAL DETAIL PEMINJAMAN (Z-INDEX 50) -->
        <div id="ID_MODAL_DETAIL" class="fixed inset-0 hidden items-center justify-center bg-black/50 backdrop-blur-sm z-50 p-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto">
                <!-- CLOSE -->
                <button onclick="tutupModalDetail()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>

                @foreach ($peminjamans as $peminjaman)
                    <div id="content-detail-{{ $peminjaman->id }}" class="hidden detail-container">
                        <div class="mb-5">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $peminjaman->alat->nama }}</h2>
                            <p class="text-sm text-gray-500">Informasi lengkap pengajuan</p>
                        </div>

                        <div class="space-y-3 text-sm border-t pt-4">
                            <div class="flex justify-between"><span class="text-gray-500">Peminjam</span><span class="font-medium text-gray-900">{{ $peminjaman->user->name }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Kategori</span><span>{{ $peminjaman->alat->kategori->nama ?? '-' }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Jumlah</span><span>{{ $peminjaman->jumlah }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="font-bold uppercase text-blue-600">{{ $peminjaman->status }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Diajukan Pada</span><span>{{ $peminjaman->created_at->format('d M Y') }}</span></div>
                            <div class="flex justify-between bg-blue-50 p-2 rounded-lg mt-2">
                                <span class="text-blue-600 font-medium">Rencana Kembali</span>
                                <span class="font-bold text-blue-700">
                                    {{ $peminjaman->tanggal_kembali_target?->format('d M Y') ?? 'Belum ditentukan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Tombol Aksi (Approve/Reject/Return) -->
                        <div class="mt-8">
                            @if (strtolower($peminjaman->status) === 'menunggu')
                                <div class="space-y-4">
                                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Tanggal Kembali</label>
                                    <input type="date" id="date-target-{{ $peminjaman->id }}" 
                                        value="{{ $peminjaman->tanggal_kembali_target?->format('Y-m-d') ?? date('Y-m-d') }}" 
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500">
                                    
                                    <div class="flex gap-3">
                                        <form action="{{ route('petugas.peminjaman.reject', $peminjaman) }}" method="POST" class="flex-1">@csrf
                                            <button type="submit" class="w-full py-2.5 rounded-xl border border-red-500 text-red-600 font-semibold hover:bg-red-50 transition">Tolak</button>
                                        </form>
                                        <form action="{{ route('petugas.peminjaman.approve', $peminjaman) }}" method="POST" class="flex-1" onsubmit="document.getElementById('hidden-date-{{ $peminjaman->id }}').value = document.getElementById('date-target-{{ $peminjaman->id }}').value">@csrf
                                            <input type="hidden" name="tanggal_kembali_target" id="hidden-date-{{ $peminjaman->id }}">
                                            <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-md">Setujui</button>
                                        </form>
                                    </div>
                                </div>
                            @elseif(in_array(strtolower($peminjaman->status), ['dipinjam', 'menunggu_pengembalian']))
                                <form method="POST" action="{{ route('petugas.pengembalian.proses', $peminjaman) }}">@csrf
                                    <button type="submit" class="w-full py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 shadow-lg transition transform active:scale-95">PROSES PENGEMBALIAN</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>

    <script>
        // --- LOGIKA SCANNER (MODAL REVISI - AUTO START) ---
        let html5QrCode = null;
        let currentCameraId = null;

        async function jalankanKameraScanner() {
            // Check HTTPS (Bypass untuk .test dan localhost)
            const isSecure = window.location.protocol === 'https:' || 
                             window.location.hostname === 'localhost' || 
                             window.location.hostname.endsWith('.test');

            if (!isSecure) {
                document.getElementById('protocol-warning').classList.remove('hidden');
            }

            // Reset UI
            document.getElementById('scanner-loader').classList.remove('hidden');
            const scanModal = document.getElementById('ID_MODAL_SCANNER');
            scanModal.classList.remove('hidden');
            scanModal.classList.add('flex');
            
            try {
                // Get Cameras
                const devices = await Html5Qrcode.getCameras();
                const select = document.getElementById('camera-select');
                select.innerHTML = '';

                if (devices && devices.length > 0) {
                    devices.forEach((device, index) => {
                        const opt = document.createElement('option');
                        opt.value = device.id;
                        opt.text = device.label || `Kamera ${index + 1}`;
                        select.appendChild(opt);
                    });

                    // Pilih kamera belakang secara default jika ada
                    const backCamera = devices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('environment'));
                    currentCameraId = backCamera ? backCamera.id : devices[0].id;
                    select.value = currentCameraId;

                    // Event listener ganti kamera
                    select.onchange = () => {
                        currentCameraId = select.value;
                        restartScanner();
                    };

                    startScanner(currentCameraId);
                } else {
                    throw "Tidak ada kamera ditemukan";
                }
            } catch (err) {
                console.error(err);
                alert("Error Kamera: " + err);
                tutupKameraScanner();
            }
        }

        function startScanner(cameraId) {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    initiateStart(cameraId);
                }).catch(() => initiateStart(cameraId));
            } else {
                initiateStart(cameraId);
            }
        }

        function initiateStart(cameraId) {
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 20, qrbox: { width: 250, height: 250 } };

            html5QrCode.start(
                cameraId, 
                config,
                (decodedText) => {
                    if (navigator.vibrate) navigator.vibrate(200);
                    tutupKameraScanner();
                    const input = document.getElementById('searchInput');
                    input.value = decodedText;
                    alert("Berhasil Scan: " + decodedText);
                    setTimeout(() => { input.closest('form').submit(); }, 500);
                },
                (errorMessage) => {
                    document.getElementById('scanner-loader').classList.add('hidden');
                }
            ).catch(err => {
                alert("Gagal Memulai: " + err);
                tutupKameraScanner();
            });
        }

        function restartScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    startScanner(currentCameraId);
                });
            }
        }

        function toggleMirror() {
            const reader = document.getElementById('reader');
            reader.classList.toggle('mirrored');
        }

        function tutupKameraScanner() {
            document.getElementById('ID_MODAL_SCANNER').classList.add('hidden');
            document.getElementById('ID_MODAL_SCANNER').classList.remove('flex');
            
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch(e => console.log("Stop Error: ", e));
            }
        }

        // --- LOGIKA DETAIL ---
        function bukaModalDetail(id) {
            const detailModal = document.getElementById('ID_MODAL_DETAIL');
            detailModal.classList.remove('hidden');
            detailModal.classList.add('flex');

            document.querySelectorAll('.detail-container').forEach(el => el.classList.add('hidden'));
            const content = document.getElementById('content-detail-' + id);
            if(content) content.classList.remove('hidden');
        }

        function tutupModalDetail() {
            document.getElementById('ID_MODAL_DETAIL').classList.add('hidden');
            document.getElementById('ID_MODAL_DETAIL').classList.remove('flex');
        }
    </script>
@endsection
