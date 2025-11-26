<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Antrian JKM')</title>
    <link rel="icon" href="{{ asset('assets/icon-bpjstk.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-indicator {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #53ec53);
            transition: all 0.3s ease;
            border-radius: 3px 3px 0 0;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #4f46e5 0%, #7c3aed 100%);
        }
        
        /* Mobile Menu Styles */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        /* Responsive table */
        .responsive-table {
            overflow-x: auto;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-xl">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-2 rounded-xl">
                            <i class="fas fa-tachometer-alt text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold">
                                @yield('header-title', 'Admin Dashboard')
                            </h1>
                            <p class="text-green-100 text-xs md:text-sm">Sistem Antrian JKM BPJS Ketenagakerjaan</p>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="md:hidden bg-white/20 p-2 rounded-xl">
                        <i class="fas fa-bars text-lg"></i>
                    </button>

                    <div class="hidden md:flex items-center space-x-6">
                        <!-- TANGGAL & JAM -->
                        <div class="glass-effect px-4 py-1 rounded-xl flex items-center space-x-3">
                            <i class="far fa-clock"></i>
                            <div class="text-sm">
                                <div class="hidden lg:block">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>
                                <div class="lg:hidden">{{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>
                                <div class="font-mono text-green-100" id="live-clock">{{ \Carbon\Carbon::now()->format('H:i:s') }} WITA</div>
                            </div>
                        </div>

                        <!-- PROFIL DROPDOWN -->
                        <div class="relative">
                            <button onclick="toggleProfileMenu()" 
                                    class="glass-effect hover:bg-white/20 px-4 py-2 rounded-xl flex items-center space-x-2 transition-all duration-300">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span class="font-medium hidden lg:inline">{{ Auth::user()->nama }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="profile-arrow"></i>
                            </button>

                            <!-- MENU DROPDOWN -->
                            <div id="profile-menu" 
                                class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-xl shadow-xl hidden z-50 overflow-hidden border border-gray-200">
                                <a href="{{ route('admin.profil.edit') }}" 
                                class="flex items-center px-4 py-3 hover:bg-green-50 transition-colors duration-200 border-b border-gray-100">
                                    <i class="fas fa-edit mr-3 text-green-500"></i> 
                                    <span>Edit Profil</span>
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left flex items-center px-4 py-3 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i> 
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @hasSection('header-button')
                            @yield('header-button')
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed h-full w-72 z-50 bg-white backdrop-blur-md md:hidden">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Menu</h2>
                <button id="close-mobile-menu" class="p-2 rounded-lg bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4">
                <!-- Mobile Profile Info -->
                <div class="flex items-center space-x-3 mb-6 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ Auth::user()->nama }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-home mr-3 w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.antrian') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.antrian*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-list mr-3 w-5 text-center"></i>
                        <span>Data Antrian</span>
                    </a>
                    
                    <a href="{{ route('admin.kuota') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.kuota') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-chart-bar mr-3 w-5 text-center"></i>
                        <span>Kuota</span>
                    </a>

                    <a href="{{ route('admin.tanggal.index') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.tanggal.index') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-calendar mr-3 w-5 text-center"></i>
                        <span>Set Tanggal</span>
                    </a>
                    
                    <a href="{{ route('admin.export.form') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.export*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-download mr-3 w-5 text-center"></i>
                        <span>Export Data</span>
                    </a>

                    <!-- QR Code Mobile Menu -->
                    <a href="{{ route('admin.qr') }}" 
                       class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.qr*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-qrcode mr-3 w-5 text-center"></i>
                        <span>QR Code</span>
                    </a>
                </div>
                
                <!-- Mobile Date & Time -->
                <div class="mt-6 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-2 mb-1">
                        <i class="far fa-clock text-gray-500"></i>
                        <span class="text-sm font-medium">Tanggal & Waktu</span>
                    </div>
                    <div class="text-sm">
                        <div>{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>
                        <div class="font-mono text-gray-700" id="mobile-live-clock">{{ \Carbon\Carbon::now()->format('H:i:s') }} WITA</div>
                    </div>
                </div>
                
                <!-- Mobile Actions -->
                <div class="mt-6 space-y-2">
                    <a href="{{ route('admin.profil.edit') }}" 
                       class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-edit mr-3 w-5 text-center text-green-500"></i>
                        <span>Edit Profil</span>
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center p-3 rounded-lg text-gray-700 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-3 w-5 text-center text-red-500"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="bg-white shadow-md hidden md:block">
            <div class="container mx-auto px-4">
                <div class="flex space-x-1 py-1 relative custom-scrollbar overflow-x-auto">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                    <a href="{{ route('admin.antrian') }}" 
                       class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.antrian*') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-list mr-2"></i>Data Antrian
                        @if(request()->routeIs('admin.antrian*'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                    <a href="{{ route('admin.kuota') }}" 
                       class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.kuota') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-chart-bar mr-2"></i>Kuota
                        @if(request()->routeIs('admin.kuota'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                    <a href="{{ route('admin.tanggal.index') }}" 
                       class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.tanggal.index') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-calendar mr-2"></i>Set Tanggal
                        @if(request()->routeIs('admin.tanggal.index'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                    <a href="{{ route('admin.export.form') }}" 
                        class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.export*') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-download mr-2"></i>Export Data
                        @if(request()->routeIs('admin.export*'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                    <!-- QR Code Navigation -->
                    <a href="{{ route('admin.qr') }}" 
                       class="relative px-4 lg:px-6 py-3 transition-all duration-300 rounded-t-lg whitespace-nowrap {{ request()->routeIs('admin.qr*') ? 'text-green-600 font-semibold bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                        <i class="fas fa-qrcode mr-2"></i>QR Code
                        @if(request()->routeIs('admin.qr*'))
                            <div class="nav-indicator w-full"></div>
                        @endif
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto p-4">
            <!-- Flash Messages -->
            <div class="mb-6 space-y-4">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-700 font-medium">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside mt-1 ml-2 text-red-600">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-8">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-600 text-sm mb-4 md:mb-0 text-center md:text-left">
                        <p>&copy; {{ date('Y') }} Antrian JKM BPJS Ketenagakerjaan. All rights reserved.</p>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <span>Created by renzy and sappaso</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds} WITA`;
        document.getElementById('mobile-live-clock').textContent = `${hours}:${minutes}:${seconds} WITA`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Profile Menu Toggle
    function toggleProfileMenu() {
        const menu = document.getElementById('profile-menu');
        const arrow = document.getElementById('profile-arrow');
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    // Mobile Menu Toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.add('open');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.remove('open');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (e) {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        
        // Close profile menu if clicking outside
        const profileMenu = document.getElementById('profile-menu');
        const profileBtn = e.target.closest('button');
        
        if (!profileMenu.contains(e.target) && !profileBtn) {
            profileMenu.classList.add('hidden');
            document.getElementById('profile-arrow').classList.remove('rotate-180');
        }
        
        // Close mobile menu if clicking outside
        if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target) && mobileMenu.classList.contains('open')) {
            mobileMenu.classList.remove('open');
        }
    });
</script>
</html>