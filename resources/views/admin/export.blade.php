@extends('layouts.admin')

@section('title', 'Export Data - Admin')
@section('header-title', 'Export Data')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Export Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Export Data Antrian</h2>
        
        <form action="{{ route('admin.export.download') }}" method="GET" class="space-y-4">
            <!-- Filter Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           value="{{ request('start_date') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           value="{{ request('end_date') }}">
                </div>
            </div>

            <!-- Atau Filter Tanggal Spesifik -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-2 text-sm text-gray-500">ATAU</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Tertentu</label>
                <input type="date" name="tanggal" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       value="{{ request('tanggal') }}">
            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    Kosongkan semua field untuk export semua data. Hanya gunakan satu jenis filter.
                </p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex space-x-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
                <a href="{{ route('admin.export.form') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-semibold flex items-center justify-center">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Quick Export -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Export Cepat</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.export.download') }}?filter=today" 
               class="bg-blue-100 border border-blue-300 rounded-lg p-4 text-center hover:bg-blue-200 transition-colors block">
                <i class="fas fa-calendar-day text-blue-600 text-2xl mb-2"></i>
                <h3 class="font-semibold text-blue-800">Hari Ini</h3>
                <p class="text-sm text-blue-600">Export data antrian hari ini</p>
            </a>

            <a href="{{ route('admin.export.download') }}?filter=week" 
               class="bg-green-100 border border-green-300 rounded-lg p-4 text-center hover:bg-green-200 transition-colors block">
                <i class="fas fa-calendar-week text-green-600 text-2xl mb-2"></i>
                <h3 class="font-semibold text-green-800">7 Hari Terakhir</h3>
                <p class="text-sm text-green-600">Export data seminggu terakhir</p>
            </a>

            <a href="{{ route('admin.export.download') }}" 
               class="bg-purple-100 border border-purple-300 rounded-lg p-4 text-center hover:bg-purple-200 transition-colors block">
                <i class="fas fa-database text-purple-600 text-2xl mb-2"></i>
                <h3 class="font-semibold text-purple-800">Semua Data</h3>
                <p class="text-sm text-purple-600">Export semua data antrian</p>
            </a>

            <a href="{{ route('admin.export.download') }}?filter=tomorrow" 
               class="bg-orange-100 border border-orange-300 rounded-lg p-4 text-center hover:bg-orange-200 transition-colors block">
                <i class="fas fa-calendar-alt text-orange-600 text-2xl mb-2"></i>
                <h3 class="font-semibold text-orange-800">Besok</h3>
                <p class="text-sm text-orange-600">Export data antrian besok</p>
            </a>
        </div>
    </div>

    <!-- Info Format -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">
            <i class="fas fa-file-excel mr-2"></i>Format File Excel
        </h3>
        <div class="text-sm text-yellow-700">
            <p class="mb-2">Data akan diexport dalam format Excel (.xlsx) dengan kolom:</p>
            <ul class="list-disc list-inside space-y-1">
                <li><strong>No Antrian</strong> - Nomor urut antrian</li>
                <li><strong>Tanggal</strong> - Tanggal antrian (YYYY-MM-DD)</li>
                <li><strong>Jam Kedatangan</strong> - Jam yang ditentukan</li>
                <li><strong>Nama Tenaga Kerja</strong> - Nama lengkap tenaga kerja</li>
                <li><strong>NIK Tenaga Kerja</strong> - Nomor Induk Kependudukan</li>
                <li><strong>Nama Ahli Waris</strong> - Nama ahli waris</li>
                <li><strong>Nomor WhatsApp</strong> - Nomor telepon yang terdaftar</li>
                <li><strong>Waktu Pendaftaran</strong> - Timestamp saat mendaftar</li>
            </ul>
        </div>
    </div>
</div>
@endsection