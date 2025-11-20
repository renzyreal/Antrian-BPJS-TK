@extends('layouts.admin')

@section('title', 'Monitoring Kuota - Admin')
@section('header-title', 'Monitoring Kuota')

@section('content')
    <!-- Filter Tanggal -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('admin.kuota') }}" method="GET" class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
            <a href="{{ route('admin.kuota') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-calendar-day mr-2"></i>Hari Ini
            </a>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kuota</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalKuota }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tersisa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTersisa }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Terisi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTerisi }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar Overall -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Progress Kuota Keseluruhan</h2>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-blue-600 h-4 rounded-full" 
                 style="width: {{ ($totalTerisi / $totalKuota) * 100 }}%">
            </div>
        </div>
        <div class="flex justify-between text-sm text-gray-600 mt-2">
            <span>{{ $totalTerisi }} terisi</span>
            <span>{{ $totalTersisa }} tersisa</span>
        </div>
    </div>

    <!-- Kuota per Blok Waktu -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Kuota per Blok Waktu</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($blocks as $block)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-800">
                            {{ $block['start'] }} - {{ $block['end'] }}
                        </h3>
                        <span class="text-sm font-medium 
                            {{ $block['tersisa'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $block['terisi'] }}/{{ $block['kuota'] }} 
                            ({{ $block['tersisa'] }} tersisa)
                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="h-3 rounded-full 
                            {{ $block['persentase'] < 70 ? 'bg-green-500' : 
                               ($block['persentase'] < 90 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                             style="width: {{ $block['persentase'] }}%">
                        </div>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-600">
                        <span>No. {{ $block['range'][0] }} - {{ $block['range'][1] }}</span>
                        <span>{{ $block['persentase'] }}% terisi</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Daftar Antrian -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                Daftar Antrian Tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('j F Y') }}
            </h2>
            <span class="text-sm text-gray-600">
                {{ $antrian->count() }} antrian
            </span>
        </div>
        <div class="p-6">
            @if($antrian->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($antrian as $item)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm font-bold">
                                No. {{ $item->nomor }}
                            </span>
                            <span class="text-sm text-gray-600">{{ $item->jam }}</span>
                        </div>
                        <div class="space-y-1">
                            <p class="font-medium text-gray-900">{{ $item->nama_tk }}</p>
                            <p class="text-sm text-gray-600">Ahli Waris: {{ $item->ahli_waris }}</p>
                            <p class="text-sm text-gray-600">{{ $item->no_hp }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">
                    <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300"></i><br>
                    Tidak ada antrian untuk tanggal ini
                </p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto refresh setiap 60 detik
    setTimeout(function() {
        window.location.reload();
    }, 60000);
</script>
@endpush