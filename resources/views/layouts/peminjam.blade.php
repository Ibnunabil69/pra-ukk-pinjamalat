<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') | Equiply</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        <!-- LOGO -->
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

        <!-- MENU -->
        <nav class="flex-1 px-3 py-4 text-sm space-y-6">

            <!-- DASHBOARD -->
            <a href="/dashboard"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
            {{ request()->is('dashboard*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                <i class="ri-dashboard-line text-base"></i>
                Dashboard
            </a>

            @if (auth()->user()->role === 'peminjam')
                <div>
                    <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                        Peminjaman
                    </p>

                    <!-- Daftar Alat -->
                    <a href="/peminjam/alat"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ request()->is('peminjam/alat*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-tools-line text-base"></i>
                        Daftar Alat
                    </a>

                    <!-- Riwayat -->
                    <a href="/peminjam/riwayat"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ request()->is('peminjam/riwayat*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-history-line text-base"></i>
                        Riwayat Peminjaman
                    </a>

                    <!-- Pengembalian -->
                    <a href="/peminjam/pengembalian"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ request()->is('peminjam/pengembalian*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-refresh-line text-base"></i>
                        Pengembalian Alat
                    </a>
                </div>
            @endif

        </nav>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-border">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 rounded-xl py-2.5 bg-danger text-white hover:bg-red-700">
                <i class="ri-logout-box-r-line"></i>
                Logout
            </button>
        </form>

    </aside>


    <!-- CONTENT -->
    <main class="flex-1 p-8 md:ml-64">
        @yield('content')
    </main>

</body>

</html>
