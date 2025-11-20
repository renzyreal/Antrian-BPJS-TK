@extends('layouts.admin')

@section('title', 'Detail Antrian - Admin')
@section('header-title', 'Detail Antrian')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Info Antrian -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Antrian</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center p-6 bg-blue-50 rounded-lg">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $antrian->nomor }}</div>
                    <div class="text-lg font-semibold text-gray-800">Nomor Antrian</div>
                </div>
                <div class="text-center p-6 bg-green-50 rounded-lg">
                    <div class="text-xl font-bold text-green-600 mb-2">{{ $antrian->jam }}</div>
                    <div class="text-lg font-semibold text-gray-800">Jam Kedatangan</div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <div class="text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($antrian->tanggal)->translatedFormat('l, j F Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Data Peserta -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Data Peserta</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Tenaga Kerja</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $antrian->nama_tk }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK Tenaga Kerja</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $antrian->nik_tk }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ahli Waris</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $antrian->ahli_waris }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $antrian->no_hp }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Foto -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Dokumen</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP Ahli Waris</label>
                    @if($antrian->foto_ktp_aw && file_exists(public_path($antrian->foto_ktp_aw)))
                        @if(in_array(pathinfo($antrian->foto_ktp_aw, PATHINFO_EXTENSION), ['pdf']))
                            <!-- Tampilkan icon PDF untuk file PDF -->
                            <div class="w-full h-64 bg-red-50 rounded-lg border-2 border-red-200 flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-red-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-600 font-medium">File PDF</span>
                                <a href="{{ url($antrian->foto_ktp_aw) }}" 
                                target="_blank" 
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm underline">
                                    Lihat PDF
                                </a>
                            </div>
                        @else
                            <!-- Tampilkan gambar untuk file image -->
                            <img src="{{ url($antrian->foto_ktp_aw) }}" 
                                alt="Foto KTP Ahli Waris" 
                                class="w-full h-64 object-cover rounded-lg border shadow-sm">
                        @endif
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">Foto tidak tersedia</span>
                        </div>
                    @endif
                    
                    @if($antrian->foto_ktp_aw)
                        <div class="mt-2 text-xs text-gray-600">
                            <span>File: {{ basename($antrian->foto_ktp_aw) }}</span>
                            @if(file_exists(public_path($antrian->foto_ktp_aw)))
                                @php
                                    $size = filesize(public_path($antrian->foto_ktp_aw));
                                    $sizeKB = round($size / 1024, 2);
                                @endphp
                                <span class="ml-2">({{ $sizeKB }} KB)</span>
                            @endif
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Diri Ahli Waris</label>
                    @if($antrian->foto_diri_aw && file_exists(public_path($antrian->foto_diri_aw)))
                        @if(in_array(pathinfo($antrian->foto_diri_aw, PATHINFO_EXTENSION), ['pdf']))
                            <!-- Tampilkan icon PDF untuk file PDF -->
                            <div class="w-full h-64 bg-red-50 rounded-lg border-2 border-red-200 flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-red-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-600 font-medium">File PDF</span>
                                <a href="{{ url($antrian->foto_diri_aw) }}" 
                                target="_blank" 
                                class="mt-2 text-blue-600 hover:text-blue-800 text-sm underline">
                                    Lihat PDF
                                </a>
                            </div>
                        @else
                            <!-- Tampilkan gambar untuk file image -->
                            <img src="{{ url($antrian->foto_diri_aw) }}" 
                                alt="Foto Diri Ahli Waris" 
                                class="w-full h-64 object-cover rounded-lg border shadow-sm">
                        @endif
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">Foto tidak tersedia</span>
                        </div>
                    @endif
                    
                    @if($antrian->foto_diri_aw)
                        <div class="mt-2 text-xs text-gray-600">
                            <span>File: {{ basename($antrian->foto_diri_aw) }}</span>
                            @if(file_exists(public_path($antrian->foto_diri_aw)))
                                @php
                                    $size = filesize(public_path($antrian->foto_diri_aw));
                                    $sizeKB = round($size / 1024, 2);
                                @endphp
                                <span class="ml-2">({{ $sizeKB }} KB)</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Download All Button -->
            @if($antrian->foto_ktp_aw || $antrian->foto_diri_aw)
            <div class="mt-6 flex justify-end">
                <div class="flex space-x-3">
                    @if($antrian->foto_ktp_aw && file_exists(public_path($antrian->foto_ktp_aw)))
                    <a href="{{ url($antrian->foto_ktp_aw) }}" 
                    download 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download KTP
                    </a>
                    @endif
                    
                    @if($antrian->foto_diri_aw && file_exists(public_path($antrian->foto_diri_aw)))
                    <a href="{{ url($antrian->foto_diri_aw) }}" 
                    download 
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Foto Diri
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Timestamp -->
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Sistem</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="font-medium text-gray-700">Dibuat Pada:</label>
                    <p class="text-gray-900">{{ $antrian->created_at->translatedFormat('l, j F Y H:i:s') }}</p>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Diupdate Pada:</label>
                    <p class="text-gray-900">{{ $antrian->updated_at->translatedFormat('l, j F Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection