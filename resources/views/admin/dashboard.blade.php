@extends('layouts.admin')

@section('title', 'Dashboard - Admin Antrian JKM')
@section('header-title', 'Admin Dashboard')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama }}! 👋</h1>
            <p class="text-green-100 opacity-90">Pantau dan kelola sistem antrian JKM BPJS Ketenagakerjaan</p>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20">
            <i class="fas fa-chart-line text-6xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <!-- Stats Cards - Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Today's Queue -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-green-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 shadow-sm">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600 flex items-center">
                        <span>Antrian Hari Ini</span>
                        <span class="ml-2 text-xs bg-green-100 text-green-800 px-1 py-1 rounded-lg">
                            {{ \Carbon\Carbon::now()->translatedFormat('d M') }}
                        </span>
                    </p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['today'] }}/15</p>
                        <span class="text-sm font-semibold {{ $stats['today'] >= 12 ? 'text-red-600' : ($stats['today'] >= 8 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ number_format(($stats['today']/15)*100, 0) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" 
                            style="width: {{ ($stats['today']/15)*100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Kapasitas</span>
                        <span>{{ 15 - $stats['today'] }} slot tersisa</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full {{ $stats['today'] >= 12 ? 'bg-red-400 animate-pulse' : ($stats['today'] >= 8 ? 'bg-yellow-400' : 'bg-green-400') }}"></div>
            </div>
        </div>

        <!-- Tomorrow's Queue -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-fuchsia-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-fuchsia-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-fuchsia-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 shadow-sm">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600 flex items-center">
                        <span>Antrian Besok</span>
                        <span class="ml-2 text-xs bg-fuchsia-100 text-fuchsia-800 px-1 py-1 rounded-lg">
                            {{ \Carbon\Carbon::now()->addDay()->translatedFormat('d M') }}
                        </span>
                    </p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['tomorrow'] }}/15</p>
                        <span class="text-sm font-semibold {{ $stats['tomorrow'] >= 12 ? 'text-red-600' : ($stats['tomorrow'] >= 8 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ number_format(($stats['tomorrow']/15)*100, 0) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-fuchsia-500 to-fuchsia-600 h-2 rounded-full transition-all duration-500" 
                            style="width: {{ ($stats['tomorrow']/15)*100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Perkiraan</span>
                        <span>{{ 15 - $stats['tomorrow'] }} slot tersedia</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full {{ $stats['tomorrow'] >= 12 ? 'bg-red-400' : ($stats['tomorrow'] >= 8 ? 'bg-yellow-400' : 'bg-green-400') }}"></div>
            </div>
        </div>

        <!-- Monthly Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-blue-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-blue-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shadow-sm">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['this_month']) }}</p>
                        <div class="flex items-center space-x-1">
                            <i class="fas {{ $stats['this_month'] > $stats['last_month_total'] ? 'fa-arrow-up text-green-500' : 'fa-arrow-down text-red-500' }} text-xs"></i>
                            <span class="text-xs font-medium {{ $stats['this_month'] > $stats['last_month_total'] ? 'text-green-600' : 'text-red-600' }}">
                                @if($stats['last_month_total'] > 0)
                                    {{ number_format((($stats['this_month'] - $stats['last_month_total']) / $stats['last_month_total']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Monthly Progress -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress Bulan</span>
                            <span>{{ \Carbon\Carbon::now()->format('d') }}/{{ \Carbon\Carbon::now()->daysInMonth }} hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1 rounded-full" 
                                style="width: {{ (\Carbon\Carbon::now()->day / \Carbon\Carbon::now()->daysInMonth) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Month Indicator -->
            <div class="absolute top-4 right-4">
                <span class="text-xs font-medium bg-blue-100 text-blue-800 px-1 py-1 rounded-lg">
                    {{ \Carbon\Carbon::now()->translatedFormat('M Y') }}
                </span>
            </div>
        </div>

        <!-- Weekly Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-pink-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-pink-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-pink-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-pink-50 text-pink-600 shadow-sm">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Minggu Ini</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['this_week']) }}</p>
                        <div class="flex items-center space-x-1">
                            <i class="fas {{ $stats['this_week'] > $stats['last_week_total'] ? 'fa-arrow-up text-pink-500' : 'fa-arrow-down text-red-500' }} text-xs"></i>
                            <span class="text-xs font-medium {{ $stats['this_week'] > $stats['last_week_total'] ? 'text-pink-600' : 'text-red-600' }}">
                                @if($stats['last_week_total'] > 0)
                                    {{ number_format((($stats['this_week'] - $stats['last_week_total']) / $stats['last_week_total']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Week Progress -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress Minggu</span>
                            <span>{{ \Carbon\Carbon::now()->dayOfWeek }}/7 hari</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1">
                            <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-1 rounded-full" 
                                style="width: {{ (\Carbon\Carbon::now()->dayOfWeek / 7) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Week Indicator -->
            <div class="absolute top-4 right-4">
                <span class="text-xs font-medium bg-pink-100 text-pink-800 px-1 py-1 rounded-lg">
                    W{{ \Carbon\Carbon::now()->week }}
                </span>
            </div>
        </div>
    </div>

    <!-- Status Statistics Cards - Row 2 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Total Data -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-indigo-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                    <div class="text-xs text-gray-500 mt-1">Semua Waktu</div>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-indigo-400"></div>
            </div>
        </div>

        <!-- Status: Menunggu -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-gray-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-gray-50 text-gray-600 shadow-sm">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statusCounts['pending'] ?? 0) }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        @if($stats['total'] > 0)
                            {{ number_format((($statusCounts['pending'] ?? 0) / $stats['total']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
            </div>
        </div>

        <!-- Status: Diterima -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-green-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Diterima</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statusCounts['diterima'] ?? 0) }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        @if($stats['total'] > 0)
                            {{ number_format((($statusCounts['diterima'] ?? 0) / $stats['total']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
        </div>

        <!-- Status: Cek Kasus -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-yellow-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600 shadow-sm">
                    <i class="fas fa-search text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Cek Kasus</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statusCounts['cek_kasus'] ?? 0) }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        @if($stats['total'] > 0)
                            {{ number_format((($statusCounts['cek_kasus'] ?? 0) / $stats['total']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
            </div>
        </div>
    </div>

    <!-- Status Distribution - Row 3 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Status: Ditolak -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-red-500 relative overflow-hidden">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-red-50 text-red-600 shadow-sm">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statusCounts['ditolak'] ?? 0) }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        @if($stats['total'] > 0)
                            {{ number_format((($statusCounts['ditolak'] ?? 0) / $stats['total']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </div>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
            </div>
        </div>

        <!-- Status Chart Summary -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-pie mr-3 text-purple-600"></i>
                    <span>Distribusi Status Antrian</span>
                </h3>
                <span class="text-sm text-gray-500">Total: {{ $stats['total'] }} data</span>
            </div>
            
            <div class="space-y-4">
                @php
                    $statusColors = [
                        'pending' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'],
                        'diterima' => ['bg' => 'bg-green-500', 'text' => 'text-green-700'],
                        'cek_kasus' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
                        'ditolak' => ['bg' => 'bg-red-500', 'text' => 'text-red-700'],
                    ];
                    
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'diterima' => 'Diterima',
                        'cek_kasus' => 'Cek Kasus',
                        'ditolak' => 'Ditolak',
                    ];
                @endphp
                
                @foreach(['diterima', 'cek_kasus', 'pending', 'ditolak'] as $status)
                    @php
                        $count = $statusCounts[$status] ?? 0;
                        $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full {{ $statusColors[$status]['bg'] }} mr-2"></span>
                                <span class="font-medium {{ $statusColors[$status]['text'] }}">{{ $statusLabels[$status] }}</span>
                                <span class="ml-2 text-gray-500">{{ $count }}</span>
                            </div>
                            <span class="font-medium">{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="{{ $statusColors[$status]['bg'] }} h-2 rounded-full transition-all duration-500" 
                                style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Status Legend -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    @foreach($statusLabels as $key => $label)
                        <div class="flex items-center px-3 py-1.5 bg-gray-50 rounded-lg">
                            <span class="w-2 h-2 rounded-full {{ $statusColors[$key]['bg'] }} mr-2"></span>
                            <span class="text-xs font-medium {{ $statusColors[$key]['text'] }}">{{ $label }}</span>
                            <span class="ml-2 text-xs text-gray-500">{{ $statusCounts[$key] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        <!-- Antrian Hari Ini -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ol mr-3 text-green-600"></i>
                        <span>Antrian Hari Ini</span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $antrianHariIni->count() }} antrian
                        </span>
                        @php
                            $todayStatusCount = $antrianHariIni->groupBy('status')->map->count();
                        @endphp
                        @if(($todayStatusCount['diterima'] ?? 0) > 0)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $todayStatusCount['diterima'] }} ✅
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-6 max-h-96 overflow-y-auto custom-scrollbar">
                @if($antrianHariIni->count() > 0)
                    <div class="space-y-3">
                        @foreach($antrianHariIni as $antrian)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <span class="bg-green-600 text-white px-3 py-2 rounded-xl text-sm font-bold min-w-12 text-center block">
                                        #{{ $antrian->nomor }}
                                    </span>
                                    <div class="absolute -top-1 -right-1 w-3 h-3 {{ 
                                        $antrian->status == 'diterima' ? 'bg-green-300' : 
                                        ($antrian->status == 'cek_kasus' ? 'bg-yellow-300' : 
                                        ($antrian->status == 'ditolak' ? 'bg-red-300' : 'bg-gray-300'))
                                    }} rounded-full animate-pulse"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <p class="font-semibold text-gray-900 truncate">{{ $antrian->nama_tk }}</p>
                                        <span class="text-xs px-2 py-1 rounded-full {{ 
                                            $antrian->status == 'diterima' ? 'bg-green-100 text-green-800' : 
                                            ($antrian->status == 'cek_kasus' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($antrian->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $antrian->status)) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600 mt-1">
                                        <i class="far fa-clock text-xs"></i>
                                        <span>{{ $antrian->jam }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.antrian.show', $antrian->id) }}" 
                               class="opacity-0 group-hover:opacity-100 bg-white p-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-110">
                                <i class="fas fa-eye text-green-600"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-4xl mb-3">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Tidak ada antrian untuk hari ini</p>
                        <p class="text-gray-400 text-sm mt-1">Semua antrian telah selesai diproses</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Antrian Besok -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-calendar-alt mr-3 text-fuchsia-600"></i>
                        <span>Antrian Besok</span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        <span class="bg-fuchsia-100 text-fuchsia-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $antrianBesok->count() }} antrian
                        </span>
                        @php
                            $tomorrowStatusCount = $antrianBesok->groupBy('status')->map->count();
                        @endphp
                        @if(($tomorrowStatusCount['pending'] ?? 0) > 0)
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $tomorrowStatusCount['pending'] }} ⏳
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-6 max-h-96 overflow-y-auto custom-scrollbar">
                @if($antrianBesok->count() > 0)
                    <div class="space-y-3">
                        @foreach($antrianBesok as $antrian)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                            <div class="flex items-center space-x-4">
                                <span class="bg-fuchsia-600 text-white px-3 py-2 rounded-xl text-sm font-bold min-w-12 text-center">
                                    #{{ $antrian->nomor }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <p class="font-semibold text-gray-900 truncate">{{ $antrian->nama_tk }}</p>
                                        <span class="text-xs px-2 py-1 rounded-full {{ 
                                            $antrian->status == 'diterima' ? 'bg-green-100 text-green-800' : 
                                            ($antrian->status == 'cek_kasus' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($antrian->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                                        }}">
                                            {{ ucfirst(str_replace('_', ' ', $antrian->status)) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600 mt-1">
                                        <i class="far fa-clock text-xs"></i>
                                        <span>{{ $antrian->jam }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.antrian.show', $antrian->id) }}" 
                               class="opacity-0 group-hover:opacity-100 bg-white p-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-110">
                                <i class="fas fa-eye text-fuchsia-600"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-4xl mb-3">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Tidak ada antrian untuk besok</p>
                        <p class="text-gray-400 text-sm mt-1">Belum ada pendaftaran untuk hari berikutnya</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <a href="{{ route('admin.antrian') }}" 
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 group">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors duration-200">Lihat Semua Antrian</h3>
                    <p class="text-sm text-gray-600 mt-1">Kelola data antrian lengkap</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-green-600 transform group-hover:translate-x-1 transition-all duration-200"></i>
            </div>
        </a>

        <a href="{{ route('admin.kuota') }}" 
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 group">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 group-hover:bg-fuchsia-100 transition-colors duration-200">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-fuchsia-600 transition-colors duration-200">Monitoring Kuota</h3>
                    <p class="text-sm text-gray-600 mt-1">Pantau kuota per blok waktu</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-fuchsia-600 transform group-hover:translate-x-1 transition-all duration-200"></i>
            </div>
        </a>

        <a href="{{ route('admin.export.form') }}" 
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 group">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-pink-50 text-pink-600 group-hover:bg-pink-100 transition-colors duration-200">
                    <i class="fas fa-file-export text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-pink-600 transition-colors duration-200">Export Data</h3>
                    <p class="text-sm text-gray-600 mt-1">Download data dalam format Excel</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-pink-600 transform group-hover:translate-x-1 transition-all duration-200"></i>
            </div>
        </a>

        <a href="{{ route('admin.qr') }}" 
           class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 group">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors duration-200">
                    <i class="fas fa-qrcode text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors duration-200">QR Code</h3>
                    <p class="text-sm text-gray-600 mt-1">Generate QR untuk pendaftaran</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-indigo-600 transform group-hover:translate-x-1 transition-all duration-200"></i>
            </div>
        </a>
    </div>

    <!-- Auto Refresh Indicator -->
    <div class="mt-8 text-center">
        <div class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-full text-sm">
            <div class="w-2 h-2 bg-green-600 rounded-full mr-2 animate-pulse"></div>
            Auto refresh setiap 30 detik
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
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
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto refresh setiap 30 detik
    setTimeout(function() {
        window.location.reload();
    }, 30000);

    // Add loading animation for cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 100}ms`;
            card.classList.add('animate-fade-in-up');
        });
    });
</script>

<style>
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