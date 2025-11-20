@extends('layouts.admin')

@section('title', 'Data Antrian - Admin')
@section('header-title', 'Data Antrian')

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('admin.antrian') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                <select name="filter" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Semua</option>
                    <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="tomorrow" {{ request('filter') == 'tomorrow' ? 'selected' : '' }}>Besok</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>7 Hari ke Depan</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.antrian') }}" class="ml-2 bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                Total Data: {{ $antrian->total() }}
            </h2>
            <span class="text-sm text-gray-600">
                Menampilkan {{ $antrian->count() }} dari {{ $antrian->total() }} data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama TK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ahli Waris</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($antrian as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold 
                                {{ $item->tanggal == now()->format('Y-m-d') ? 'bg-red-100 text-red-800' : 
                                   ($item->tanggal == now()->addDay()->format('Y-m-d') ? 'bg-green-100 text-green-800' : 
                                   'bg-blue-100 text-blue-800') }}">
                                {{ $item->nomor }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $item->jam }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->nama_tk }}</div>
                            <div class="text-sm text-gray-500">NIK: {{ $item->nik_tk }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $item->ahli_waris }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->no_hp }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.antrian.show', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.antrian.destroy', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data antrian
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($antrian->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $antrian->links() }}
        </div>
        @endif
    </div>
@endsection