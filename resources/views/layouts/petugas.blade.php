<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Petugas Dashboard') | Equiply</title>
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

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-background min-h-screen flex">
    @include('layouts.notif-login')

    <!-- SIDEBAR -->
    <aside
        class="fixed top-0 left-0 h-screen w-64 bg-surface border-r border-border flex flex-col shadow-soft
               transform -translate-x-full md:translate-x-0 transition-transform duration-300"
        id="sidebar">

        <!-- LOGO & ROLE -->
        <div class="px-6 pb-4 border-b border-border">
            <img src="{{ asset('assets/logo-web.png') }}" alt="Equiply"
                class="h-20 max-w-[200px] object-contain select-none">

            <div class="mt-2 flex items-center gap-2 text-xs text-text-muted">
                <span
                    class="inline-flex items-center justify-center
                           w-7 h-7 rounded-full
                           bg-primary-50 text-primary-600">
                    <i class="ri-shield-user-line text-sm"></i>
                </span>

                <span class="leading-tight">
                    Masuk sebagai
                    <span class="block font-medium text-text-primary capitalize">
                        Petugas
                    </span>
                </span>
            </div>
        </div>

        <!-- MENU -->
        <nav class="flex-1 px-3 py-4 text-sm space-y-6">

            <!-- DASHBOARD -->
            <a href="{{ route('petugas.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
    {{ request()->is('petugas/dashboard*')
        ? 'bg-primary-50 text-primary-700 font-medium'
        : 'text-text-secondary hover:bg-primary-50' }}">
                <i class="ri-dashboard-line text-base"></i>
                Dashboard
            </a>

            <!-- TRANSAKSI -->
            <div>
                <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                    Transaksi
                </p>

                <div class="space-y-1">
                    <a href="{{ route('petugas.alat.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
                        {{ request()->is('petugas/alat*')
                            ? 'bg-primary-50 text-primary-700 font-medium'
                            : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-tools-line text-base"></i>
                        Daftar Alat
                    </a>

                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
                        {{ request()->is('petugas/peminjaman*')
                            ? 'bg-primary-50 text-primary-700 font-medium'
                            : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-archive-line text-base"></i>
                        Peminjaman
                    </a>
                </div>
            </div>

            <!-- LAPORAN -->
            <div>
                <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                    Laporan
                </p>

                <a href="{{ route('petugas.laporan-peminjaman') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg
                    {{ request()->is('petugas/laporan*')
                        ? 'bg-primary-50 text-primary-700 font-medium'
                        : 'text-text-secondary hover:bg-primary-50' }}">
                    <i class="ri-file-chart-line text-base"></i>
                    Laporan Peminjaman
                </a>
            </div>

        </nav>

        <!-- LOGOUT AREA -->
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

        <div class="bg-white rounded-2xl w-full max-w-sm p-6 animate-fade-in">
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
                    class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm
                           bg-danger text-white font-medium
                           hover:bg-red-700 transition">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- TOGGLE MOBILE -->
    <button class="fixed top-4 left-4 z-50 md:hidden p-2 bg-primary-600 text-white rounded-lg" id="sidebarToggle">
        <i class="ri-menu-line text-xl"></i>
    </button>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:ml-64">
        @yield('content')
    </main>

    <script>
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
