<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Kata Sandi | Equiply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    .input-password {
        position: relative;
    }

    .input-password input {
        padding-right: 40px;
        /* beri space buat icon */
        height: 40px;
        /* sesuaikan dengan icon */
    }

    .input-password .toggle-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        /* ini bikin icon vertikal center */
        cursor: pointer;
    }

    /* Tailwind custom colors */
    .border-danger {
        border-color: #f87171;
        /* merah */
    }

    .text-danger {
        color: #f87171;
        /* merah */
    }
</style>

<body
    class="min-h-screen flex items-center justify-center px-4 font-sans bg-gradient-to-br from-background via-primary-50 to-background">

    <div class="w-full max-w-md bg-surface rounded-2xl p-8 border border-border shadow-soft">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/logo-web.png') }}" alt="Equiply" class="h-16 select-none">
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-semibold text-text-primary">Reset Kata Sandi</h1>
            <p class="mt-2 text-sm text-text-secondary">
                Masukkan password baru Anda.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div id="toast-success"
                class="fixed top-6 left-1/2 -translate-x-1/2 z-50
                flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-3 text-base text-green-700 shadow-lg animate-slide-down">
                <i class="ri-checkbox-circle-line text-2xl"></i>
                <span>{{ session('status') }}</span>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) toast.remove();
                }, 3500);
            </script>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.store') }}" class="space-y-5" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-text-primary mb-1">Email</label>
                <div class="relative">
                    <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                    <input id="email" name="email" type="email" required
                        value="{{ old('email', $request->email) }}" placeholder="email@contoh.com" readonly
                        class="w-full rounded-xl border border-border pl-11 pr-4 py-2.5 text-sm bg-gray-100 cursor-not-allowed focus:outline-none transition">
                </div>
                @error('email')
                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-text-primary mb-1">Password Baru</label>
                <div class="relative">
                    <i class="ri-lock-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                    <input id="password" name="password" type="password" required minlength="8"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border border-border pl-11 pr-11 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <i id="togglePassword"
                        class="ri-eye-line absolute right-4 top-1/2 -translate-y-1/2 text-text-muted cursor-pointer"></i>
                </div>
                <div id="password-error" class="mt-1 text-xs text-danger"></div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-text-primary mb-1">Konfirmasi
                    Password</label>
                <div class="relative">
                    <i class="ri-shield-keyhole-line absolute left-4 top-1/2 -translate-y-1/2 text-text-muted"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        minlength="8" placeholder="Ulangi password"
                        class="w-full rounded-xl border border-border pl-11 pr-11 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <i id="togglePasswordConfirmation"
                        class="ri-eye-line absolute right-4 top-1/2 -translate-y-1/2 text-text-muted cursor-pointer"></i>
                </div>
                <div id="password_confirmation-error" class="mt-1 text-xs text-danger"></div>
            </div>


            <button type="submit"
                class="w-full rounded-xl py-3 bg-primary-600 text-white font-semibold hover:bg-primary-700 active:scale-[0.98] transition-all duration-200">
                Reset Password
            </button>

            <p class="text-center text-sm text-text-secondary mt-4">
                <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:text-primary-700">Kembali ke
                    Login</a>
            </p>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            const passwordConfirmation = document.getElementById('password_confirmation');
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');

            // Toggle password visibility
            togglePassword.addEventListener('click', () => {
                const type = password.type === 'password' ? 'text' : 'password';
                password.type = type;
                togglePassword.classList.toggle('ri-eye-line');
                togglePassword.classList.toggle('ri-eye-off-line');
            });

            togglePasswordConfirmation.addEventListener('click', () => {
                const type = passwordConfirmation.type === 'password' ? 'text' : 'password';
                passwordConfirmation.type = type;
                togglePasswordConfirmation.classList.toggle('ri-eye-line');
                togglePasswordConfirmation.classList.toggle('ri-eye-off-line');
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const pw = document.getElementById('password');
                const pwConfirm = document.getElementById('password_confirmation');

                // reset error
                pw.classList.remove('border-danger');
                pwConfirm.classList.remove('border-danger');
                document.getElementById('password-error').innerText = '';
                document.getElementById('password_confirmation-error').innerText = '';

                let valid = true;

                if (pw.value.length < 8) {
                    pw.classList.add('border-danger');
                    document.getElementById('password-error').innerText =
                        'Password harus minimal 8 karakter!';
                    valid = false;
                }

                if (pw.value !== pwConfirm.value) {
                    pwConfirm.classList.add('border-danger');
                    document.getElementById('password_confirmation-error').innerText =
                        'Konfirmasi password tidak sama!';
                    valid = false;
                }

                if (valid) form.submit();
            });

        });
    </script>

</body>

</html>
