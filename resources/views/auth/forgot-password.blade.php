<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lupa Kata Sandi | Equiply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/favicon-equily.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/favicon-equiply.svg') }}" type="image/x-icon">

    <!-- Google Font -->
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
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-text-primary">
                Lupa Kata Sandi?
            </h1>
            <p class="mt-2 text-sm text-text-secondary">
                Masukkan email Anda untuk menerima link reset password
            </p>
        </div>

        @if (session('status'))
            <div
                class="mb-5 rounded-xl border border-green-200
               bg-green-50 px-4 py-3
               text-sm text-green-700">
                @if (session('status') === 'We have emailed your password reset link.')
                    <i class="ri-check-double-line mr-1"></i>
                    Link reset berhasil dikirim.
                @else
                    {{ session('status') }}
                @endif
            </div>
        @endif


        <!-- ERROR -->
        @if ($errors->has('email'))
            <div
                class="mb-5 rounded-xl border border-danger/20
               bg-danger/10 px-4 py-3
               text-sm text-danger flex gap-2">
                <i class="ri-error-warning-line mt-0.5"></i>
                <span>Email tidak valid atau tidak terdaftar.</span>
            </div>
        @endif


        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                        placeholder="email@contoh.com"
                        class="w-full rounded-xl border border-border
                               pl-11 pr-4 py-2.5 text-sm
                               focus:outline-none
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500 transition">
                </div>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full rounded-xl py-3
           bg-primary-600 text-white font-semibold
           hover:bg-primary-700
           active:scale-[0.98]
           transition-all duration-200
           flex items-center justify-center gap-2">

                <i id="sendIcon" class="ri-mail-send-line"></i>

                <svg id="loadingSpinner" class="hidden w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <span id="btnText">Kirim Link Reset</span>
            </button>


            <!-- Back to login -->
            <a href="{{ route('login') }}"
                class="block text-center text-sm
                       text-primary-600 hover:text-primary-700 font-medium">
                ← Kembali ke Login
            </a>
        </form>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs text-text-muted">
            © {{ date('Y') }} Equiply — Sistem Peminjaman Alat
        </p>
    </div>

    <script>
        const form = document.querySelector('form');
        const btn = document.getElementById('submitBtn');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('loadingSpinner');
        const icon = document.getElementById('sendIcon');

        form.addEventListener('submit', () => {
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');

            text.textContent = 'Mengirim...';
            spinner.classList.remove('hidden');
            icon.classList.add('hidden');
        });
    </script>


</body>

</html>
