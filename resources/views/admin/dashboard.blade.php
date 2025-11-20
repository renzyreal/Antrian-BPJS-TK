@extends('layouts.admin')

@section('title', 'Dashboard - Admin Antrian JKM')
@section('header-title', 'Admin Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Antrian Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today'] }}/15</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Antrian Besok</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['tomorrow'] }}/15</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Terverifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['verified'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Antrian Hari Ini -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-list-ol mr-2"></i>Antrian Hari Ini
                </h2>
            </div>
            <div class="p-6">
                @if($antrianHariIni->count() > 0)
                    <div class="space-y-3">
                        @foreach($antrianHariIni as $antrian)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $antrian->nomor }}
                                </span>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">{{ $antrian->nama_tk }}</p>
                                    <p class="text-sm text-gray-600">{{ $antrian->jam }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.antrian.show', $antrian->id) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada antrian untuk hari ini</p>
                @endif
            </div>
        </div>

        <!-- Antrian Besok -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-calendar-alt mr-2"></i>Antrian Besok
                </h2>
            </div>
            <div class="p-6">
                @if($antrianBesok->count() > 0)
                    <div class="space-y-3">
                        @foreach($antrianBesok as $antrian)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $antrian->nomor }}
                                </span>
                                <div class="ml-4">
                                    <p class="font-medium text-gray-900">{{ $antrian->nama_tk }}</p>
                                    <p class="text-sm text-gray-600">{{ $antrian->jam }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.antrian.show', $antrian->id) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tidak ada antrian untuk besok</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.antrian') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <i class="fas fa-list text-blue-600 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-semibold text-gray-800">Lihat Semua Antrian</h3>
                    <p class="text-sm text-gray-600">Kelola data antrian lengkap</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.kuota') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <i class="fas fa-chart-pie text-green-600 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-semibold text-gray-800">Monitoring Kuota</h3>
                    <p class="text-sm text-gray-600">Pantau kuota per blok waktu</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.export.form') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <i class="fas fa-file-export text-purple-600 text-2xl mr-4"></i>
                <div>
                    <h3 class="font-semibold text-gray-800">Export Data</h3>
                    <p class="text-sm text-gray-600">Download data dalam format CSV</p>
                </div>
            </div>
        </a>
    </div>
@endsection

@push('scripts')
<script>
    // Auto refresh setiap 30 detik
    setTimeout(function() {
        window.location.reload();
    }, 30000);
</script>
@endpush