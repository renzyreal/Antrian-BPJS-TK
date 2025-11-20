<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Antrian JKM')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">

            <h1 class="text-2xl font-bold">
                <i class="fas fa-tachometer-alt mr-2"></i>
                @yield('header-title', 'Admin Dashboard')
            </h1>

            <div class="flex items-center space-x-4">

                <!-- TANGGAL & JAM -->
                <div class="text-sm">
                    <span class="bg-blue-500 px-3 py-1 rounded-full">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} | 
                        <span id="live-clock" class="font-mono">{{ \Carbon\Carbon::now()->format('H:i:s') }}</span> WITA
                    </span>
                </div>

                <!-- PROFIL DROPDOWN -->
                <div class="relative">
                    <button onclick="toggleProfileMenu()" 
                            class="bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-user mr-2"></i> 
                        {{ Auth::user()->nama }}
                    </button>

                    <!-- MENU DROPDOWN -->
                    <div id="profile-menu" 
                        class="absolute right-0 mt-2 w-40 bg-white text-black rounded-lg shadow-lg hidden z-50">

                        <a href="{{ route('admin.edit') }}" 
                        class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-edit mr-2"></i> Edit Profil
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
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


        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex space-x-8 py-3">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="pb-3 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.antrian') }}" 
                       class="pb-3 transition-colors duration-200 {{ request()->routeIs('admin.antrian*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fas fa-list mr-2"></i>Data Antrian
                    </a>
                    <a href="{{ route('admin.kuota') }}" 
                       class="pb-3 transition-colors duration-200 {{ request()->routeIs('admin.kuota') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fas fa-chart-bar mr-2"></i>Kuota
                    </a>
                    <a href="{{ route('admin.export.form') }}" 
                        class="pb-3 transition-colors duration-200 {{ request()->routeIs('admin.export*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fas fa-download mr-2"></i>Export Data
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-semibold">Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside mt-2 ml-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-8">
            <div class="container mx-auto px-4 py-4">
                <div class="text-center text-gray-600 text-sm">
                    <p>&copy; {{ date('Y') }} Antrian JKM BPJS Ketenagakerjaan. All rights reserved. create by renzy and sappaso</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<script>
function toggleProfileMenu() {
    const menu = document.getElementById('profile-menu');
    menu.classList.toggle('hidden');
}

// Tutup dropdown jika klik di luar
document.addEventListener('click', function (e) {
    const menu = document.getElementById('profile-menu');
    const btn = e.target.closest('button');

    if (!menu.contains(e.target) && !btn) {
        menu.classList.add('hidden');
    }
});
</script>

</html>