@extends('layouts.admin')

@section('title', 'Monitoring Kuota - Admin')
@section('header-title', 'Monitoring Kuota')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Monitoring Kuota Antrian</h1>
                    <p class="text-green-100 opacity-90">Pantau ketersediaan kuota per blok waktu</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                        <p class="text-sm font-medium">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, j F Y') }}</p>
                        <p class="text-xs text-green-100">Tanggal dipantau</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-10">
            <i class="fas fa-chart-pie text-8xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <!-- Filter Tanggal -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 card-hover">
        <form action="{{ route('admin.kuota') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-calendar-day mr-2 text-green-500"></i>
                    Pilih Tanggal Monitoring
                </label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" 
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                    <i class="fas fa-filter mr-2"></i>Terapkan
                </button>
                <a href="{{ route('admin.kuota') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                    <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <!-- Total Kuota -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-blue-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-blue-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shadow-sm">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Total Kuota</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalKuota }}</p>
                        <span class="text-sm font-semibold text-blue-600">100%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" 
                             style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Kapasitas Maksimal</span>
                        <span>{{ $totalKuota }} slot</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terisi -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-fuchsia-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-fuchsia-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-fuchsia-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 shadow-sm">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Terisi</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTerisi }}</p>
                        <span class="text-sm font-semibold 
                            {{ $totalTerisi >= 12 ? 'text-red-600' : ($totalTerisi >= 8 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ number_format(($totalTerisi / $totalKuota) * 100, 0) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-fuchsia-500 to-fuchsia-600 h-2 rounded-full transition-all duration-500" 
                             style="width: {{ ($totalTerisi / $totalKuota) * 100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Telah terdaftar</span>
                        <span>{{ $totalTerisi }} orang</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full 
                    {{ $totalTerisi >= 12 ? 'bg-red-400 animate-pulse' : ($totalTerisi >= 8 ? 'bg-yellow-400' : 'bg-green-400') }}">
                </div>
            </div>
        </div>

        <!-- Tersisa -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-green-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Tersisa</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTersisa }}</p>
                        <span class="text-sm font-semibold 
                            {{ $totalTersisa <= 3 ? 'text-red-600' : ($totalTersisa <= 7 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ number_format(($totalTersisa / $totalKuota) * 100, 0) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" 
                             style="width: {{ ($totalTersisa / $totalKuota) * 100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Masih tersedia</span>
                        <span>{{ $totalTersisa }} slot</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full 
                    {{ $totalTersisa <= 3 ? 'bg-red-400' : ($totalTersisa <= 7 ? 'bg-yellow-400' : 'bg-green-400') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar Overall -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-fuchsia-600"></i>
                Progress Kuota Keseluruhan
            </h2>
            <span class="text-sm font-medium 
                {{ ($totalTerisi / $totalKuota) * 100 >= 80 ? 'text-red-600' : 
                   (($totalTerisi / $totalKuota) * 100 >= 60 ? 'text-yellow-600' : 'text-green-600') }}">
                {{ number_format(($totalTerisi / $totalKuota) * 100, 1) }}% Terisi
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4 mb-3">
            <div class="bg-gradient-to-r from-fuchsia-500 to-purple-600 h-4 rounded-full transition-all duration-500" 
                 style="width: {{ ($totalTerisi / $totalKuota) * 100 }}%">
            </div>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
            <span class="flex items-center">
                <i class="fas fa-users mr-2 text-fuchsia-500"></i>
                {{ $totalTerisi }} terisi
            </span>
            <span class="flex items-center">
                <i class="fas fa-clock mr-2 text-green-500"></i>
                {{ $totalTersisa }} tersisa
            </span>
        </div>
    </div>

    <!-- Kuota per Blok Waktu -->
    <div class="bg-white rounded-2xl shadow-lg mb-6 overflow-hidden card-hover">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clock mr-3 text-cyan-600"></i>
                    Kuota per Blok Waktu
                </h2>
                <span class="bg-cyan-100 text-cyan-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ count($blocks) }} blok waktu
                </span>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($blocks as $block)
                <div class="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white hover:shadow-md transition-all duration-200 group">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-800 text-sm">
                            {{ $block['start'] }} - {{ $block['end'] }}
                        </h3>
                        <span class="text-xs font-medium px-2 py-1 rounded-full
                            {{ $block['tersisa'] == 0 ? 'bg-red-100 text-red-800' : 
                               ($block['tersisa'] <= 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ $block['tersisa'] }}/{{ $block['kuota'] }}
                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>No. {{ $block['range'][0] }} - {{ $block['range'][1] }}</span>
                            <span>{{ $block['persentase'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-500
                                {{ $block['persentase'] < 70 ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 
                                   ($block['persentase'] < 90 ? 'bg-gradient-to-r from-yellow-500 to-amber-600' : 'bg-gradient-to-r from-red-500 to-emerald-600') }}" 
                                 style="width: {{ $block['persentase'] }}%">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-600">
                            <i class="fas fa-user-check mr-1"></i>
                            {{ $block['terisi'] }} terisi
                        </span>
                        <span class="{{ $block['tersisa'] == 0 ? 'text-red-600' : 
                                       ($block['tersisa'] <= 1 ? 'text-yellow-600' : 'text-green-600') }} font-medium">
                            <i class="fas fa-{{ $block['tersisa'] == 0 ? 'times' : 'check' }} mr-1"></i>
                            {{ $block['tersisa'] }} tersisa
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Daftar Antrian -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center mb-2 sm:mb-0">
                    <i class="fas fa-list-ol mr-3 text-emerald-600"></i>
                    Daftar Antrian
                    <span class="ml-2 text-sm font-normal text-gray-600">
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('j F Y') }}
                    </span>
                </h2>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $antrian->count() }} antrian
                </span>
            </div>
        </div>
        <div class="p-6">
            @if($antrian->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($antrian as $item)
                    <div class="border border-gray-200 rounded-xl p-4 bg-gradient-to-br from-gray-50 to-white hover:shadow-md transition-all duration-200 group">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                                No. {{ $item->nomor }}
                            </span>
                            <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">
                                {{ $item->jam }}
                            </span>
                        </div>
                        <div class="space-y-2">
                            <p class="font-semibold text-gray-900 text-sm">{{ $item->nama_tk }}</p>
                            <div class="text-xs text-gray-600 space-y-1">
                                <p class="flex items-center">
                                    <i class="fas fa-user-friends mr-2 text-blue-500"></i>
                                    {{ $item->ahli_waris }}
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-green-500"></i>
                                    {{ $item->no_hp }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-5xl mb-4">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-lg mb-2">Tidak ada antrian</p>
                    <p class="text-gray-400 text-sm">Belum ada pendaftaran untuk tanggal ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Auto Refresh Indicator -->
    <div class="mt-8 text-center">
        <div class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-full text-sm">
            <div class="w-2 h-2 bg-green-600 rounded-full mr-2 animate-pulse"></div>
            Auto refresh setiap 60 detik
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
    // Auto refresh setiap 60 detik
    setTimeout(function() {
        window.location.reload();
    }, 60000);

    // Add loading animation for cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 100}ms`;
            card.classList.add('animate-fade-in-up');
        });
    });
</script>
@endpush