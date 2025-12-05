@extends('layouts.admin')

@section('title', 'Data Antrian - Admin')
@section('header-title', 'Data Antrian')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">Manajemen Data Antrian</h1>
            <p class="text-green-100 opacity-90">Kelola dan pantau seluruh data antrian JKM BPJS Ketenagakerjaan</p>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20">
            <i class="fas fa-list-ol text-6xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <!-- Total Data -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-green-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 shadow-sm">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600 flex items-center">
                        <span>Total Data</span>
                        <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            All Time
                        </span>
                    </p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($antrian->total()) }}</p>
                        <span class="text-sm font-semibold text-green-600">
                            {{ $antrian->total() > 0 ? '100%' : '0%' }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" 
                            style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Keseluruhan</span>
                        <span>Semua periode</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
        </div>

        <!-- Data Ditampilkan -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-fuchsia-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-fuchsia-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-fuchsia-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 shadow-sm">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600 flex items-center">
                        <span>Ditampilkan</span>
                        <span class="ml-2 text-xs bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full">
                            Halaman
                        </span>
                    </p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($antrian->count()) }}</p>
                        <span class="text-sm font-semibold 
                            {{ $antrian->count() == $antrian->total() ? 'text-green-600' : 
                            ($antrian->count() >= ($antrian->total() * 0.7) ? 'text-yellow-600' : 'text-blue-600') }}">
                            @if($antrian->total() > 0)
                                {{ number_format(($antrian->count() / $antrian->total()) * 100, 0) }}%
                            @else
                                0%
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-gradient-to-r from-fuchsia-500 to-fuchsia-600 h-2 rounded-full transition-all duration-500" 
                            style="width: {{ $antrian->total() > 0 ? ($antrian->count() / $antrian->total()) * 100 : 0 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Filter Aktif</span>
                        <span>{{ $antrian->count() }}/{{ $antrian->total() }} data</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="absolute top-4 right-4">
                <div class="w-3 h-3 rounded-full 
                    {{ $antrian->count() == $antrian->total() ? 'bg-green-400' : 
                    ($antrian->count() >= ($antrian->total() * 0.7) ? 'bg-yellow-400' : 'bg-blue-400') }}">
                </div>
            </div>
        </div>

        <!-- Pagination Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-cyan-500 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-cyan-50 rounded-full -mr-6 -mt-6"></div>
            <div class="absolute bottom-0 left-0 w-12 h-12 bg-cyan-100 rounded-full -ml-4 -mb-4"></div>
            
            <div class="flex items-center relative z-10">
                <div class="p-3 rounded-xl bg-cyan-50 text-cyan-600 shadow-sm">
                    <i class="fas fa-file text-xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-600">Navigasi Halaman</p>
                    <div class="flex items-baseline justify-between mb-2 mt-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $antrian->currentPage() }}/{{ $antrian->lastPage() }}</p>
                        <div class="flex items-center space-x-1">
                            <i class="fas 
                                {{ $antrian->currentPage() < $antrian->lastPage() ? 'fa-arrow-up text-green-500' : 
                                ($antrian->currentPage() == 1 ? 'fa-minus text-gray-500' : 'fa-arrow-down text-red-500') }} text-xs">
                            </i>
                            <span class="text-xs font-medium 
                                {{ $antrian->currentPage() < $antrian->lastPage() ? 'text-green-600' : 
                                ($antrian->currentPage() == 1 ? 'text-gray-600' : 'text-red-600') }}">
                                @if($antrian->lastPage() > 1)
                                    {{ number_format(($antrian->currentPage() / $antrian->lastPage()) * 100, 0) }}%
                                @else
                                    100%
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Pagination Progress -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress Halaman</span>
                            <span>{{ $antrian->currentPage() }}/{{ $antrian->lastPage() }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1">
                            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-1 rounded-full" 
                                style="width: {{ $antrian->lastPage() > 0 ? ($antrian->currentPage() / $antrian->lastPage()) * 100 : 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Page Indicator -->
            <div class="absolute top-4 right-4">
                <span class="text-xs font-medium bg-cyan-100 text-cyan-800 px-2 py-1 rounded-full">
                    Page {{ $antrian->currentPage() }}
                </span>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form action="{{ route('admin.antrian') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-day mr-2 text-green-500"></i>Filter Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-2 text-fuchsia-500"></i>Filter Periode
                    </label>
                    <select name="filter" class="w-full border border-gray-300 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent transition-all duration-200">
                        <option value="">Semua Data</option>
                        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="tomorrow" {{ request('filter') == 'tomorrow' ? 'selected' : '' }}>Besok</option>
                        <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>7 Hari ke Depan</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('admin.antrian') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center mb-2 sm:mb-0">
                    <i class="fas fa-list-ol mr-3 text-green-600"></i>
                    Daftar Antrian
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $antrian->count() }} data
                    </span>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-green-50 to-emerald-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-hashtag mr-2"></i>No Antrian
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>Tanggal & Waktu
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>Data Tenaga Kerja
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>Ahli Waris
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>Kontak
                            </div>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-cog mr-2"></i>Aksi
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($antrian as $item)
                    <tr class="hover:bg-gradient-to-r hover:from-green-50/50 hover:to-emerald-50/50 transition-all duration-200 group">
                        <!-- No Antrian -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-sm font-bold text-white shadow-sm
                                    {{ $item->tanggal == now()->format('Y-m-d') ? 'bg-gradient-to-r from-red-500 to-rose-600' : 
                                       ($item->tanggal == now()->addDay()->format('Y-m-d') ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 
                                       'bg-gradient-to-r from-blue-500 to-cyan-600') }}">
                                    #{{ $item->nomor }}
                                    @if($item->tanggal == now()->format('Y-m-d'))
                                        <span class="ml-2 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    @endif
                                </span>
                            </div>
                        </td>

                        <!-- Tanggal & Waktu -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <i class="far fa-clock text-xs mr-1"></i>
                                    <span>{{ $item->jam }}</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}
                                </div>
                            </div>
                        </td>

                        <!-- Data Tenaga Kerja -->
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-semibold text-gray-900 truncate max-w-xs">
                                    {{ $item->nama_tk }}
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-id-card mr-1 text-xs"></i>
                                    {{ $item->nik_tk }}
                                </div>
                            </div>
                        </td>

                        <!-- Ahli Waris -->
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->ahli_waris }}
                                </div>
                            </div>
                        </td>

                        <!-- Kontak -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->no_hp }}
                                </div>
                            </div>
                        </td>

                        <!-- Aksi -->
                        <td class="px-4 py-4 whitespace-nowrap">
    <div class="flex items-center space-x-2">
        <!-- Tombol Detail -->
        <a href="{{ route('admin.antrian.show', $item->id) }}" 
           class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 transform hover:scale-105 group/btn"
           title="Lihat Detail">
            <i class="fas fa-eye text-sm"></i>
            <span class="ml-1 text-xs font-medium hidden sm:inline">Detail</span>
        </a>
        
        <!-- Tombol Status Dropdown -->
        <button type="button"
                onclick="openStatusDropdown(event, {{ $item->id }}, '{{ $item->status }}')"
                class="inline-flex items-center px-3 py-2 rounded-lg hover:opacity-90 transition-all duration-200 transform hover:scale-105 group/btn status-btn"
                title="Ubah Status"
                id="status-btn-{{ $item->id }}"
                data-status="{{ $item->status }}">
            
            @switch($item->status)
                @case('diterima')
                    <i class="fas fa-check-circle text-sm text-green-600"></i>
                    <span class="ml-1 text-xs font-medium hidden sm:inline text-green-700">Diterima</span>
                    @break
                
                @case('cek_kasus')
                    <i class="fas fa-search text-sm text-yellow-600"></i>
                    <span class="ml-1 text-xs font-medium hidden sm:inline text-yellow-700">Cek Kasus</span>
                    @break
                
                @case('ditolak')
                    <i class="fas fa-times-circle text-sm text-red-600"></i>
                    <span class="ml-1 text-xs font-medium hidden sm:inline text-red-700">Ditolak</span>
                    @break
                
                @default
                    <i class="fas fa-clock text-sm text-gray-600"></i>
                    <span class="ml-1 text-xs font-medium hidden sm:inline text-gray-700">Pending</span>
            @endswitch
            
            <i class="fas fa-chevron-down ml-1 text-xs text-gray-500"></i>
        </button>
        
        <!-- Tombol Hapus -->
        <form action="{{ route('admin.antrian.destroy', $item->id) }}" method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
              class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 transform hover:scale-105 group/btn"
                    title="Hapus Data">
                <i class="fas fa-trash text-sm"></i>
                <span class="ml-1 text-xs font-medium hidden sm:inline">Hapus</span>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-inbox text-5xl mb-4"></i>
                                <p class="text-lg font-medium text-gray-500 mb-2">Tidak ada data antrian</p>
                                <p class="text-sm text-gray-400">Data akan muncul ketika ada pendaftaran antrian baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($antrian->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                    Menampilkan {{ $antrian->firstItem() ?? 0 }} - {{ $antrian->lastItem() ?? 0 }} dari {{ $antrian->total() }} data
                </div>
                <div class="flex justify-center">
                    {{ $antrian->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<div id="global-dropdown-container" class="fixed z-[99999]"></div>
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

    /* Custom scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Animation for table rows */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    tbody tr {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    tbody tr:nth-child(1) { animation-delay: 0.1s; }
    tbody tr:nth-child(2) { animation-delay: 0.2s; }
    tbody tr:nth-child(3) { animation-delay: 0.3s; }
    tbody tr:nth-child(4) { animation-delay: 0.4s; }
    tbody tr:nth-child(5) { animation-delay: 0.5s; }

    /* Status Dropdown Styles */
    .status-dropdown-menu {
        position: fixed;
        width: 200px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        border: 1px solid #e5e7eb;
        z-index: 99999;
        animation: dropdownFadeIn 0.2s ease-out;
    }
    
    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    /* Overlay background */
    .dropdown-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: transparent;
        z-index: 99998;
    }
    
    /* Styling untuk tombol status berdasarkan status saat ini */
    .status-btn {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    
    .status-btn[data-status="diterima"] {
        background-color: rgba(34, 197, 94, 0.1);
        border-color: rgba(34, 197, 94, 0.2);
    }
    
    .status-btn[data-status="cek_kasus"] {
        background-color: rgba(234, 179, 8, 0.1);
        border-color: rgba(234, 179, 8, 0.2);
    }
    
    .status-btn[data-status="ditolak"] {
        background-color: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.2);
    }
    
    .status-btn[data-status="pending"] {
        background-color: rgba(107, 114, 128, 0.1);
        border-color: rgba(107, 114, 128, 0.2);
    }
    
    /* Hover effect */
    .status-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* Animation for status change */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .animate-pulse {
        animation: pulse 0.5s ease-in-out;
    }
    
    /* Untuk tampilan mobile yang lebih kecil */
    @media (max-width: 640px) {
        .status-btn {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .status-btn i:first-child {
            margin-right: 0;
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
</style>
@endpush

@push('scripts')
<script>
// Add hover effects and animations
document.addEventListener('DOMContentLoaded', function() {
    // Add loading animation for cards
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 100}ms`;
        card.classList.add('animate-fade-in-up');
    });

    // Add click effect for buttons
    const buttons = document.querySelectorAll('.group\\/btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});

// Auto refresh every 60 seconds for real-time updates
setTimeout(function() {
    window.location.reload();
}, 60000);

let currentDropdown = null;
let currentOverlay = null;

function openStatusDropdown(event, id, currentStatus) {
    event.stopPropagation();
    
    // Jika dropdown yang sama sedang terbuka, tutup
    if (currentDropdown && currentDropdown.dataset.id === id.toString()) {
        closeDropdown();
        return;
    }
    
    // Tutup dropdown sebelumnya jika ada
    closeDropdown();
    
    // Dapatkan posisi tombol
    const button = document.getElementById(`status-btn-${id}`);
    const rect = button.getBoundingClientRect();
    
    // Buat overlay untuk menangkap klik di luar
    const overlay = document.createElement('div');
    overlay.className = 'dropdown-overlay';
    overlay.onclick = closeDropdown;
    
    // Buat dropdown menu
    const dropdown = document.createElement('div');
    dropdown.className = 'status-dropdown-menu';
    dropdown.dataset.id = id;
    dropdown.style.left = `${rect.left}px`;
    
    // Hitung posisi vertikal
    const viewportHeight = window.innerHeight;
    const dropdownHeight = 136; // Approximate height
    const spaceBelow = viewportHeight - rect.bottom;
    const spaceAbove = rect.top;
    
    if (spaceBelow >= dropdownHeight || spaceBelow >= spaceAbove) {
        // Tampilkan di bawah
        dropdown.style.top = `${rect.bottom + 8}px`;
    } else {
        // Tampilkan di atas
        dropdown.style.top = `${rect.top - dropdownHeight - 8}px`;
    }
    
    // Buat dropdown content dengan button AJAX
    dropdown.innerHTML = `
        <div class="p-2">
            <button type="button" 
                    class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-green-50 text-green-600 flex items-center mb-1 
                           ${currentStatus === 'diterima' ? 'bg-green-50 font-medium border-l-4 border-green-500' : ''}"
                    onclick="updateStatus(${id}, 'diterima')">
                <i class="fas fa-check-circle mr-2"></i>
                Diterima
                ${currentStatus === 'diterima' ? '<i class="fas fa-check ml-auto text-green-500"></i>' : ''}
            </button>
            
            <button type="button" 
                    class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-yellow-50 text-yellow-600 flex items-center mb-1 
                           ${currentStatus === 'cek_kasus' ? 'bg-yellow-50 font-medium border-l-4 border-yellow-500' : ''}"
                    onclick="updateStatus(${id}, 'cek_kasus')">
                <i class="fas fa-search mr-2"></i>
                Cek Kasus
                ${currentStatus === 'cek_kasus' ? '<i class="fas fa-check ml-auto text-yellow-500"></i>' : ''}
            </button>
            
            <button type="button" 
                    class="w-full text-left px-3 py-2 text-sm rounded-md hover:bg-red-50 text-red-600 flex items-center 
                           ${currentStatus === 'ditolak' ? 'bg-red-50 font-medium border-l-4 border-red-500' : ''}"
                    onclick="updateStatus(${id}, 'ditolak')">
                <i class="fas fa-times-circle mr-2"></i>
                Ditolak
                ${currentStatus === 'ditolak' ? '<i class="fas fa-check ml-auto text-red-500"></i>' : ''}
            </button>
        </div>
    `;
    
    // Tambahkan ke container
    const container = document.getElementById('global-dropdown-container');
    container.appendChild(overlay);
    container.appendChild(dropdown);
    
    // Simpan referensi
    currentDropdown = dropdown;
    currentOverlay = overlay;
}

// Fungsi AJAX untuk update status
function updateStatus(id, status) {
    // Update UI terlebih dahulu
    updateButtonStatus(id, status);
    closeDropdown();
    
    // Tampilkan loading
    showLoading(id);
    
    // Kirim request AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Gunakan FormData untuk mengirim data
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('status', status);
    formData.append('_token', csrfToken);
    
    // Kirim request
    fetch(`/admin/antrian/${id}/update-status`, {
        method: 'POST', // Laravel PUT harus via POST dengan _method
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        // Hapus loading
        hideLoading(id);
        
        if (response.ok) {
            return response.json().then(data => {
                showNotification('Status berhasil diperbarui!', 'success');
                console.log('Status updated successfully:', data);
            });
        } else {
            return response.json().then(data => {
                throw new Error(data.message || 'Gagal memperbarui status');
            });
        }
    })
    .catch(error => {
        // Hapus loading
        hideLoading(id);
        
        console.error('Error updating status:', error);
        showNotification(error.message || 'Gagal memperbarui status!', 'error');
        
        // Optionally reload the page to get correct status from server
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    });
}

// Fungsi untuk update UI tombol
function updateButtonStatus(id, newStatus) {
    const button = document.getElementById(`status-btn-${id}`);
    if (!button) return;
    
    // Update data-status attribute
    button.dataset.status = newStatus;
    
    // Update icon dan text berdasarkan status baru
    const iconMap = {
        'diterima': { icon: 'fa-check-circle', color: 'green', text: 'Diterima' },
        'cek_kasus': { icon: 'fa-search', color: 'yellow', text: 'Cek Kasus' },
        'ditolak': { icon: 'fa-times-circle', color: 'red', text: 'Ditolak' },
        'pending': { icon: 'fa-clock', color: 'gray', text: 'Pending' }
    };
    
    const statusInfo = iconMap[newStatus] || iconMap['pending'];
    
    // Update icon
    const iconElement = button.querySelector('i:first-child');
    if (iconElement) {
        iconElement.className = `fas ${statusInfo.icon} text-sm text-${statusInfo.color}-600`;
    }
    
    // Update text jika ada
    const textSpan = button.querySelector('span.text-xs');
    if (textSpan) {
        textSpan.textContent = statusInfo.text;
        textSpan.className = `ml-1 text-xs font-medium hidden sm:inline text-${statusInfo.color}-700`;
    }
    
    // Update class styling
    const colorClasses = {
        'diterima': 'bg-green-50 border-green-500',
        'cek_kasus': 'bg-yellow-50 border-yellow-500',
        'ditolak': 'bg-red-50 border-red-500',
        'pending': 'bg-gray-50 border-gray-500'
    };
    
    // Remove existing status classes
    Object.values(colorClasses).forEach(className => {
        const classes = className.split(' ');
        classes.forEach(cls => button.classList.remove(cls));
    });
    
    // Add new classes
    if (colorClasses[newStatus]) {
        const classes = colorClasses[newStatus].split(' ');
        classes.forEach(cls => button.classList.add(cls));
    }
}

// Fungsi untuk menampilkan loading di tombol
function showLoading(id) {
    const button = document.getElementById(`status-btn-${id}`);
    if (button) {
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i><span class="ml-1 text-xs font-medium">Loading...</span>';
        button.disabled = true;
        button.dataset.originalHtml = originalHTML;
    }
}

// Fungsi untuk menyembunyikan loading
function hideLoading(id) {
    const button = document.getElementById(`status-btn-${id}`);
    if (button && button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
        button.disabled = false;
        delete button.dataset.originalHtml;
    }
}

// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = 'success') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-[100000] px-6 py-4 rounded-lg shadow-xl flex items-center space-x-3 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.style.animation = 'slideInRight 0.3s ease-out';
    
    notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-lg"></i>
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Auto remove setelah 3 detik
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease-out forwards';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 300);
        }
    }, 3000);
}

function closeDropdown() {
    if (currentDropdown) {
        currentDropdown.remove();
        currentDropdown = null;
    }
    if (currentOverlay) {
        currentOverlay.remove();
        currentOverlay = null;
    }
}

// Tutup dropdown saat tekan ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDropdown();
    }
});

// Tutup dropdown saat klik di luar
document.addEventListener('click', function(event) {
    if (currentOverlay && !event.target.closest('.status-dropdown-menu')) {
        closeDropdown();
    }
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