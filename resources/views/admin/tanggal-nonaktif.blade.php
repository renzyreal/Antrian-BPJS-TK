@extends('layouts.admin')

@section('title', 'Tanggal Nonaktif')
@section('header-title', 'Pengaturan Tanggal Nonaktif')

@section('content')
<div class="space-y-6">

    {{-- FORM TAMBAH TANGGAL --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-3">Tambah Tanggal Nonaktif</h3>

        @if(session('success'))
            <div class="p-3 mb-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 mb-3 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tanggal.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan (opsional)</label>
                <input type="text" name="keterangan" class="w-full border rounded-lg px-3 py-2" placeholder="Contoh: Libur nasional / Maintenance server">
            </div>

            <div class="md:col-span-3">
                <button class="bg-pink-600 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-700">
                    Tambahkan
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL TANGGAL NONAKTIF --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Daftar Tanggal Nonaktif</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="border-b">
                    <tr>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Keterangan</th>
                        <th class="py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($items as $item)
                        <tr class="border-b">
                            <td class="py-3 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="py-3">{{ $item->keterangan ?? '-' }}</td>
                            <td class="py-3 text-center">
                                <form action="{{ route('admin.tanggal.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tanggal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">Belum ada tanggal nonaktif</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
