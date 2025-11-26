<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TanggalNonaktif;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TanggalNonaktifController extends Controller
{
    public function index()
    {
        $items = TanggalNonaktif::orderBy('tanggal', 'asc')->get();
        
        $today = Carbon::today();
        $thirtyDaysLater = Carbon::today()->addDays(30);
        
        $upcomingCount = TanggalNonaktif::where('tanggal', '>', $today)
            ->where('tanggal', '<=', $thirtyDaysLater)
            ->count();
            
        $thisMonthCount = TanggalNonaktif::whereYear('tanggal', $today->year)
            ->whereMonth('tanggal', $today->month)
            ->count();
            
        $isTodayDisabled = TanggalNonaktif::where('tanggal', $today)->exists();

        return view('admin.tanggal-nonaktif', compact(
            'items', 
            'upcomingCount', 
            'thisMonthCount', 
            'isTodayDisabled'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:tanggal_nonaktif,tanggal',
            'keterangan' => 'nullable|string|max:255'
        ]);

        TanggalNonaktif::create($request->only('tanggal', 'keterangan'));

        return back()->with('success', 'Tanggal nonaktif berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $tanggal = TanggalNonaktif::findOrFail($id);
        $tanggal->delete();

        return back()->with('success', 'Tanggal nonaktif berhasil dihapus!');
    }
}