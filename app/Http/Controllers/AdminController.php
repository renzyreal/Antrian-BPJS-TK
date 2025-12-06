<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\VerifikasiWA;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AntrianExport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    // ===============================
    //  DASHBOARD ADMIN
    // ===============================
    public function dashboard()
    {
        $today = Carbon::today('Asia/Makassar');
        $tomorrow = Carbon::tomorrow('Asia/Makassar');
        $startOfMonth = Carbon::now('Asia/Makassar')->startOfMonth();
        $startOfWeek = Carbon::now('Asia/Makassar')->startOfWeek();
        $lastMonthStart = Carbon::now('Asia/Makassar')->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now('Asia/Makassar')->subMonth()->endOfMonth();
        
        $stats = [
            'today' => Antrian::where('tanggal', $today)->count(),
            'tomorrow' => Antrian::where('tanggal', $tomorrow)->count(),
            'total' => Antrian::count(),
            'verified' => VerifikasiWA::where('terverifikasi', true)->count(),
            
            // Tambahan stats untuk trend comparison
            'this_month' => Antrian::whereBetween('tanggal', [$startOfMonth, $today])->count(),
            'this_week' => Antrian::whereBetween('tanggal', [$startOfWeek, $today])->count(),
            'last_month_total' => Antrian::whereBetween('tanggal', [$lastMonthStart, $lastMonthEnd])->count(),
            
            // Stats tambahan untuk informasi lebih detail
            'yesterday' => Antrian::where('tanggal', $today->copy()->subDay())->count(),
            'last_week_total' => Antrian::whereBetween('tanggal', [
                $startOfWeek->copy()->subWeek(),
                $startOfWeek->copy()->subDay()
            ])->count(),
        ];

        // Antrian hari ini
        $antrianHariIni = Antrian::where('tanggal', $today)
            ->orderBy('nomor')
            ->get();

        // Antrian besok
        $antrianBesok = Antrian::where('tanggal', $tomorrow)
            ->orderBy('nomor')
            ->get();

        return view('admin.dashboard', compact('stats', 'antrianHariIni', 'antrianBesok'));
    }

    // ===============================
    //  DATA ANTRIAN SEMUA
    // ===============================
    public function antrian(Request $request)
    {
        $query = Antrian::query();
        
        // Filter by tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $query->where('tanggal', $request->tanggal);
        }
        
        // Filter by status (hari ini, besok, semua)
        if ($request->has('filter') && $request->filter) {
            $today = Carbon::today('Asia/Makassar');
            
            switch ($request->filter) {
                case 'today':
                    $query->where('tanggal', $today);
                    break;
                case 'tomorrow':
                    $query->where('tanggal', Carbon::tomorrow('Asia/Makassar'));
                    break;
                case 'week':
                    $query->whereBetween('tanggal', [
                        $today,
                        $today->copy()->addDays(7)
                    ]);
                    break;
            }
        }

        $antrian = $query->orderBy('tanggal', 'desc')
            ->orderBy('nomor')
            ->paginate(15);

        return view('admin.antrian', compact('antrian'));
    }

    // ===============================
    //  DETAIL ANTRIAN
    // ===============================
    public function show($id)
    {
        $antrian = Antrian::findOrFail($id);
        
        return view('admin.detail', compact('antrian'));
    }

    // ===============================
    //  HAPUS ANTRIAN
    // ===============================
    public function destroy($id)
    {
        try {
            $antrian = Antrian::findOrFail($id);
            
            // Hapus file foto
            if ($antrian->foto_ktp_aw && Storage::disk('public')->exists($antrian->foto_ktp_aw)) {
                Storage::disk('public')->delete($antrian->foto_ktp_aw);
            }
            
            if ($antrian->foto_diri_aw && Storage::disk('public')->exists($antrian->foto_diri_aw)) {
                Storage::disk('public')->delete($antrian->foto_diri_aw);
            }
            
            $antrian->delete();
            
            return redirect()->route('admin.antrian')
                ->with('success', 'Data antrian berhasil dihapus.');
                
        } catch (\Exception $e) {
            \Log::error('Error hapus antrian: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus data antrian.');
        }
    }

    // ===============================
    //  DATA VERIFIKASI WA
    // ===============================
    public function verifikasi()
    {
        $verifikasi = VerifikasiWA::orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.verifikasi', compact('verifikasi'));
    }

    // ===============================
    //  FORM EXPORT DATA
    // ===============================
    public function exportForm()
    {
        return view('admin.export');
    }

    // ===============================
    //  DOWNLOAD EXPORT DATA EXCEL
    // ===============================
    public function exportDownload(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $tanggal = $request->tanggal;
        $filter = $request->filter;

        // Validasi: hanya satu jenis filter yang boleh digunakan
        $filterCount = 0;
        if ($startDate && $endDate) $filterCount++;
        if ($tanggal) $filterCount++;
        if ($filter) $filterCount++;

        if ($filterCount > 1) {
            return redirect()->route('admin.export.form')
                ->with('error', 'Hanya boleh menggunakan satu jenis filter. Pilih rentang tanggal ATAU tanggal tertentu ATAU filter cepat.');
        }

        // Handle quick export filters
        if ($filter) {
            $today = Carbon::today('Asia/Makassar');
            
            switch ($filter) {
                case 'today':
                    $tanggal = $today->format('Y-m-d');
                    break;
                case 'tomorrow':
                    $tanggal = $today->copy()->addDay()->format('Y-m-d');
                    break;
                case 'week':
                    $startDate = $today->copy()->subDays(6)->format('Y-m-d'); // 7 hari termasuk hari ini
                    $endDate = $today->format('Y-m-d');
                    break;
                case 'month':
                    $startDate = $today->copy()->startOfMonth()->format('Y-m-d');
                    $endDate = $today->copy()->endOfMonth()->format('Y-m-d');
                    break;
            }
        }

        // Generate filename berdasarkan filter yang digunakan
        if ($tanggal) {
            $filename = 'antrian_jkm_' . $tanggal . '_' . Carbon::now()->format('H-i-s') . '.xlsx';
        } elseif ($startDate && $endDate) {
            $filename = 'antrian_jkm_' . $startDate . '_to_' . $endDate . '.xlsx';
        } elseif ($filter) {
            $filename = 'antrian_jkm_' . $filter . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        } else {
            $filename = 'antrian_jkm_all_data_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        }

        return Excel::download(new AntrianExport($startDate, $endDate, $tanggal), $filename);
    }

    // ===============================
    //  CEK KUOTA ADMIN
    // ===============================
    public function kuotaAdmin(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today('Asia/Makassar')->format('Y-m-d');
        
        $antrian = Antrian::where('tanggal', $tanggal)
            ->orderBy('nomor')
            ->get();

        $blocks = [
            ['start' => '08:00', 'end' => '09:30', 'range' => [1,3], 'kuota' => 3],
            ['start' => '09:30', 'end' => '11:00', 'range' => [4,6], 'kuota' => 3],
            ['start' => '11:00', 'end' => '12:30', 'range' => [7,9], 'kuota' => 3],
            ['start' => '13:00', 'end' => '14:30', 'range' => [10,12], 'kuota' => 3],
            ['start' => '14:30', 'end' => '15:30', 'range' => [13,15], 'kuota' => 3],
        ];

        // Hitung kuota per blok
        foreach ($blocks as &$block) {
            $terisi = $antrian->whereBetween('nomor', $block['range'])->count();
            $block['terisi'] = $terisi;
            $block['tersisa'] = $block['kuota'] - $terisi;
            $block['persentase'] = round(($terisi / $block['kuota']) * 100);
        }

        $totalKuota = 15;
        $totalTerisi = $antrian->count();
        $totalTersisa = $totalKuota - $totalTerisi;

        return view('admin.kuota', compact(
            'antrian', 'blocks', 'tanggal', 
            'totalKuota', 'totalTerisi', 'totalTersisa'
        ));
    }

    // ===============================
    //  QR CODE - VIEW
    // ===============================
    public function qrCode()
    {
        // Generate QR Code untuk URL antrian
        $url = route('antrian.form');
        $qr = QrCode::size(300)->generate($url);
        
        // Stats untuk ditampilkan
        $stats = [
            'today' => Antrian::whereDate('tanggal', now()->format('Y-m-d'))->count(),
            'tomorrow' => Antrian::whereDate('tanggal', now()->addDay()->format('Y-m-d'))->count(),
        ];

        return view('admin.qr', compact('qr', 'stats'));
    }

    // ===============================
    //  QR CODE - DOWNLOAD/PRINT
    // ===============================
    public function qrCodeDownload()
    {
        // Generate QR Code untuk URL antrian
        $url = route('antrian.form');
        $qr = QrCode::size(400)->generate($url);

        return view('admin.qr-download', compact('qr'));
    }
}