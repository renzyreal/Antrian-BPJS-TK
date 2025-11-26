@extends('layouts.admin')

@section('title', 'Edit Profil - Admin')
@section('header-title', 'Edit Profil')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold mb-2">Edit Profil Admin</h1>
                    <p class="text-green-100 opacity-90">Kelola informasi akun dan keamanan Anda</p>
                </div>
                <div class="mt-4 lg:mt-0 lg:ml-6">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[120px]">
                        <p class="text-sm font-medium">Update Profil</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-10">
            <i class="fas fa-user-cog text-8xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        <!-- Main Form (Tengah) -->
        <div class="flex flex-col">
            <!-- Success Message -->
            @if (session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-green-800">Berhasil!</p>
                        <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-emerald-50 border-l-4 border-red-500 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-red-800">Perhatian!</p>
                        <div class="text-sm text-red-700 mt-1">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Profile Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover flex-1">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                        <i class="fas fa-user-edit text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-800">Form Edit Profil</h2>
                        <p class="text-sm text-gray-600">Update informasi akun Anda</p>
                    </div>
                </div>

                <form action="{{ route('admin.profil.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('POST')

                    <!-- NAMA -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-user mr-2 text-green-500"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- USERNAME -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-at mr-2 text-fuchsia-500"></i>
                            Username
                        </label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                            placeholder="Masukkan username">
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PASSWORD BARU (OPSIONAL) -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-lock mr-2 text-rose-500"></i>
                            Password Baru
                            <span class="ml-2 text-xs text-gray-500 font-normal">(opsional)</span>
                        </label>
                        <input type="password" name="password_baru"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password_baru')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div id="password-strength" class="text-xs mt-1"></div>
                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                            Minimal 8 karakter dengan kombinasi huruf dan angka
                        </p>
                    </div>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-3 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                Konfirmasi Perubahan
                            </span>
                        </div>
                    </div>

                    <!-- Current Password for Security -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-key mr-2 text-pink-500"></i>
                            Password Saat Ini
                            <span class="ml-2 text-xs text-gray-500 font-normal">(wajib untuk konfirmasi)</span>
                        </label>
                        <input type="password" name="current_password" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                            placeholder="Masukkan password saat ini">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 font-semibold flex items-center justify-center group">
                        <i class="fas fa-save text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- User Profile (Kanan) -->
        <div class="flex flex-col space-y-6">
            <!-- User Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover flex-1">
                <div class="text-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4 shadow-lg">
                        {{ substr($user->nama, 0, 1) }}
                    </div>
                    <h3 class="font-semibold text-gray-800 text-xl mb-1">{{ $user->nama }}</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-user-shield mr-1"></i>Administrator
                    </span>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-plus text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Bergabung</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-sync-alt text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Terakhir Update</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->updated_at->translatedFormat('d M Y') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-600">Aktivitas</span>
                        </div>
                        <span class="text-xs font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover flex-1">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Aksi Cepat
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <i class="fas fa-tachometer-alt text-gray-400 mr-3 group-hover:text-blue-500"></i>
                        <span class="text-sm text-gray-700 flex-1">Dashboard</span>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500"></i>
                    </a>

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="w-full flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt text-red-400 mr-3 group-hover:text-red-500"></i>
                        <span class="text-sm text-red-700 flex-1">Logout</span>
                        <i class="fas fa-chevron-right text-red-400 group-hover:text-red-500"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-hover {
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
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

    /* Ensure equal height for main columns */
    .grid > div {
        display: flex;
        flex-direction: column;
    }

    .flex-1 {
        flex: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add loading animation for cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 100}ms`;
            card.classList.add('animate-fade-in-up');
        });

        // Add password strength indicator
        const passwordInput = document.querySelector('input[name="password_baru"]');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = document.getElementById('password-strength');
                
                let strength = 0;
                let message = '';
                let color = 'text-gray-500';
                let icon = 'fa-info-circle';
                
                if (password.length > 0) {
                    if (password.length < 8) {
                        strength = 1;
                        message = 'Password terlalu pendek';
                        color = 'text-red-500';
                        icon = 'fa-exclamation-circle';
                    } else if (password.length >= 8 && !/(?=.*[a-zA-Z])(?=.*[0-9])/.test(password)) {
                        strength = 2;
                        message = 'Gunakan kombinasi huruf dan angka';
                        color = 'text-yellow-500';
                        icon = 'fa-exclamation-triangle';
                    } else if (password.length >= 8 && /(?=.*[a-zA-Z])(?=.*[0-9])/.test(password)) {
                        strength = 3;
                        message = 'Password kuat';
                        color = 'text-green-500';
                        icon = 'fa-check-circle';
                    }
                    
                    strengthIndicator.innerHTML = `<span class="${color} flex items-center"><i class="fas ${icon} mr-1"></i> ${message}</span>`;
                } else {
                    strengthIndicator.innerHTML = '';
                }
            });
        }
    });
</script>
@endpush