@if (session('success'))
    <div id="toast-success" role="alert" aria-live="assertive"
        class="fixed top-6 left-1/2 -translate-x-1/2 z-50 max-w-xs w-full">

        <div
            class="flex items-center gap-4 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm font-medium text-green-900
               animate-toast-in transition-all duration-300">

            <!-- Icon -->
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600">
                <i class="ri-checkbox-circle-fill text-lg"></i>
            </div>

            <!-- Text -->
            <span class="flex-1 truncate">
                {{ session('success') }}
            </span>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (!toast) return;

            toast.firstElementChild.classList.add('animate-toast-out');

            setTimeout(() => toast.remove(), 300);
        }, 3000);
    </script>

    <style>
        @keyframes toast-in {
            0% {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-toast-in {
            animation: toast-in 0.3s ease-out forwards;
        }

        @keyframes toast-out {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
        }

        .animate-toast-out {
            animation: toast-out 0.3s ease-in forwards;
        }
    </style>
@endif
