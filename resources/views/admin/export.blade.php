@extends('layouts.admin')

@section('title', 'Export Data - Admin')
@section('header-title', 'Export Data')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Export Data Antrian</h1>
                    <p class="text-green-100 opacity-90">Download data antrian dalam format Excel untuk analisis dan backup</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                        <p class="text-sm font-medium">Format Excel</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-10">
            <i class="fas fa-download text-8xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Export Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600 mr-4">
                    <i class="fas fa-filter text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Export dengan Filter</h2>
                    <p class="text-sm text-gray-600">Ekspor data berdasarkan rentang waktu spesifik</p>
                </div>
            </div>
            
            <form action="{{ route('admin.export.download') }}" method="GET" class="space-y-6">
                <!-- Filter Tanggal -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar-day mr-2 text-pink-500"></i>
                                Tanggal Mulai
                            </label>
                            <input type="date" name="start_date" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                   value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar-day mr-2 text-fuchsia-500"></i>
                                Tanggal Akhir
                            </label>
                            <input type="date" name="end_date" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition-all duration-200"
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-3 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-arrows-alt-h mr-2"></i>
                                ATAU
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-500"></i>
                            Tanggal Tertentu
                        </label>
                        <input type="date" name="tanggal" 
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200"
                               value="{{ request('tanggal') }}">
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 font-medium">Tips Export</p>
                            <p class="text-sm text-blue-600 mt-1">
                                Kosongkan semua field untuk export semua data. Hanya gunakan satu jenis filter untuk hasil terbaik.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 font-semibold flex items-center justify-center group">
                        <i class="fas fa-file-excel text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Export ke Excel</span>
                    </button>
                    <a href="{{ route('admin.export.form') }}" 
                       class="w-full bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-4 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 font-semibold flex items-center justify-center group">
                        <i class="fas fa-refresh mr-3 group-hover:rotate-180 transition-transform duration-200"></i>
                        <span>Reset Form</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Quick Export -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600 mr-4">
                    <i class="fas fa-bolt text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Export Cepat</h2>
                    <p class="text-sm text-gray-600">Akses cepat untuk data yang sering di-export</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Today -->
                <a href="{{ route('admin.export.download') }}?filter=today" 
                   class="group bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-500 rounded-xl p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 block">
                    <div class="flex items-start justify-between mb-3">
                        <div class="p-3 rounded-xl bg-blue-500 text-white group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-calendar-day text-lg"></i>
                        </div>
                        <span class="text-xs font-medium bg-blue-200 text-blue-800 px-2 py-1 rounded-full">
                            Latest
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Hari Ini</h3>
                    <p class="text-sm text-gray-600">Export data antrian hari ini</p>
                    <div class="mt-3 flex items-center text-xs text-blue-600 font-medium">
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </div>
                </a>

                <!-- Last 7 Days -->
                <a href="{{ route('admin.export.download') }}?filter=week" 
                   class="group bg-gradient-to-br from-pink-50 to-pink-100 border-l-4 border-pink-500 rounded-xl p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 block">
                    <div class="flex items-start justify-between mb-3">
                        <div class="p-3 rounded-xl bg-pink-500 text-white group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-calendar-week text-lg"></i>
                        </div>
                        <span class="text-xs font-medium bg-pink-200 text-pink-800 px-2 py-1 rounded-full">
                            7 Days
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">7 Hari Terakhir</h3>
                    <p class="text-sm text-gray-600">Export data seminggu terakhir</p>
                    <div class="mt-3 flex items-center text-xs text-pink-600 font-medium">
                        <span>Minggu ini</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </div>
                </a>

                <!-- All Data -->
                <a href="{{ route('admin.export.download') }}" 
                   class="group bg-gradient-to-br from-purple-50 to-purple-100 border-l-4 border-purple-500 rounded-xl p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 block">
                    <div class="flex items-start justify-between mb-3">
                        <div class="p-3 rounded-xl bg-purple-500 text-white group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-database text-lg"></i>
                        </div>
                        <span class="text-xs font-medium bg-purple-200 text-purple-800 px-2 py-1 rounded-full">
                            Complete
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Semua Data</h3>
                    <p class="text-sm text-gray-600">Export semua data antrian</p>
                    <div class="mt-3 flex items-center text-xs text-purple-600 font-medium">
                        <span>Database lengkap</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </div>
                </a>

                <!-- Tomorrow -->
                <a href="{{ route('admin.export.download') }}?filter=tomorrow" 
                   class="group bg-gradient-to-br from-green-50 to-green-100 border-l-4 border-green-500 rounded-xl p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 block">
                    <div class="flex items-start justify-between mb-3">
                        <div class="p-3 rounded-xl bg-green-500 text-white group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-calendar-alt text-lg"></i>
                        </div>
                        <span class="text-xs font-medium bg-green-200 text-green-800 px-2 py-1 rounded-full">
                            Upcoming
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Besok</h3>
                    <p class="text-sm text-gray-600">Export data antrian besok</p>
                    <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                        <span>{{ \Carbon\Carbon::tomorrow()->translatedFormat('d M Y') }}</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </div>
                </a>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-clock text-gray-400 mr-3"></i>
                    <div>
                        <p class="font-medium">File akan didownload otomatis</p>
                        <p class="text-xs mt-1">Format file: Excel (.xlsx) dengan timestamp</p>
                    </div>
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
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        // Add form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const specificDate = document.querySelector('input[name="tanggal"]').value;
            
            // Count how many filters are filled
            let filledCount = 0;
            if (startDate) filledCount++;
            if (endDate) filledCount++;
            if (specificDate) filledCount++;
            
            if (filledCount > 1) {
                e.preventDefault();
                alert('Hanya boleh menggunakan satu jenis filter. Pilih rentang tanggal ATAU tanggal tertentu.');
            }
        });
    });
</script>
@endpush