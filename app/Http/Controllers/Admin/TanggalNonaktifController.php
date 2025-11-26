<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TanggalNonaktif;
use Illuminate\Http\Request;

class TanggalNonaktifController extends Controller
{
    public function index()
    {
        $items = TanggalNonaktif::orderBy('tanggal', 'asc')->get();
        return view('admin.tanggal-nonaktif', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:tanggal_nonaktif,tanggal',
            'keterangan' => 'nullable|string'
        ]);

        TanggalNonaktif::create($request->only('tanggal', 'keterangan'));

        return back()->with('success', 'Tanggal berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        TanggalNonaktif::findOrFail($id)->delete();
        return back()->with('success', 'Tanggal berhasil dihapus!');
    }
}
