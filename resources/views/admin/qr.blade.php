@extends('layouts.admin')

@section('title', 'QR Code Antrian - Admin')
@section('header-title', 'QR Code Generator')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">QR Code Generator</h1>
            <p class="text-green-100 opacity-90">Generate dan kelola QR Code untuk sistem antrian JKM</p>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20">
            <i class="fas fa-qrcode text-6xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <!-- Kolom Kiri: QR Code dan Info -->
        <div class="space-y-6">
            <!-- QR Code Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">QR Code Antrian</h2>
                    <p class="text-gray-600">Scan kode berikut untuk mendaftar antrian</p>
                </div>
                
                <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-2xl p-6 border border-green-100 relative overflow-hidden mb-6">
                    <!-- Background Pattern -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
                    <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>
                    
                    <div class="max-w-xs mx-auto relative z-10">
                        <div class="relative group flex justify-center items-center">
                            {!! $qr !!}
                            <div class="absolute inset-0 bg-green-500 bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all duration-300 bg-white bg-opacity-90 p-3 rounded-full shadow-lg">
                                    <i class="fas fa-expand text-green-600 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-green-600 text-sm mt-4 flex items-center justify-center">
                        <i class="fas fa-mobile-alt mr-2"></i>
                        Scan dengan smartphone Anda
                    </p>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Hari Ini</span>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                {{ \Carbon\Carbon::now()->translatedFormat('d M') }}
                            </span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-gray-900">{{ $stats['today'] ?? 0 }}/15</span>
                            <span class="text-sm font-semibold {{ ($stats['today'] ?? 0) >= 12 ? 'text-red-600' : (($stats['today'] ?? 0) >= 8 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format((($stats['today'] ?? 0)/15)*100, 0) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" 
                                style="width: {{ (($stats['today'] ?? 0)/15)*100 }}%"></div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Besok</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                {{ \Carbon\Carbon::now()->addDay()->translatedFormat('d M') }}
                            </span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-gray-900">{{ $stats['tomorrow'] ?? 0 }}/15</span>
                            <span class="text-sm font-semibold {{ ($stats['tomorrow'] ?? 0) >= 12 ? 'text-red-600' : (($stats['tomorrow'] ?? 0) >= 8 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format((($stats['tomorrow'] ?? 0)/15)*100, 0) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" 
                                style="width: {{ (($stats['tomorrow'] ?? 0)/15)*100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <a href="{{ route('admin.qr.download') }}" 
                target="_blank"
                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center space-x-2 group">
                <i class="fas fa-print group-hover:scale-110 transition-transform duration-200"></i>
                <span>Cetak QR Code</span>
            </a>
        </div>

        <!-- Kolom Kanan: Informasi dan Panduan -->
        <div class="space-y-6">
            <!-- Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Informasi Antrian</h2>
                        <p class="text-gray-600">Panduan penggunaan sistem</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-4">
                    <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-800 mb-1">Scan QR Code</h4>
                            <p class="text-amber-700 text-sm">Buka kamera smartphone dan arahkan ke QR code</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-fuchsia-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-1">Isi Form Pendaftaran</h4>
                            <p class="text-green-700 text-sm">Lengkapi data diri dan informasi yang diperlukan</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">3</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-800 mb-1">Verifikasi Data</h4>
                            <p class="text-blue-700 text-sm">Tunggu verifikasi melalui WhatsApp yang terdaftar</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border border-purple-200">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">4</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-purple-800 mb-1">Dapatkan Nomor Antrian</h4>
                            <p class="text-purple-700 text-sm">Nomor antrian akan dikirimkan via WhatsApp</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 mr-4">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Fitur Unggulan</h2>
                        <p class="text-gray-600">Kelebihan sistem antrian digital kami</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 rounded-lg bg-green-100 text-green-600">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Aman & Terpercaya</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 rounded-lg bg-green-100 text-yellow-600">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Proses Cepat</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">24/7 Tersedia</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Mobile Friendly</span>
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
</style>
@endpush