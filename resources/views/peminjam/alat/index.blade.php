@extends('layouts.peminjam')

@section('title', 'Daftar Alat')

@section('content')
    <style>
        /* Force Poppins for all elements in this view to ensure consistency */
        .poppins-enforced, .poppins-enforced *:not(i) {
            font-family: 'Poppins', sans-serif !important;
        }
        /* Except mono elements */
        .font-mono, .font-mono * {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }

        /* Robust visibility control */
        @media (min-width: 768px) {
            .desktop-only { display: block !important; }
            .mobile-only { display: none !important; }
        }
        @media (max-width: 767px) {
            .desktop-only { display: none !important; }
            .mobile-only { display: block !important; }
        }
    </style>

    <div class="max-w-7xl mx-auto poppins-enforced">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Alat</h1>
            <p class="text-xs md:text-lg text-gray-500 mt-1">
                Pilih alat yang tersedia untuk diajukan peminjamannya
            </p>
        </div>

        @php
            $items = $alat->items();
        @endphp

        <!-- 1. FILTER FOR DESKTOP (Standard Style) -->
        <div class="desktop-only mb-6">
            <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm flex items-end gap-4 overflow-x-auto">
                <!-- Search -->
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Alat / Scan</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" id="searchInputDesktop" value="{{ request('search') }}"
                                placeholder="Ketik nama atau kode alat..."
                                class="w-full h-10 pl-9 pr-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <button type="button" onclick="jalankanKameraScanner()" 
                            class="h-10 px-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition flex items-center justify-center shadow-sm">
                            <i class="ri-qr-scan-line text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="stok" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua</option>
                        <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-2 ml-auto">
                    <button type="submit" class="px-6 h-10 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition">
                        Filter
                    </button>
                    <a href="{{ route('peminjam.alat.index') }}" class="px-4 h-10 flex items-center justify-center border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 bg-white text-gray-600 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- 2. FILTER FOR MOBILE (Standard Style) -->
        <div class="mobile-only mb-6">
            <form method="GET" class="bg-white p-5 rounded-xl border shadow-sm flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Alat / Scan</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" id="searchInputMobile" value="{{ request('search') }}"
                                placeholder="Ketik nama atau kode alat..."
                                class="w-full h-10 px-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <button type="button" onclick="jalankanKameraScanner()" class="h-10 px-3 bg-primary-600 text-white rounded-lg flex items-center justify-center shrink-0">
                            <i class="ri-qr-scan-line text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="stok" class="w-full h-10 border border-gray-300 rounded-lg px-3 text-sm focus:ring-2 focus:ring-primary-500">
                            <option value="">Semua</option>
                            <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Dipinjam</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 mt-2">
                    <button type="submit" class="flex-1 h-10 bg-primary-600 text-white rounded-lg text-sm font-medium">
                        Filter
                    </button>
                    <a href="{{ route('peminjam.alat.index') }}" class="px-4 h-10 flex items-center justify-center border border-gray-300 rounded-lg text-sm font-medium bg-white text-gray-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- TABLE FOR DESKTOP -->
        <div class="desktop-only bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Nama Alat</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Kode Barcode</th>
                            <th class="px-6 py-3 text-left whitespace-nowrap">Kategori</th>
                            <th class="px-6 py-3 text-center whitespace-nowrap">Status</th>
                            <th class="px-6 py-3 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 whitespace-nowrap">{{ $item->nama }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-0.5 bg-gray-100 border rounded font-mono text-xs text-gray-600 uppercase">{{ $item->kode_alat }}</span>
                                </td>
                                <td class="px-6 py-3">{{ $item->kategori->nama ?? '-' }}</td>
                                <td class="px-6 py-3 text-center">
                                    @php
                                        $color = $item->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700';
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-[11px] tracking-wider {{ $color }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @if ($item->status === 'tersedia')
                                        <a href="{{ url('/peminjam/alat/' . $item->id . '/ajukan') }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-600 text-white rounded-lg text-xs hover:bg-primary-700 transition shadow-sm">
                                            <i class="ri-add-circle-line"></i> Ajukan
                                        </a>
                                    @else
                                        <button disabled class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-200 text-gray-400 rounded-lg text-xs cursor-not-allowed">
                                            <i class="ri-add-circle-line"></i> Ajukan
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    Tidak ada alat ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LIST FOR MOBILE (Synced with Desktop Style) -->
        <div class="mobile-only space-y-4">
            @forelse ($items as $item)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 text-right">
                        @php
                            $statusColor = $item->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusColor }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="mb-5">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight pr-20">{{ $item->nama }}</h3>
                        <div class="flex items-center gap-2 mt-2">
                             <span class="text-[11px] font-mono bg-gray-50 border border-gray-200 px-2 py-0.5 rounded text-gray-500">
                                {{ $item->kode_alat }}
                             </span>
                             <span class="text-gray-300 text-xs">|</span>
                             <span class="text-gray-500 text-xs font-medium">{{ $item->kategori->nama ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    @if ($item->status === 'tersedia')
                        <a href="{{ url('/peminjam/alat/' . $item->id . '/ajukan') }}"
                            class="w-full h-10 flex items-center justify-center gap-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition">
                            <i class="ri-add-circle-line text-lg"></i>
                            Ajukan Peminjaman
                        </a>
                    @else
                        <button disabled class="w-full h-10 flex items-center justify-center gap-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                            <i class="ri-error-warning-line text-lg"></i>
                            Alat Tidak Tersedia
                        </button>
                    @endif
                </div>
            @empty
                <div class="bg-white py-12 px-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="ri-tools-line text-3xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada alat ditemukan</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- ============================================================= -->
    <!-- MODAL AREA - PREMIUM SCANNER UI -->
    <!-- ============================================================= -->

    <!-- 1. MODAL SCANNER -->
    <div id="ID_MODAL_SCANNER" class="fixed inset-0 hidden items-center justify-center bg-black z-[100] p-0 sm:p-4 text-white">
        <div class="bg-gray-900 w-full h-full sm:h-auto sm:max-w-md sm:rounded-3xl shadow-2xl relative overflow-hidden flex flex-col border-none sm:border sm:border-gray-700">
            
            <!-- HEADER SCANNER -->
            <div class="p-5 border-b border-gray-800 flex justify-between items-center bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                        <i class="ri-qr-scan-2-line text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white leading-tight">Cari Alat</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="toggleMirror()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 transition-all border border-gray-700">
                        <i class="ri-loop-left-line"></i>
                        <span class="text-xs font-medium">Mirror</span>
                    </button>
                    <button onclick="tutupKameraScanner()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 transition-all border border-red-500/20">
                        <i class="ri-close-line"></i>
                        <span class="text-xs font-medium text-white">Tutup</span>
                    </button>
                </div>
            </div>

            <!-- SELECT KAMERA -->
            <div id="camera-selection-area" class="px-5 py-3 bg-gray-800/50 border-b border-gray-800 flex items-center gap-3">
                <div class="flex items-center gap-2 text-blue-400">
                    <i class="ri-camera-switch-line"></i>
                    <span class="text-sm uppercase font-bold tracking-wider text-white">Lensa:</span>
                </div>
                <select id="camera-select" class="bg-gray-900 text-xs text-white border border-gray-700 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 flex-1 outline-none cursor-pointer">
                    <option value="">Mencari Kamera...</option>
                </select>
            </div>
            
            <!-- AREA KAMERA -->
            <div class="relative flex-1 bg-black flex items-center justify-center overflow-hidden min-h-[400px]">
                <div class="absolute inset-0 z-30 flex items-center justify-center pointer-events-none">
                    <div class="w-64 h-64 border-2 border-white/20 rounded-3xl relative">
                        <div class="absolute inset-x-0 h-[3px] bg-red-600 shadow-[0_0_15px_rgba(220,38,38,1)] animate-scan-line"></div>
                        <div class="absolute -top-1 -left-1 w-8 h-8 border-t-4 border-l-4 border-blue-500 rounded-tl-xl shadow-lg"></div>
                        <div class="absolute -top-1 -right-1 w-8 h-8 border-t-4 border-r-4 border-blue-500 rounded-tr-xl shadow-lg"></div>
                        <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-4 border-l-4 border-blue-500 rounded-bl-xl shadow-lg"></div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-4 border-r-4 border-blue-500 rounded-br-xl shadow-lg"></div>
                    </div>
                </div>

                <div id="scanner-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 z-20">
                    <div class="w-12 h-12 border-4 border-white/10 border-t-blue-500 rounded-full animate-spin"></div>
                    <p class="mt-4 text-sm text-gray-400 font-medium font-white">Menghubungkan Kamera...</p>
                </div>

                <div id="reader" class="w-full h-full bg-black"></div>
            </div>
            
            <div class="p-6 text-center bg-gray-900 border-t border-gray-800 text-white">
                <p class="text-sm text-gray-300">Scan Barcode untuk Menemukan Alat</p>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>
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
        .animate-scan-line {
            position: absolute;
            animation: scan-line 2.5s infinite linear;
        }
    </style>

    <script>
        let html5QrCode = null;
        let currentCameraId = null;

        async function jalankanKameraScanner() {
            document.getElementById('scanner-loader').classList.remove('hidden');
            const scanModal = document.getElementById('ID_MODAL_SCANNER');
            scanModal.classList.remove('hidden');
            scanModal.classList.add('flex');
            
            try {
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

                    const backCamera = devices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('environment'));
                    currentCameraId = backCamera ? backCamera.id : devices[0].id;
                    select.value = currentCameraId;

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
                    // Detect which input is visible (Desktop or Mobile)
                    const desktopInput = document.getElementById('searchInputDesktop');
                    const mobileInput = document.getElementById('searchInputMobile');
                    
                    const targetInput = (desktopInput && desktopInput.offsetParent !== null) 
                                        ? desktopInput 
                                        : mobileInput;

                    if (targetInput) {
                        targetInput.value = decodedText;
                        targetInput.closest('form').submit();
                    }
                },
                (errorMessage) => {
                    const loader = document.getElementById('scanner-loader');
                    if (loader && !loader.classList.contains('hidden')) {
                        loader.classList.add('hidden');
                    }
                }
            ).catch(err => {
                alert("Gagal Memulai Kamera: " + err);
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
    </script>
@endsection
