@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">

    <h2 class="text-2xl font-bold text-green-700 mb-4">Edit Profil</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.edit') }}" method="POST" class="space-y-4">
        @csrf

        <!-- NAMA -->
        <div>
            <label class="font-medium">Nama</label>
            <input type="text" name="nama" value="{{ $user->nama }}" required
                class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-green-500">
        </div>

        <!-- USERNAME -->
        <div>
            <label class="font-medium">Username</label>
            <input type="text" name="username" value="{{ $user->username }}" required
                class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-green-500">
        </div>

        <!-- PASSWORD BARU (OPSIONAL) -->
        <div>
            <label class="font-medium">Password Baru (opsional)</label>
            <input type="password" name="password_baru"
                placeholder="Kosongkan jika tidak ingin mengubah password"
                class="w-full border rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-green-500">
        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-md transition">
            Simpan Perubahan
        </button>

    </form>
</div>
@endsection
