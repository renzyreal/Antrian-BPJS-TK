<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password_baru' => 'nullable|min:6',
        ]);

        // Update nama & username
        $user->nama = $request->nama;
        $user->username = $request->username;

        // Jika password baru diisi, update
        if ($request->password_baru) {
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}
