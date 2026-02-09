<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar | Equiply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/favicon-equily.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/favicon-equiply.svg') }}" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen flex items-center justify-center px-4 font-sans
             bg-gradient-to-br from-background via-primary-50 to-background">

    <div class="w-full max-w-md bg-surface rounded-2xl p-8 border border-border shadow-soft">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/logo-web.png') }}" class="h-14 select-none">
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold">Buat Akun Baru</h1>
            <p class="text-sm text-text-secondary mt-2">
                Daftar untuk mulai menggunakan Equiply
            </p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Nama -->
            <div>
                <label class="text-sm font-medium block mb-1">Nama Lengkap</label>

                <div class="relative">
                    <!-- Icon kiri -->
                    <i
                        class="ri-user-line absolute left-4 top-1/2
                  -translate-y-1/2 text-text-muted"></i>

                    <!-- Input -->
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                        class="w-full rounded-xl border border-border
                   pl-11 pr-4 py-2.5 text-sm
                   focus:ring-2 focus:ring-primary-500
                   focus:border-primary-500">
                </div>

                @error('name')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>


            <!-- Email -->
            <div>
                <label class="text-sm font-medium block mb-1">Email</label>

                <div class="relative">
                    <i
                        class="ri-mail-line absolute left-4 top-1/2
                  -translate-y-1/2 text-text-muted"></i>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                        class="w-full rounded-xl border border-border
                   pl-11 pr-4 py-2.5 text-sm
                   focus:ring-2 focus:ring-primary-500
                   focus:border-primary-500">
                </div>

                @error('email')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>


            <!-- Password -->
            <div>
                <label class="text-sm font-medium block mb-1">Kata Sandi</label>

                <div class="relative">
                    <!-- Icon kiri -->
                    <i
                        class="ri-lock-line absolute left-4 top-1/2
                  -translate-y-1/2 text-text-muted"></i>

                    <!-- Input -->
                    <input id="password" type="password" name="password" placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border border-border
                   pl-11 pr-11 py-2.5 text-sm
                   focus:ring-2 focus:ring-primary-500
                   focus:border-primary-500">

                    <!-- Toggle -->
                    <button type="button" onclick="toggle('password','eye1')"
                        class="absolute right-4 top-1/2 -translate-y-1/2
                   text-text-muted hover:text-text-primary z-10">
                        <i id="eye1" class="ri-eye-line text-lg"></i>
                    </button>
                </div>

                @error('password')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>


            <!-- Confirm Password -->
            <div>
                <label class="text-sm font-medium block mb-1">Konfirmasi Kata Sandi</label>

                <div class="relative">
                    <i
                        class="ri-shield-keyhole-line absolute left-4 top-1/2
                  -translate-y-1/2 text-text-muted"></i>

                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Ulangi kata sandi"
                        class="w-full rounded-xl border border-border
                   pl-11 pr-11 py-2.5 text-sm
                   focus:ring-2 focus:ring-primary-500
                   focus:border-primary-500">

                    <button type="button" onclick="toggle('password_confirmation','eye2')"
                        class="absolute right-4 top-1/2 -translate-y-1/2
                   text-text-muted hover:text-text-primary z-10">
                        <i id="eye2" class="ri-eye-line text-lg"></i>
                    </button>
                </div>

                @error('password_confirmation')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>


            <!-- Submit -->
            <button
                class="w-full bg-primary-600 text-white py-3 rounded-xl font-semibold
                           hover:bg-primary-700 transition">
                Daftar
            </button>

            <p class="text-center text-sm text-text-secondary">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary-600 font-medium">Masuk</a>
            </p>
        </form>

        <p class="text-xs text-center text-text-muted mt-8">
            © {{ date('Y') }} Equiply — Sistem Peminjaman Alat
        </p>
    </div>

    <!-- JS -->
    <script>
        function toggle(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

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
