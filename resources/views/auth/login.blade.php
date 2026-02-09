<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Equiply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/favicon-equily.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/favicon-equiply.svg') }}" type="image/x-icon">


    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex items-center justify-center px-4 font-sans
           bg-gradient-to-br from-background via-primary-50 to-background">

    <!-- Card -->
    <div class="w-full max-w-md bg-surface rounded-2xl p-8
               border border-border shadow-soft">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/logo-web.png') }}" alt="Equiply" class="h-16 select-none">
        </div>

        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-semibold text-text-primary">
                Selamat Datang
            </h1>
            <p class="mt-2 text-sm text-text-secondary">
                Masuk ke sistem peminjaman alat
            </p>
        </div>

        <!-- GLOBAL ERROR (LOGIN GAGAL) -->
        @if ($errors->has('email'))
            <div
                class="mb-5 rounded-xl border border-danger/20
                       bg-danger/10 px-4 py-3
                       text-sm text-danger
                       flex items-start gap-2">
                <i class="ri-error-warning-line mt-0.5"></i>
                <span>Email atau kata sandi salah.</span>
            </div>
        @endif

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-5 rounded-xl bg-emerald-50
               text-success text-sm px-4 py-3">
                {{ session('status') === 'Your password has been reset.'
                    ? 'Password Anda telah berhasil direset.'
                    : session('status') }}
            </div>
        @endif


        @if (session('success'))
            <div id="toast-success"
                class="fixed top-6 left-1/2 -translate-x-1/2 z-50
               flex items-center gap-3
               rounded-xl border border-green-200
               bg-green-50 px-5 py-3 text-sm
               text-green-700 shadow-lg
               animate-slide-down">

                <i class="ri-checkbox-circle-line text-lg"></i>

                <span>{{ session('success') }}</span>
            </div>

            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) toast.remove();
                }, 3500);
            </script>
        @endif



        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-text-primary mb-1">
                    Email
                </label>

                <div class="relative">
                    <i
                        class="ri-mail-line absolute left-4 top-1/2
                               -translate-y-1/2 text-text-muted"></i>

                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="email@contoh.com"
                        class="w-full rounded-xl border border-border
                               pl-11 pr-4 py-2.5 text-sm
                               focus:outline-none
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500 transition">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-text-primary mb-1">
                    Kata Sandi
                </label>

                <div class="relative">
                    <!-- Left icon -->
                    <i
                        class="ri-lock-line absolute left-4 top-1/2
                               -translate-y-1/2 text-text-muted"></i>

                    <!-- Input -->
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-border
                               pl-11 pr-11 py-2.5 text-sm
                               focus:outline-none
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500 transition">

                    <!-- Toggle -->
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-4 top-1/2
                               -translate-y-1/2
                               text-text-muted
                               hover:text-primary-600 transition">
                        <i id="eye-icon" class="ri-eye-line"></i>
                    </button>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-text-secondary">
                    <input type="checkbox" name="remember"
                        class="rounded border-border
                                  text-primary-600
                                  focus:ring-primary-500">
                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-primary-600
                              hover:text-primary-700 font-medium">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full rounded-xl py-3
                       bg-primary-600 text-white font-semibold
                       hover:bg-primary-700
                       active:scale-[0.98]
                       transition-all duration-200">
                <i class="ri-login-box-line mr-1"></i>
                Masuk
            </button>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="h-px bg-border"></div>
                <span
                    class="absolute left-1/2 -translate-x-1/2 -top-2
                           bg-surface px-3
                           text-xs text-text-muted">
                    atau
                </span>
            </div>

            <!-- Register -->
            <a href="{{ route('register') }}"
                class="w-full flex items-center justify-center gap-2
                       rounded-xl py-3
                       border border-border
                       text-text-primary font-medium
                       hover:bg-primary-50
                       hover:border-primary-200
                       transition">
                <i class="ri-user-add-line"></i>
                Daftar Akun Baru
            </a>
        </form>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs text-text-muted">
            © {{ date('Y') }} Equiply — Sistem Peminjaman Alat
        </p>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
            } else {
                input.type = 'password';
                icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
            }
        }
    </script>

</body>

</html>
