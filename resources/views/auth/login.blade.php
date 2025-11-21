<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Antrian BPJS Ketenagakerjaan</title>
    
    <!-- TAILWINDCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.5);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .gradient-bg:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
        }
        
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            border-color: #10b981;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .login-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
        
        @media (min-width: 641px) and (max-width: 1024px) {
            .login-container {
                max-width: 28rem;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -left-20 w-40 h-40 bg-pink-200 rounded-full opacity-20 floating-element"></div>
        <div class="absolute top-1/3 -right-16 w-32 h-32 bg-blue-200 rounded-full opacity-20 floating-element" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-rose-200 rounded-full opacity-20 floating-element" style="animation-delay: 4s;"></div>
    </div>

    <div class="login-container w-full max-w-md rounded-2xl p-6 sm:p-8 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-8">
            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets/icon-jkm.png') }}" alt="JKM Icon" class="w-15 h-15">
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-pink-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">
                Sistem Antrian JKM <br>BPJS Ketenagakerjaan
            </h1>
            <p class="text-sm text-gray-600">
                Masuk ke akun administrator Anda
            </p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4 sm:mb-6 flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3 flex-shrink-0"></i>
                <div>
                    <p class="text-red-700 font-medium text-sm">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.process') }}" method="POST" class="space-y-4 sm:space-y-6">
            @csrf

            <!-- Username Field -->
            <div class="space-y-2">
                <label class="font-medium text-gray-700 text-sm">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="username" required
                           class="w-full border border-gray-300 rounded-xl px-3 py-3 pl-10 input-focus transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20"
                           placeholder="Masukkan username Anda">
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label class="font-medium text-gray-700 text-sm">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded-xl px-3 py-3 pl-10 input-focus transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20"
                           placeholder="Masukkan password Anda">
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-gradient-to-br from-pink-500 to-rose-600 text-white font-semibold py-3 sm:py-3.5 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg flex items-center justify-center space-x-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk ke Sistem</span>
            </button>
        </form>

        <!-- Additional Info -->
        <div class="mt-6 sm:mt-8 text-center">
            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500 mb-4">
                <div class="flex items-center space-x-1">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    <span>Cepat & Responsif</span>
                </div>
            </div>
            
            <!-- Footer -->
            <p class="text-xs text-gray-500 border-t border-gray-200 pt-4">
                © {{ date('Y') }} BPJS Ketenagakerjaan — Sistem Antrian Digital
                <br>
                <span class="text-[10px] mt-1 block">v1.0</span>
            </p>
        </div>
    </div>

    <!-- Loading Animation (hidden by default) -->
    <div id="loading" class="fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center hidden z-50">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-pink-200 border-t-pink-500 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600 font-medium">Memproses login...</p>
        </div>
    </div>

    <script>
        // Form submission loading animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const loading = document.getElementById('loading');
            loading.classList.remove('hidden');
            
            // Optional: Add a timeout to handle very fast responses
            setTimeout(() => {
                if (loading.classList.contains('hidden')) return;
                loading.querySelector('p').textContent = 'Sedang memverifikasi...';
            }, 2000);
        });

        // Add input focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-pink-500/20');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-pink-500/20');
            });
        });

        // Handle page load animations
        window.addEventListener('load', function() {
            document.querySelector('.login-container').classList.add('animate-fade-in');
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>