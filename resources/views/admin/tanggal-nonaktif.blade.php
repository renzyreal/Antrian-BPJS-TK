@extends('layouts.admin')

@section('title', 'Tanggal Nonaktif - Admin Antrian JKM')
@section('header-title', 'Pengaturan Tanggal ')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">Kelola Tanggal Nonaktif 📅</h1>
            <p class="text-fuchsia-100 opacity-90">Atur hari-hari dimana sistem antrian tidak beroperasi</p>
        </div>
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20">
            <i class="fas fa-calendar-times text-7xl"></i>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <div class="space-y-6">

        {{-- FORM TAMBAH TANGGAL --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-plus mr-3 text-green-600"></i>
                    <span>Tambah Tanggal Nonaktif</span>
                </h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Sistem Antrian
                </span>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tanggal.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2 text-gray-700">Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" placeholder="Contoh: Libur nasional / Maintenance server">
                </div>

                <div class="md:col-span-3">
                    <button class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambahkan Tanggal
                    </button>
                </div>
            </form>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <!-- Total Tanggal Nonaktif -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-fuchsia-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-fuchsia-50 rounded-full -mr-6 -mt-6"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-fuchsia-100 rounded-full -ml-4 -mb-4"></div>
                
                <div class="flex items-center relative z-10">
                    <div class="p-3 rounded-xl bg-fuchsia-50 text-fuchsia-600 shadow-sm">
                        <i class="fas fa-calendar-times text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Nonaktif</p>
                        <div class="flex items-baseline justify-between mb-2 mt-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $items->count() }}</p>
                            <span class="text-sm font-semibold text-fuchsia-600">
                                hari
                            </span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Terdaftar</span>
                            <span>Sistem</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanggal Mendatang -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-purple-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -mr-6 -mt-6"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-purple-100 rounded-full -ml-4 -mb-4"></div>
                
                <div class="flex items-center relative z-10">
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600 shadow-sm">
                        <i class="fas fa-calendar-day text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Mendatang</p>
                        <div class="flex items-baseline justify-between mb-2 mt-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $upcomingCount }}</p>
                            <span class="text-sm font-semibold text-purple-600">
                                hari
                            </span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>30 hari ke depan</span>
                            <span>Terjadwal</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulan Ini -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-blue-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-6 -mt-6"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-blue-100 rounded-full -ml-4 -mb-4"></div>
                
                <div class="flex items-center relative z-10">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shadow-sm">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
                        <div class="flex items-baseline justify-between mb-2 mt-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $thisMonthCount }}</p>
                            <span class="text-sm font-semibold text-blue-600">
                                hari
                            </span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ \Carbon\Carbon::now()->translatedFormat('M Y') }}</span>
                            <span>Nonaktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Sistem -->
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover border-l-4 border-green-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>
                
                <div class="flex items-center relative z-10">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600 shadow-sm">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Status Hari Ini</p>
                        <div class="flex items-baseline justify-between mb-2 mt-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $isTodayDisabled ? 'Nonaktif' : 'Aktif' }}</p>
                            <span class="text-sm font-semibold {{ $isTodayDisabled ? 'text-red-600' : 'text-green-600' }}">
                                {{ $isTodayDisabled ? '✗' : '✓' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                            <span>Sistem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL TANGGAL NONAKTIF --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-times mr-3 text-fuchsia-600"></i>
                    <span>Daftar Tanggal Nonaktif</span>
                </h3>
                <span class="bg-fuchsia-100 text-fuchsia-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $items->count() }} tanggal
                </span>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-700 uppercase">
                        <tr>
                            <th class="py-3 px-4 rounded-l-xl">Tanggal</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 rounded-r-xl text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($items as $item)
                            @php
                                $isPast = \Carbon\Carbon::parse($item->tanggal)->isPast();
                                $isToday = \Carbon\Carbon::parse($item->tanggal)->isToday();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-3 px-4 font-medium">
                                    <div class="flex items-center">
                                        <div class="p-2 rounded-lg {{ $isPast ? 'bg-gray-100 text-gray-600' : ($isToday ? 'bg-orange-100 text-orange-600' : 'bg-fuchsia-50 text-fuchsia-600') }} mr-3">
                                            <i class="fas {{ $isPast ? 'fa-calendar-check' : ($isToday ? 'fa-calendar-day' : 'fa-calendar-alt') }}"></i>
                                        </div>
                                        <div>
                                            <span class="block">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium {{ $isPast ? 'bg-gray-100 text-gray-800' : ($isToday ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $isPast ? 'Selesai' : ($isToday ? 'Hari Ini' : 'Mendatang') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('admin.tanggal.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tanggal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-4 py-2 text-sm bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 font-medium flex items-center">
                                            <i class="fas fa-trash mr-2"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="text-gray-400 text-4xl mb-3">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada tanggal nonaktif</p>
                                        <p class="text-gray-400 text-sm mt-1">Semua hari tersedia untuk antrian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
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
    // Add loading animation for cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 100}ms`;
            card.classList.add('animate-fade-in-up');
        });
    });

    // Auto refresh setiap 60 detik
    setTimeout(function() {
        window.location.reload();
    }, 60000);
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