<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\VerifikasiWA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\TanggalNonaktif;


class AntrianController extends Controller
{
    public function getTanggalNonaktif()
    {
        return TanggalNonaktif::pluck('tanggal');
    }

    // ===============================
    //  QR CODE
    // ===============================
    public function qr()
    {
        $url = route('antrian.form');
        $qr = QrCode::size(300)->generate($url);

        return view('qr', compact('qr'));
    }

    // ===============================
    //  FORM
    // ===============================
    public function form()
    {
        $tanggalNonaktifDB = TanggalNonaktif::pluck('tanggal')->toArray();

        // Generate tanggal weekend selama 90 hari ke depan (opsional)
        $weekends = [];
        $start = now();
        $end = now();

        while ($start->lte($end)) {
            if ($start->isWeekend()) {
                $weekends[] = $start->format('Y-m-d');
            }
            $start->addDay();
        }

        // Gabungkan tanggal nonaktif + weekend
        $disabledDates = array_unique(array_merge($tanggalNonaktifDB, $weekends));

        return view('antrian.form', compact('disabledDates'));
    }


    // ===============================
    //  KIRIM KODE VERIFIKASI
    // ===============================
    public function kirimKodeVerifikasi(Request $request)
    {
        // Debug logging
        \Log::info('CSRF Debug - Header Token: ' . $request->header('X-CSRF-TOKEN'));
        \Log::info('CSRF Debug - Session Token: ' . csrf_token());
        \Log::info('CSRF Debug - Input Token: ' . $request->input('_token'));

        try {
            $request->validate([
                'no_hp' => 'required|string|max:20'
            ]);

            $no_hp = $this->formatNomorHP($request->no_hp);

            // Validasi format nomor
            if (!$this->validasiFormatNomor($no_hp)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format nomor WhatsApp tidak valid. Contoh: 081234567890'
                ], 422);
            }

            // Generate kode verifikasi (6 digit)
            $kode_verifikasi = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Hapus kode verifikasi sebelumnya untuk nomor ini
            VerifikasiWA::where('no_hp', $no_hp)->delete();

            // Simpan kode verifikasi
            $verifikasi = VerifikasiWA::create([
                'no_hp' => $no_hp,
                'kode_verifikasi' => $kode_verifikasi,
                'expired_at' => Carbon::now()->addMinutes(10) // 10 menit expiry
            ]);

            // Kirim kode via WhatsApp
            $berhasil = $this->kirimWhatsappKode($no_hp, $kode_verifikasi);

            if ($berhasil) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kode verifikasi telah dikirim via WhatsApp',
                    'no_hp' => $this->maskPhoneNumber($no_hp) // Mask nomor untuk display
                ]);
            } else {
                $verifikasi->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim kode verifikasi. Pastikan nomor WhatsApp aktif.'
                ], 500);
            }

        } catch (\Illuminate\Session\TokenMismatchException $e) {
            \Log::error('CSRF Token Mismatch: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan refresh halaman dan coba lagi.'
            ], 419);
            
        } catch (\Exception $e) {
            \Log::error('Error kirim kode verifikasi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    // ===============================
    //  VERIFIKASI KODE
    // ===============================
    public function verifikasiKode(Request $request)
    {
        try {
            $request->validate([
                'no_hp' => 'required|string|max:20',
                'kode_verifikasi' => 'required|string|size:6'
            ]);

            $no_hp = $this->formatNomorHP($request->no_hp);

            $verifikasi = VerifikasiWA::where('no_hp', $no_hp)
                ->where('kode_verifikasi', $request->kode_verifikasi)
                ->valid()
                ->first();

            if ($verifikasi) {
                // Update status terverifikasi
                $verifikasi->update(['terverifikasi' => true]);

                return response()->json([
                    'success' => true,
                    'message' => 'Nomor WhatsApp berhasil diverifikasi',
                    'token' => \Illuminate\Support\Str::random(32) // Token untuk frontend
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi salah atau sudah kedaluwarsa'
            ], 422);

        } catch (\Illuminate\Session\TokenMismatchException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan refresh halaman.'
            ], 419);
            
        } catch (\Exception $e) {
            \Log::error('Error verifikasi kode: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }

    // ===============================
    //  MASK NOMOR HP UNTUK DISPLAY
    // ===============================
    private function maskPhoneNumber($phone)
    {
        if (strlen($phone) <= 8) return $phone;
        
        $first = substr($phone, 0, 4);
        $last = substr($phone, -4);
        $mask = str_repeat('*', strlen($phone) - 8);
        
        return $first . $mask . $last;
    }

    // ===============================
    //  SIMPAN ANTRIAN (DENGAN VERIFIKASI) - UPDATED
    // ===============================
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_tk'      => 'required|string|max:255',
                'nik_tk'       => 'required|string|max:20',
                'ahli_waris'   => 'required|string|max:255',
                'no_hp'        => 'required|string|max:20',
                'foto_ktp_aw'  => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                'foto_diri_aw' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                'tanggal'      => 'required|date',
                'verifikasi_token' => 'required|string'
            ], [
                'foto_ktp_aw.required' => 'Foto KTP Ahli Waris wajib diupload',
                'foto_ktp_aw.mimes' => 'Format file KTP harus JPG, JPEG, PNG, atau PDF',
                'foto_ktp_aw.max' => 'Ukuran file KTP maksimal 2MB',
                'foto_diri_aw.required' => 'Foto Diri Ahli Waris wajib diupload',
                'foto_diri_aw.mimes' => 'Format file Foto Diri harus JPG, JPEG, PNG, atau PDF',
                'foto_diri_aw.max' => 'Ukuran file Foto Diri maksimal 2MB',
            ]);

            $no_hp = $this->formatNomorHP($request->no_hp);
            $nik_tk = $request->nik_tk;
            $tanggal = $request->tanggal;

            // Cek apakah nomor sudah terverifikasi dalam 24 jam terakhir
            $terverifikasi = VerifikasiWA::where('no_hp', $no_hp)
                ->where('terverifikasi', true)
                ->where('created_at', '>=', Carbon::now()->subHours(24))
                ->exists();

            if (!$terverifikasi) {
                return back()
                    ->withInput()
                    ->with('error', 'Nomor WhatsApp belum terverifikasi. Silakan verifikasi terlebih dahulu.');
            }

            // VALIDASI: Cek apakah NIK sudah pernah mengambil antrian di tanggal yang sama
            $nikSudahAda = Antrian::where('nik_tk', $nik_tk)
                ->where('tanggal', $tanggal)
                ->exists();

            if ($nikSudahAda) {
                return back()
                    ->withInput()
                    ->with('error', 'NIK ini sudah terdaftar mengambil antrian untuk tanggal ' . 
                           Carbon::parse($tanggal)->translatedFormat('j F Y') . 
                           '. Setiap NIK hanya boleh mengambil 1 antrian per hari.');
            }

            // Cek jika hari Sabtu/Minggu
            $dayOfWeek = Carbon::parse($tanggal)->dayOfWeek; 
            // 0 = Minggu, 6 = Sabtu

            if ($dayOfWeek == 0 || $dayOfWeek == 6) {
                return back()
                    ->withInput()
                    ->with('error', 'Tidak dapat mengambil antrian pada hari Sabtu atau Minggu.');
            }

            // Cek tanggal nonaktif (libur/kegiatan)
            $nonaktif = TanggalNonaktif::where('tanggal', $tanggal)->first();

            if ($nonaktif) {
                return back()
                    ->withInput()
                    ->with('error', "Tanggal $tanggal tidak tersedia untuk pengambilan antrian. Alasan: {$nonaktif->keterangan}");
            }

            // Hitung antrian hari itu max 15
            if (Antrian::where('tanggal', $tanggal)->count() >= 15) {
                return back()
                    ->withInput()
                    ->with('error', 'Kuota antrian JKM hari ini sudah penuh.');
            }

            // Tentukan nomor & jam
            $hasil = $this->tentukanNomorDanJam($tanggal);

            if (!$hasil) {
                return back()
                    ->withInput()
                    ->with('error', 'Kuota antrian untuk tanggal ini penuh.');
            }

            $nomor = $hasil['nomor'];
            $jam   = $hasil['jam'];

            // Upload foto ke folder public
            $fotoKtp = $this->uploadFileToPublic($request->file('foto_ktp_aw'), 'ktpahliwaris');
            $fotoDiri = $this->uploadFileToPublic($request->file('foto_diri_aw'), 'fotoahliwaris');

            // Simpan database
            $antrian = Antrian::create([
                'nama_tk'      => $request->nama_tk,
                'nik_tk'       => $nik_tk,
                'ahli_waris'   => $request->ahli_waris,
                'no_hp'        => $no_hp,
                'foto_ktp_aw'  => $fotoKtp,
                'foto_diri_aw' => $fotoDiri,
                'tanggal'      => $tanggal,
                'nomor'        => $nomor,
                'jam'          => $jam,
            ]);

            // Hapus data verifikasi setelah digunakan
            VerifikasiWA::where('no_hp', $no_hp)->delete();

            // Kirim WhatsApp konfirmasi antrian
            $this->kirimWhatsapp($antrian);

            return redirect()->route('antrian.form')
                ->with(
                    'success', 
                    "Antrian berhasil dibuat! Nomor: $nomor | Jam: $jam | Konfirmasi telah dikirim via WhatsApp."
                );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data Anda.');
                
        } catch (\Exception $e) {
            \Log::error('Error store antrian: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    // ===============================
    //  FUNGSI UPLOAD FILE KE FOLDER PUBLIC
    // ===============================
    private function uploadFileToPublic($file, $folder)
    {
        // Buat folder jika belum ada di public
        $folderPath = public_path($folder);
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // Generate nama file unik dengan ekstensi asli
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(20) . '_' . time() . '.' . $extension;

        // Pindahkan file ke folder public
        $file->move($folderPath, $fileName);

        // Return path yang disimpan di database (relative path)
        return $folder . '/' . $fileName;
    }

    // ===============================
    //  FUNGSI UNTUK MENDAPATKAN URL FILE
    // ===============================
    public function getFileUrl($filePath)
    {
        if (!$filePath) {
            return null;
        }

        // Untuk file di public folder, langsung return URL
        return url($filePath);
    }

    // ===============================
    //  FUNGSI UNTUK MENGHAPUS FILE
    // ===============================
    public function deleteFile($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            return unlink(public_path($filePath));
        }
        return false;
    }

    // ===============================
    //  FUNGSI UNTUK MENDAPATKAN UKURAN FILE
    // ===============================
    public function getFileSize($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            $size = filesize(public_path($filePath));
            return $this->formatBytes($size);
        }
        return '0 Bytes';
    }

    private function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $base = log($size, 1024);
            $suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
            return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
        }
        return '0 Bytes';
    }

    // ===============================
    //  FORMAT NOMOR HP
    // ===============================
    private function formatNomorHP($no_hp)
    {
        // Hapus semua karakter non-digit
        $no_hp = preg_replace('/[^0-9]/', '', $no_hp);
        
        // Jika diawali 0, ganti dengan 62
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }
        
        // Jika diawali 8, tambahkan 62
        if (substr($no_hp, 0, 1) === '8') {
            $no_hp = '62' . $no_hp;
        }

        return $no_hp;
    }

    // ===============================
    //  VALIDASI FORMAT NOMOR
    // ===============================
    private function validasiFormatNomor($no_hp)
    {
        // Format: 628xxxxxxxxxx (10-13 digit setelah 62)
        return preg_match('/^628[0-9]{8,11}$/', $no_hp);
    }

    // ===============================
    //  KIRIM KODE VERIFIKASI VIA WA
    // ===============================
    private function kirimWhatsappKode($no_hp, $kode)
    {
        $expiryTime = Carbon::now('Asia/Makassar')->addMinutes(2);

        $msg = "Kode Verifikasi Antrian JKM BPJS Ketenagakerjaan\n\n"
            . "Kode verifikasi Anda: *{$kode}*\n"
            . "Berlaku hingga: " . $expiryTime->format('H:i') . " WITA\n\n"
            . "Jangan berikan kode ini kepada siapapun.\n"
            . "Jika Anda tidak meminta kode ini, abaikan pesan ini.";

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post("https://api.fonnte.com/send", [
                'headers' => [
                    'Authorization' => env('FONNTE_TOKEN'),
                ],
                'form_params' => [
                    'target'  => $no_hp,
                    'message' => $msg,
                ],
                'timeout' => 10
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            \Log::error('Gagal kirim kode verifikasi: ' . $e->getMessage());
            return false;
        }
    }

    // ===============================
    //  TENTUKAN NOMOR & JAM (FINAL)
    // ===============================
    private function tentukanNomorDanJam($tanggal)
    {
        $now = Carbon::now('Asia/Makassar');

        $blocks = [
            ['start' => '08:00', 'end' => '09:30', 'range' => [1,3]],
            ['start' => '09:30', 'end' => '11:00', 'range' => [4,6]],
            ['start' => '11:00', 'end' => '12:30', 'range' => [7,9]],
            ['start' => '13:00', 'end' => '14:30', 'range' => [10,12]],
            ['start' => '14:30', 'end' => '15:30', 'range' => [13,15]],
        ];

        $used = Antrian::where('tanggal', $tanggal)->pluck('nomor')->toArray();

        foreach ($blocks as $b) {

            $start = Carbon::parse("$tanggal {$b['start']}", 'Asia/Makassar');
            $end   = Carbon::parse("$tanggal {$b['end']}", 'Asia/Makassar');

            // Jika tanggal hari ini dan waktu blok sudah lewat → skip
            if ($tanggal == $now->toDateString() && $now->gt($end)) {
                continue;
            }

            // Cari nomor kosong dalam range
            for ($n = $b['range'][0]; $n <= $b['range'][1]; $n++) {
                if (!in_array($n, $used)) {
                    return [
                        'nomor' => $n,
                        'jam'   => $b['start'].' - '.$b['end']
                    ];
                }
            }
        }

        return null; // penuh
    }

    // ===============================
    //  KIRIM WHATSAPP KONFIRMASI
    // ===============================
    private function kirimWhatsapp($data)
    {
        try {
            $phone = $data->no_hp;
            $tanggal = \Carbon\Carbon::parse($data->tanggal)
                ->locale('id')
                ->translatedFormat('j F Y');

            $msg = 
            "Data pengajuan *ANTRIAN JAMINAN KEMATIAN* anda sebagai berikut:\n\n"
            . "Nomor Antrian: *{$data->nomor}*\n"
            . "Nama Tenaga Kerja: *{$data->nama_tk}*\n"
            . "NIK Tenaga Kerja: *{$data->nik_tk}*\n"
            . "Ahli Waris: *{$data->ahli_waris}*\n"
            . "Jenis Klaim: *Informasi/ Klaim JKM (Jaminan Kematian)*\n"
            . "Tanggal Kedatangan: *{$tanggal}*\n"
            . "Jam kedatangan: *{$data->jam}*\n"
            . "Kantor Cabang: *Gorontalo*\n"
            . "Alamat Kantor: *Jl. Prof DR Jhon Ario Katili No. 22 Kota Gorontalo*\n\n"

            . "Pada saat jadwal kedatangan untuk dipersiapkan *DOKUMEN ASLI* dan fotocopy masing-masing 1 lembar.\n"
            . "Demi kelancaran proses klaim manfaat program BPJS Ketenagakerjaan,\n"
            . "Bapak/ Ibu *DIMOHON MEMPERHATIKAN* hal-hal sebagai berikut:\n\n"

            . "1. Bapak/ Ibu *WAJIB DATANG* ke Kantor Cabang yang telah dipilih 30 menit sebelum jam estimasi layanan yang telah ditentukan.\n"
            . "2. Jam estimasi layanan merupakan jam perkiraan Bapak/ Ibu mendapatkan layanan, kepastian layanan akan disesuaikan dengan antrian yang ada di Kantor Cabang.\n"
            . "3. Dalam hal jam kedatangan Bapak/ Ibu melewati jam estimasi layanan yang ditentukan dan antrian sedang dalam layanan bermasalah, maka Bapak/ Ibu akan dilayani sesuai antrian terakhir ketika datang ke kantor cabang yang dipilih.\n"
            . "4. Pastikan informasi nomor HP/WA/email yang bapak/ ibu berikan *BENAR dan WAJIB AKTIF*.\n"
            . "5. BPJS Ketenagakerjaan berhak *MEMBATALKAN* proses pengajuan jika:\n"
            . "   a. Ditemukan ketidaksesuaian dokumen dengan data peserta terdaftar.\n"
            . "   b. Peserta memalsukan dokumen persyaratan.\n"
            . "   c. Peserta tidak datang sesuai tanggal kedatangan yang telah ditentukan.\n"
            . "   d. Petugas kami *TIDAK MEMUNGUT BIAYA APAPUN* dari peserta selama proses klaim manfaat.\n\n"

            . "Terima kasih telah mengajukan antrian Informasi/ Klaim JKM.\n"
            . "*Pesan ini dikirimkan secara otomatis dan tidak untuk dibalas. Terima kasih.*";

            $client = new \GuzzleHttp\Client();
            $response = $client->post("https://api.fonnte.com/send", [
                'headers' => [
                    'Authorization' => env('FONNTE_TOKEN'),
                ],
                'form_params' => [
                    'target'  => $phone,
                    'message' => $msg,
                ],
                'timeout' => 15
            ]);

            \Log::info('WhatsApp berhasil dikirim ke: ' . $phone . ' Status: ' . $response->getStatusCode());

        } catch (\Exception $e) {
            \Log::error('Gagal kirim WA konfirmasi: ' . $e->getMessage());
            // Jangan return error ke user, cukup log saja
            // Biarkan antrian tetap tersimpan meski WA gagal
        }
    }

    public function cekKuota(Request $request)
    {
        $tanggal = $request->tanggal;
        $now = Carbon::now('Asia/Makassar');

        // Cek weekend
        $dayOfWeek = Carbon::parse($tanggal)->dayOfWeek;
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return response()->json([
                'tanggal' => $tanggal,
                'tersisa' => 0,
                'disabled' => true,
                'message' => 'Tanggal ini tidak tersedia (Weekend)'
            ]);
        }

        // Cek libur/kegiatan
        if (TanggalNonaktif::where('tanggal', $tanggal)->exists()) {
            return response()->json([
                'tanggal' => $tanggal,
                'tersisa' => 0,
                'disabled' => true,
                'message' => 'Tanggal ini dinonaktifkan oleh admin'
            ]);
        }


        $blocks = [
            ['start' => '08:00', 'end' => '09:30', 'range' => [1, 3]],
            ['start' => '09:30', 'end' => '11:00', 'range' => [4, 6]],
            ['start' => '11:00', 'end' => '12:30', 'range' => [7, 9]],
            ['start' => '13:00', 'end' => '14:30', 'range' => [10, 12]],
            ['start' => '14:30', 'end' => '15:30', 'range' => [13, 15]],
        ];

        $used = Antrian::where('tanggal', $tanggal)->pluck('nomor')->toArray();
        $available = 0;

        foreach ($blocks as $b) {

            $start = Carbon::parse("$tanggal {$b['start']}", 'Asia/Makassar');
            $end   = Carbon::parse("$tanggal {$b['end']}", 'Asia/Makassar');

            if ($tanggal == $now->toDateString() && $now->gt($end)) {
                continue;
            }

            for ($n = $b['range'][0]; $n <= $b['range'][1]; $n++) {
                if (!in_array($n, $used)) {
                    $available++;
                }
            }
        }

        return response()->json([
            'tanggal' => $tanggal,
            'tersisa' => $available
        ]);
    }
}