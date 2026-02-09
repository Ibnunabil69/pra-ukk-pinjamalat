<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard') | Equiply</title>

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

        <!-- LOGO & ROLE -->
        <div class="px-6 pb-4 border-b border-border">

            <!-- Logo -->
            <img src="{{ asset('assets/logo-web.png') }}" alt="Equiply"
                class="h-20 max-w-[200px] object-contain select-none">

            <!-- Role Info -->
            <div class="mt-2 flex items-center gap-2 text-xs text-text-muted">
                <span
                    class="inline-flex items-center justify-center
                           w-7 h-7 rounded-full
                           bg-primary-50 text-primary-600">
                    <i class="ri-user-line text-sm"></i>
                </span>

                <span class="leading-tight">
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
                class="group flex items-center gap-3 px-3 py-2 rounded-lg
       {{ request()->is('dashboard*')
           ? 'bg-primary-50 text-primary-700 font-medium border-primary-500'
           : 'text-text-secondary hover:bg-primary-50' }}">
                <i class="ri-dashboard-line text-base"></i>
                Dashboard
            </a>

            <!-- MASTER DATA -->
            <div>
                <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                    Master Data
                </p>

                <div class="space-y-1">
                    <a href="{{ route('admin.alat.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
            {{ request()->is('admin/alat*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-tools-line text-base"></i>
                        Data Alat
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
            {{ request()->is('admin/kategori*') ? 'bg-primary-50 text-primary-700 font-medium' : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-price-tag-3-line text-base"></i>
                        Kategori
                    </a>
                </div>
            </div>

            <!-- TRANSAKSI -->
            <div>
                <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                    Transaksi
                </p>

                <div class="space-y-1">
                    <a href="/peminjaman"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->is('peminjaman*')
                   ? 'bg-primary-50 text-primary-700 font-medium'
                   : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-arrow-left-right-line text-base"></i>
                        Data Peminjaman
                    </a>

                    <a href="/pengembalian"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg
               {{ request()->is('pengembalian*')
                   ? 'bg-primary-50 text-primary-700 font-medium'
                   : 'text-text-secondary hover:bg-primary-50' }}">
                        <i class="ri-refresh-line text-base"></i>
                        Pengembalian
                    </a>
                </div>
            </div>

            <!-- ADMIN -->
            <div>
                <p class="px-3 mb-1 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
                    Administrator
                </p>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg
          {{ request()->is('admin/users*')
              ? 'bg-primary-50 text-primary-700 font-medium'
              : 'text-text-secondary hover:bg-primary-50' }}">
                    <i class="ri-group-line text-base"></i>
                    Manajemen User
                </a>

                <a href="/logaktivitas"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg
   {{ request()->is('logaktivitas*')
       ? 'bg-primary-50 text-primary-700 font-medium'
       : 'text-text-secondary hover:bg-primary-50' }}">
                    <i class="ri-file-list-3-line text-base"></i>
                    Log Aktivitas
                </a>

            </div>

        </nav>


        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-border">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2
                           rounded-xl py-2.5
                           bg-danger text-white font-medium
                           hover:bg-red-700 transition">
                <i class="ri-logout-box-r-line"></i>
                Logout
            </button>
        </form>

    </aside>
    <button class="fixed top-4 left-4 z-50 md:hidden p-2 bg-primary-600 text-white rounded-lg" id="sidebarToggle">
        <i class="ri-menu-line text-xl"></i>
    </button>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:ml-64">
        @yield('content')
    </main>

</body>


</html>
