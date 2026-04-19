<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Equiply</title>
    <link rel="icon" href="{{ asset('assets/favicon-equily.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/favicon-equiply.svg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Desktop: Sidebar samping */
        @media (min-width: 768px) {
            #sidebar {
                height: 100vh !important;
                height: 100dvh !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 16rem !important; /* w-64 */
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                transform: translateX(0) !important;
            }
        }

        /* Mobile: Floating Card (Force Position) */
        @media (max-width: 767px) {
            #sidebar {
                left: 1rem !important;
                right: 1rem !important;
                bottom: 6rem !important;
                top: auto !important;
                width: auto !important;
                height: auto !important;
                max-height: 75vh !important;
                border: 1px solid #e5e7eb !important;
                border-radius: 2rem !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            }
        }
    </style>
</head>

<body class="bg-background min-h-screen flex">

    @include('layouts.notif-login')

    <!-- SIDEBAR -->
    <aside class="fixed z-40 bg-surface flex flex-col transition-all duration-300 pointer-events-none md:pointer-events-auto opacity-0 md:opacity-100"
        id="sidebar">

        <!-- LOGO (Absolute Original Turn 1) -->
        <div class="px-6 pb-4 border-b border-border">
            <img src="{{ asset('assets/logo-web.png') }}" alt="Equiply"
                class="h-20 max-w-[200px] object-contain select-none">

            <!-- ROLE INFO -->
            <div class="mt-2 flex items-center gap-2 text-xs text-text-muted">
                <span class="w-7 h-7 flex items-center justify-center rounded-full bg-primary-50 text-primary-600">
                    <i class="ri-user-line"></i>
                </span>
                <span>
                    Masuk sebagai
                    <span class="block font-medium text-text-primary capitalize">
                        {{ auth()->user()->role }}
                    </span>
                </span>
            </div>
        </div>

        <!-- MENU (Absolute Original Turn 1 + Added py-3 for 'lega') -->
        <nav class="flex-1 px-3 py-4 text-sm space-y-2 overflow-y-auto">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-lg
               {{ request()->routeIs('dashboard', 'peminjam.dashboard')
    ? 'bg-primary-50 text-primary-700 font-medium'
    : 'text-text-secondary hover:bg-primary-50' }}">
                <i class="ri-dashboard-line text-base"></i>
                Dashboard
            </a>


            @if (auth()->user()->role === 'peminjam')
                <div>
                    <p class="px-3 mt-4 mb-2 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                        Peminjaman
                    </p>

                    <!-- Daftar Alat -->
                    <a href="/peminjam/alat"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg
                {{ request()->is('peminjam/alat*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-tools-line text-base"></i>
                        Daftar Alat
                    </a>

                    <!-- Riwayat -->
                    <a href="/peminjam/riwayat"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg
                {{ request()->is('peminjam/riwayat*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-history-line text-base"></i>
                        Riwayat Peminjaman
                    </a>
                </div>
            @endif

        </nav>

        <!-- LOGOUT AREA (Absolute Original Turn 1) -->
        <div class="p-4 border-t border-border">
            <button type="button" onclick="openLogoutModal()"
                class="w-full flex items-center justify-center gap-2
               rounded-xl py-2.5
               bg-danger text-white font-medium
               hover:bg-red-700 transition">
                <i class="ri-logout-box-r-line"></i>
                Logout
            </button>
        </div>


    </aside>

    <!-- MODAL LOGOUT -->
    <div id="logoutModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50">

        <div class="bg-white rounded-2xl w-full max-w-sm p-6 animate-fade-in shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                    <i class="ri-alert-line text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 text-lg">
                    Konfirmasi Logout
                </h3>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                Apakah kamu yakin ingin keluar dari aplikasi?
            </p>

            <div class="flex justify-end gap-3">
                <button onclick="closeLogoutModal()"
                    class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm bg-danger text-white font-medium hover:bg-red-700 transition">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- OVERLAY MOBILE -->
    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 hidden md:hidden transition-all duration-300"></div>

    <!-- TOGGLE MOBILE (SaaS Style Pill FAB) -->
    <button
        class="fixed z-50 md:hidden h-14 px-6 bg-gray-50 text-gray-900 border border-gray-200 rounded-full shadow-2xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-3"
        id="sidebarToggle"
        style="bottom: 30px !important; right: 24px !important; top: auto !important; left: auto !important;">

        <span id="toggleIcon" class="transition-transform duration-300">
            <i class="ri-menu-line text-2xl" id="iconMenu"></i>
        </span>
        <span class="text-xs font-bold uppercase tracking-widest leading-none pr-1" id="toggleText">MENU</span>
    </button>

    <!-- CONTENT -->
    <main class="flex-1 p-4 md:p-8 md:ml-64 w-full min-w-0">
        @yield('content')
    </main>

    <script>
        // SIDEBAR TOGGLE LOGIC
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('translate-y-0') || sidebar.style.opacity === '1';

            if (isOpen && window.innerWidth < 768) {
                // TUTUP (Mobile Only)
                sidebar.classList.add('opacity-0', 'translate-y-32', 'pointer-events-none');
                sidebar.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');

                document.getElementById('iconMenu').className = 'ri-menu-line text-2xl';
                document.getElementById('toggleText').innerText = 'MENU';
            } else {
                // BUKA (Mobile Only)
                sidebar.classList.remove('opacity-0', 'translate-y-32', 'pointer-events-none');
                sidebar.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                document.getElementById('iconMenu').className = 'ri-close-line text-2xl';
                document.getElementById('toggleText').innerText = 'CLOSE';
            }
        }

        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        // LOGOUT MODAL LOGIC
        const modal = document.getElementById('logoutModal');

        function openLogoutModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeLogoutModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // klik backdrop
        modal?.addEventListener('click', (e) => {
            if (e.target === modal) closeLogoutModal();
        });

        // tekan ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLogoutModal();
        });
    </script>

</body>

</html>
