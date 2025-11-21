@extends('layouts.admin')

@section('title', 'Detail Antrian - Admin')
@section('header-title', 'Detail Antrian')

@section('content')
<div class="max-w-8xl mx-auto">
    <!-- Header Info -->
    <div class="bg-gradient-to-r from-pink-600 to-rose-700 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Detail Antrian #{{ $antrian->nomor }}</h1>
                    <p class="text-pink-100 opacity-90">Informasi lengkap data antrian peserta</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                        <p class="text-sm font-medium">{{ \Carbon\Carbon::parse($antrian->tanggal)->translatedFormat('l, j F Y') }}</p>
                        <p class="text-lg font-bold">{{ $antrian->jam }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Info Antrian -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-pink-600"></i>
                        Informasi Antrian
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-center p-6 bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl border-l-4 border-pink-500">
                            <div class="text-4xl font-bold text-pink-600 mb-2">{{ $antrian->nomor }}</div>
                            <div class="text-sm font-semibold text-gray-700">Nomor Antrian</div>
                            <div class="text-xs text-gray-500 mt-1">Urutan pelayanan</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-fuchsia-50 to-purple-50 rounded-2xl border-l-4 border-fuchsia-500">
                            <div class="text-3xl font-bold text-fuchsia-600 mb-2">{{ $antrian->jam }}</div>
                            <div class="text-sm font-semibold text-gray-700">Jam Kedatangan</div>
                            <div class="text-xs text-gray-500 mt-1">Perkiraan waktu</div>
                        </div>
                    </div>
                    
                    <!-- Status Indicator -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full 
                                    {{ $antrian->tanggal == now()->format('Y-m-d') ? 'bg-green-500 animate-pulse' : 
                                       ($antrian->tanggal == now()->addDay()->format('Y-m-d') ? 'bg-yellow-500' : 'bg-blue-500') }} mr-3">
                                </div>
                                <span class="text-sm font-medium text-gray-700">
                                    @if($antrian->tanggal == now()->format('Y-m-d'))
                                        Antrian Hari Ini
                                    @elseif($antrian->tanggal == now()->addDay()->format('Y-m-d'))
                                        Antrian Besok
                                    @else
                                        Antrian Mendatang
                                    @endif
                                </span>
                            </div>
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full">
                                {{ \Carbon\Carbon::parse($antrian->tanggal)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Peserta -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle mr-3 text-fuchsia-600"></i>
                        Data Peserta
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tenaga Kerja -->
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                                <h3 class="font-semibold text-blue-700 mb-3 flex items-center">
                                    <i class="fas fa-hard-hat mr-2"></i>
                                    Tenaga Kerja
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">Nama Lengkap</label>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $antrian->nama_tk }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">NIK</label>
                                        <p class="mt-1 text-sm font-semibold text-gray-900 font-mono">{{ $antrian->nik_tk }}</p>
                                    </div>
                                    @if($antrian->alamat_tk)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">Alamat</label>
                                        <p class="mt-1 text-sm text-gray-700">{{ $antrian->alamat_tk }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ahli Waris -->
                        <div class="space-y-4">
                            <div class="p-4 bg-green-50 rounded-xl border-l-4 border-green-500">
                                <h3 class="font-semibold text-green-700 mb-3 flex items-center">
                                    <i class="fas fa-users mr-2"></i>
                                    Ahli Waris
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">Nama Lengkap</label>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $antrian->ahli_waris }}</p>
                                    </div>
                                    @if($antrian->hubungan_aw)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">Hubungan</label>
                                        <p class="mt-1 text-sm text-gray-700">{{ $antrian->hubungan_aw }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">No. WhatsApp</label>
                                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $antrian->no_hp }}</p>
                                    </div>
                                    @if($antrian->email_aw)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600">Email</label>
                                        <p class="mt-1 text-sm text-gray-700">{{ $antrian->email_aw }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-bolt mr-3 text-orange-600"></i>
                        Aksi Cepat
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="https://wa.me/{{ $antrian->no_hp }}?text=Halo%20{{ urlencode($antrian->ahli_waris) }}%2C%20kami%20dari%20BPJS%20Ketenagakerjaan%20ingin%20mengkonfirmasi%20antrian%20Anda."
                           target="_blank"
                           class="w-full flex items-center justify-between p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-all duration-200 group">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <i class="fas fa-comment text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Hubungi WhatsApp</p>
                                    <p class="text-xs text-gray-600">{{ $antrian->no_hp }}</p>
                                </div>
                            </div>
                            <i class="fas fa-external-link-alt text-gray-400 group-hover:text-green-600"></i>
                        </a>

                        <a href="{{ route('admin.antrian') }}"
                           class="w-full flex items-center justify-between p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-all duration-200 group">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <i class="fas fa-arrow-left text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Kembali ke Daftar</p>
                                    <p class="text-xs text-gray-600">Data antrian</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                        </a>

                        <form action="{{ route('admin.antrian.destroy', $antrian->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data antrian ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full flex items-center justify-between p-4 bg-red-50 rounded-xl hover:bg-red-100 transition-all duration-200 group">
                                <div class="flex items-center">
                                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                                        <i class="fas fa-trash text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Hapus Antrian</p>
                                        <p class="text-xs text-gray-600">Hapus permanen</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Timestamp -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clock mr-3 text-gray-600"></i>
                        Informasi Sistem
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-plus-circle text-green-500 mr-3"></i>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Dibuat</p>
                                    <p class="text-sm text-gray-900">{{ $antrian->created_at->translatedFormat('j M Y') }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $antrian->created_at->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-edit text-blue-500 mr-3"></i>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Diupdate</p>
                                    <p class="text-sm text-gray-900">{{ $antrian->updated_at->translatedFormat('j M Y') }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $antrian->updated_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6 card-hover">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-file-alt mr-3 text-rose-600"></i>
                Dokumen Pendukung
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Foto KTP -->
                <div class="text-center">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center justify-center">
                            <i class="fas fa-id-card mr-2 text-blue-500"></i>
                            Foto KTP Ahli Waris
                        </h3>
                        <p class="text-sm text-gray-600">Dokumen identitas resmi</p>
                    </div>
                    
                    @if($antrian->foto_ktp_aw && file_exists(public_path($antrian->foto_ktp_aw)))
                        @if(in_array(pathinfo($antrian->foto_ktp_aw, PATHINFO_EXTENSION), ['pdf']))
                            <div class="w-full h-64 bg-red-50 rounded-2xl border-2 border-red-200 flex flex-col items-center justify-center p-4">
                                <i class="fas fa-file-pdf text-6xl text-red-400 mb-4"></i>
                                <span class="text-red-600 font-semibold text-lg">File PDF</span>
                                <p class="text-red-500 text-sm mt-2 text-center">Dokumen dalam format PDF</p>
                                <a href="{{ url($antrian->foto_ktp_aw) }}" 
                                   target="_blank" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Buka PDF
                                </a>
                            </div>
                        @else
                            <div class="relative group">
                                <img src="{{ url($antrian->foto_ktp_aw) }}" 
                                    alt="Foto KTP Ahli Waris" 
                                    class="w-full h-64 object-cover rounded-2xl border-2 border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-2xl transition-all duration-300 flex items-center justify-center">
                                    <a href="{{ url($antrian->foto_ktp_aw) }}" 
                                       target="_blank"
                                       class="opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all duration-300 bg-white bg-opacity-90 p-3 rounded-full shadow-lg">
                                        <i class="fas fa-expand text-gray-700 text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-left">
                                <p class="text-sm font-medium text-gray-700 hidden md:block">{{ basename($antrian->foto_ktp_aw) }}</p>
                                @if(file_exists(public_path($antrian->foto_ktp_aw)))
                                    @php
                                        $size = filesize(public_path($antrian->foto_ktp_aw));
                                        $sizeKB = round($size / 1024, 2);
                                    @endphp
                                    <p class="text-xs text-gray-500 hidden md:block">{{ $sizeKB }} KB</p>
                                @endif
                            </div>
                            <a href="{{ url($antrian->foto_ktp_aw) }}" 
                               download 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-2xl flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="fas fa-file-image text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 font-medium">Dokumen tidak tersedia</p>
                            <p class="text-gray-400 text-sm mt-1">File belum diupload</p>
                        </div>
                    @endif
                </div>

                <!-- Foto Diri -->
                <div class="text-center">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center justify-center">
                            <i class="fas fa-user mr-2 text-green-500"></i>
                            Foto Diri Ahli Waris
                        </h3>
                        <p class="text-sm text-gray-600">Foto selfie dengan KTP</p>
                    </div>
                    
                    @if($antrian->foto_diri_aw && file_exists(public_path($antrian->foto_diri_aw)))
                        @if(in_array(pathinfo($antrian->foto_diri_aw, PATHINFO_EXTENSION), ['pdf']))
                            <div class="w-full h-64 bg-red-50 rounded-2xl border-2 border-red-200 flex flex-col items-center justify-center p-4">
                                <i class="fas fa-file-pdf text-6xl text-red-400 mb-4"></i>
                                <span class="text-red-600 font-semibold text-lg">File PDF</span>
                                <p class="text-red-500 text-sm mt-2 text-center">Dokumen dalam format PDF</p>
                                <a href="{{ url($antrian->foto_diri_aw) }}" 
                                   target="_blank" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Buka PDF
                                </a>
                            </div>
                        @else
                            <div class="relative group">
                                <img src="{{ url($antrian->foto_diri_aw) }}" 
                                    alt="Foto Diri Ahli Waris" 
                                    class="w-full h-64 object-cover rounded-2xl border-2 border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-2xl transition-all duration-300 flex items-center justify-center">
                                    <a href="{{ url($antrian->foto_diri_aw) }}" 
                                       target="_blank"
                                       class="opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all duration-300 bg-white bg-opacity-90 p-3 rounded-full shadow-lg">
                                        <i class="fas fa-expand text-gray-700 text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-left">
                                <p class="text-sm font-medium text-gray-700 hidden md:block">{{ basename($antrian->foto_diri_aw) }}</p>
                                @if(file_exists(public_path($antrian->foto_diri_aw)))
                                    @php
                                        $size = filesize(public_path($antrian->foto_diri_aw));
                                        $sizeKB = round($size / 1024, 2);
                                    @endphp
                                    <p class="text-xs text-gray-500 hidden md:block">{{ $sizeKB }} KB</p>
                                @endif
                            </div>
                            <a href="{{ url($antrian->foto_diri_aw) }}" 
                               download 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-2xl flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 font-medium">Foto tidak tersedia</p>
                            <p class="text-gray-400 text-sm mt-1">File belum diupload</p>
                        </div>
                    @endif
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

        // Add image zoom effect
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('click', function() {
                this.classList.toggle('cursor-zoom-out');
                this.classList.toggle('scale-150');
            });
        });
    });
</script>
@endpush