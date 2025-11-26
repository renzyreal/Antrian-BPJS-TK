<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrian JKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #f6339a 0%, #ec4899 100%);
        }
        
        .gradient-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .gradient-button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .gradient-button-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .gradient-button-blue:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }
        
        .gradient-button-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .gradient-button-green:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .input-focus:focus {
            border-color: #f6339a;
            box-shadow: 0 0 0 3px rgba(246, 51, 154, 0.1);
        }
        
        .success-border {
            border-color: #10b981;
        }
        
        .error-border {
            border-color: #ef4444;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Notifikasi styling */
        .field-notification {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
        }
        
        .field-notification.show {
            opacity: 1;
            transform: translateY(0);
            max-height: 50px;
        }
        
        .shake-animation {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Toast Notification */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }
        
        .toast-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .mobile-padding {
                padding: 1rem;
            }
            
            .mobile-text {
                font-size: 0.875rem;
            }
            
            .mobile-stack {
                flex-direction: column;
            }
            
            .mobile-stack > * {
                width: 100%;
            }
            
            .mobile-stack-space > * + * {
                margin-top: 0.5rem;
            }
            
            .toast-notification {
                top: 10px;
                right: 10px;
                left: 10px;
            }
        }
        
        @media (min-width: 641px) and (max-width: 1024px) {
            .tablet-max-width {
                max-width: 90%;
            }
        }
        
        @media (min-width: 1025px) {
            .desktop-max-width {
                max-width: 42rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-2 sm:p-4 md:p-6">
    <!-- Toast Notification -->
    <div id="toast-notification" class="toast-notification">
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg max-w-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                <div>
                    <h3 class="font-semibold" id="toast-title">Perhatian!</h3>
                    <p class="text-sm mt-1" id="toast-message">Ada field yang harus diperbaiki sebelum mengirim form.</p>
                </div>
                <button type="button" id="toast-close" class="ml-auto text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="w-full desktop-max-width tablet-max-width">
        <!-- Header Card -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-t-xl sm:rounded-t-2xl shadow-lg p-4 sm:p-6 text-center">
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="bg-white/20 p-2 sm:p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold">Form Antrian JKM</h1>
                    <p class="text-green-100 text-xs sm:text-sm md:text-base">BPJS Ketenagakerjaan</p>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-b-xl sm:rounded-b-2xl shadow-lg overflow-hidden">
            <div class="mobile-padding p-4 sm:p-6 md:p-8">
                {{-- Alerts --}}
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6 shadow-sm">
                        <div class="flex items-start sm:items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-700 font-medium mobile-text sm:text-base">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6 shadow-sm">
                        <div class="flex items-start sm:items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-700 font-medium mobile-text sm:text-base">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6 shadow-sm">
                        <div class="flex items-start sm:items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-500 text-lg sm:text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-red-700 font-medium mobile-text sm:text-base">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside mt-1 ml-2 text-red-600 mobile-text sm:text-sm">
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('antrian.store') }}" method="POST" enctype="multipart/form-data" id="antrianForm">
                    @csrf

                    <!-- NAMA -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-user mr-2 text-green-500"></i>Nama Tenaga Kerja <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_tk" id="nama_tk" 
                               class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base" 
                               required value="{{ old('nama_tk') }}" 
                               oninput="this.value = this.value.toUpperCase(); validateField(this, 'nama')"
                               onblur="validateField(this, 'nama')"
                               pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi diperbolehkan"
                               placeholder="Masukkan nama lengkap">
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Otomatis huruf besar
                        </small>
                        <div id="nama-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Nama Tenaga Kerja harus diisi</span>
                            </div>
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-id-card mr-2 text-green-500"></i>NIK Tenaga Kerja <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik_tk" id="nik_tk" 
                               class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base" 
                               required value="{{ old('nik_tk') }}"
                               pattern="[0-9]{16}" 
                               title="NIK harus 16 digit angka"
                               maxlength="16"
                               oninput="validateNIK(this)"
                               onblur="validateField(this, 'nik')"
                               placeholder="Masukkan 16 digit NIK">
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Harus tepat 16 digit angka
                        </small>
                        <div id="nik-error" class="text-red-500 mobile-text mt-1 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span></span>
                        </div>
                        <div id="nik-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">NIK harus 16 digit angka</span>
                            </div>
                        </div>
                    </div>

                    <!-- AHLI WARIS -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-users mr-2 text-green-500"></i>Nama Ahli Waris <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ahli_waris" id="ahli_waris" 
                               class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base" 
                               required value="{{ old('ahli_waris') }}"
                               oninput="this.value = this.value.toUpperCase(); validateField(this, 'ahli_waris')"
                               onblur="validateField(this, 'ahli_waris')"
                               pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi diperbolehkan"
                               placeholder="Masukkan nama ahli waris">
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Otomatis huruf besar
                        </small>
                        <div id="ahli_waris-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Nama Ahli Waris harus diisi</span>
                            </div>
                        </div>
                    </div>

                    <!-- NO HP dengan VERIFIKASI -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fab fa-whatsapp mr-2 text-green-500"></i>Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                        </label>
                        <div class="flex mobile-stack mobile-stack-space sm:flex-row sm:space-x-2">
                            <input type="text" name="no_hp" id="no_hp" placeholder="08xxxxxxxxxx" 
                                   class="flex-1 border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base" 
                                   required value="{{ old('no_hp') }}"
                                   pattern="08[0-9]{8,11}" title="Format: 08xxxxxxxxxx"
                                   onblur="validateField(this, 'no_hp')">
                            <button type="button" id="btn-kirim-kode" 
                                    class="gradient-button-blue text-white px-4 py-3 rounded-lg whitespace-nowrap transition duration-200 font-medium mobile-text sm:text-base mt-2 sm:mt-0">
                                <i class="fas fa-paper-plane mr-1"></i> <span class="hidden sm:inline">Kirim</span> Kode
                            </button>
                        </div>
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Pastikan nomor WhatsApp aktif dan benar
                        </small>
                        <div id="no_hp-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Nomor WhatsApp harus diisi dengan format yang benar</span>
                            </div>
                        </div>
                    </div>

                    <!-- VERIFIKASI KODE -->
                    <div class="mb-4 sm:mb-6 hidden" id="verifikasi-group">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-shield-alt mr-2 text-blue-500"></i>Kode Verifikasi <span class="text-red-500">*</span>
                        </label>
                        <div class="flex mobile-stack mobile-stack-space sm:flex-row sm:space-x-2">
                            <input type="text" name="kode_verifikasi" id="kode_verifikasi" 
                                   placeholder="6 digit kode" maxlength="6"
                                   class="flex-1 border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base"
                                   pattern="[0-9]{6}" title="6 digit angka"
                                   onblur="validateField(this, 'kode_verifikasi')">
                            <button type="button" id="btn-verifikasi-kode" 
                                    class="gradient-button-green text-white px-4 py-3 rounded-lg whitespace-nowrap transition duration-200 font-medium mobile-text sm:text-base mt-2 sm:mt-0">
                                <i class="fas fa-check mr-1"></i> Verifikasi
                            </button>
                        </div>
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Masukkan 6 digit kode yang dikirim via WhatsApp
                        </small>
                        <div id="timer-info" class="text-sm text-orange-600 mt-1 hidden flex items-center mobile-text">
                            <i class="fas fa-clock mr-1"></i>
                            <span></span>
                        </div>
                        <div id="kode_verifikasi-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Kode verifikasi harus 6 digit angka</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="verifikasi_token" id="verifikasi_token">

                    <!-- FOTO KTP -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-id-card mr-2 text-green-500"></i>Upload Foto KTP Ahli Waris <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="foto_ktp_aw" accept="image/*" 
                                   class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 file:mr-2 file:py-2 file:px-3 sm:file:px-4 file:rounded-full file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mobile-text sm:text-base" 
                                   required onchange="validateFile(this, 'ktp')">
                        </div>
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Format: JPG, PNG, JPEG (Maks. 2MB)
                        </small>
                        <div id="ktp-error" class="text-red-500 mobile-text mt-1 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span></span>
                        </div>
                        <div id="foto_ktp_aw-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Foto KTP harus diunggah</span>
                            </div>
                        </div>
                    </div>

                    <!-- FOTO DIRI -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-camera mr-2 text-green-500"></i>Upload Foto Diri Ahli Waris <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="foto_diri_aw" accept="image/*" 
                                   class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 file:mr-2 file:py-2 file:px-3 sm:file:px-4 file:rounded-full file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mobile-text sm:text-base" 
                                   required onchange="validateFile(this, 'diri')">
                        </div>
                        <small class="text-gray-500 mobile-text mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Format: JPG, PNG, JPEG (Maks. 2MB)
                        </small>
                        <div id="diri-error" class="text-red-500 mobile-text mt-1 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span></span>
                        </div>
                        <div id="foto_diri_aw-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Foto diri harus diunggah</span>
                            </div>
                        </div>
                    </div>

                    <!-- TANGGAL -->
                    <div class="mb-4 sm:mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 mobile-text sm:text-base">
                            <i class="fas fa-calendar-alt mr-2 text-green-500"></i>Tanggal Antrian <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="tanggal" id="tanggal"
                            class="w-full border border-gray-300 p-3 rounded-lg input-focus transition duration-200 mobile-text sm:text-base"
                            placeholder="Pilih tanggal"
                            required
                            onchange="validateField(this, 'tanggal')">

                        <div id="tanggal-notification" class="field-notification mt-2">
                            <div class="flex items-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="text-sm">Tanggal antrian harus dipilih</span>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Ambil tanggal nonaktif dari controller
                        const disabledDates = @json($disabledDates); 
                        // contoh: ["2025-01-10", "2025-01-15"]

                        flatpickr("#tanggal", {
                            dateFormat: "Y-m-d",
                            minDate: "today",
                            disableMobile: true, // agar tampilan sama di semua device
                            disable: [
                                function(date) {
                                    // Disable weekend
                                    return (date.getDay() === 0 || date.getDay() === 6);
                                },
                                ...disabledDates
                            ],
                            locale: {
                                firstDayOfWeek: 1 // Senin awal minggu
                            }
                        });
                    </script>


                    <!-- KUOTA -->
                    <div class="mb-4 sm:mb-6">
                        <div id="kuotaInfo" class="text-center p-3 sm:p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-sync-alt animate-spin mr-2 text-blue-500"></i>
                                <span class="text-blue-600 font-medium mobile-text sm:text-base">Memeriksa ketersediaan antrian...</span>
                            </div>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" id="submitBtn" 
                            class="w-full gradient-button text-white p-3 sm:p-4 rounded-xl font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed transition duration-200 flex items-center justify-center pulse-animation mobile-text sm:text-base">
                        <span id="submitText" class="flex items-center">
                            <i class="fas fa-ticket-alt mr-2"></i> Ambil Antrian
                        </span>
                        <div id="submitLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <p class="text-center text-red-600 mt-3 sm:mt-4 flex items-center justify-center mobile-text sm:text-sm">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Pastikan semua form telah diisi dengan benar sebelum mengambil antrian.
                    </p>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 border-t border-gray-200 p-3 sm:p-4 text-center">
                <p class="text-gray-600 mobile-text sm:text-sm">
                    &copy; {{ date('Y') }} Antrian JKM BPJS Ketenagakerjaan
                </p>
            </div>
        </div>
    </div>

    <script>
    // Fungsi untuk menampilkan toast notification
    function showToast(title, message, type = 'error') {
        const toast = document.getElementById('toast-notification');
        const toastTitle = document.getElementById('toast-title');
        const toastMessage = document.getElementById('toast-message');
        
        // Set warna berdasarkan type
        if (type === 'error') {
            toast.querySelector('div').className = 'bg-red-500 text-white p-4 rounded-lg shadow-lg max-w-sm';
        } else if (type === 'success') {
            toast.querySelector('div').className = 'bg-green-500 text-white p-4 rounded-lg shadow-lg max-w-sm';
        } else if (type === 'warning') {
            toast.querySelector('div').className = 'bg-yellow-500 text-white p-4 rounded-lg shadow-lg max-w-sm';
        }
        
        toastTitle.textContent = title;
        toastMessage.textContent = message;
        toast.classList.add('show');
        
        // Auto hide setelah 5 detik
        setTimeout(() => {
            hideToast();
        }, 5000);
    }

    // Fungsi untuk menyembunyikan toast
    function hideToast() {
        const toast = document.getElementById('toast-notification');
        toast.classList.remove('show');
    }

    // Fungsi untuk validasi field dan menampilkan notifikasi
    function validateField(input, fieldName) {
        const notification = document.getElementById(`${fieldName}-notification`);
        const value = input.value.trim();
        let isValid = true;
        let message = '';

        switch(fieldName) {
            case 'nama':
            case 'ahli_waris':
                isValid = value.length > 0 && /^[A-Z\s]+$/.test(value);
                message = 'Field harus diisi dan hanya mengandung huruf dan spasi';
                break;
            case 'nik':
                isValid = value.length === 16 && /^[0-9]+$/.test(value);
                message = 'NIK harus 16 digit angka';
                break;
            case 'no_hp':
                isValid = /^08[0-9]{8,11}$/.test(value);
                message = 'Nomor WhatsApp harus sesuai format (08xxxxxxxxxx)';
                break;
            case 'kode_verifikasi':
                isValid = value.length === 6 && /^[0-9]+$/.test(value);
                message = 'Kode verifikasi harus 6 digit angka';
                break;
            case 'tanggal':
                isValid = value.length > 0;
                message = 'Tanggal harus dipilih';
                break;
            case 'foto_ktp_aw':
            case 'foto_diri_aw':
                isValid = input.files.length > 0;
                message = `File ${fieldName.replace('foto_', '').replace('_aw', '')} harus diunggah`;
                break;
        }

        if (!isValid && value.length > 0) {
            // Jika field sudah diisi tapi tidak valid
            showNotification(notification, message);
            input.classList.add('error-border');
            input.classList.remove('success-border');
            input.classList.add('shake-animation');
            setTimeout(() => input.classList.remove('shake-animation'), 500);
        } else if (!isValid && input.hasAttribute('required')) {
            // Jika field required tapi kosong
            showNotification(notification, 'Field ini harus diisi');
            input.classList.add('error-border');
            input.classList.remove('success-border');
        } else {
            // Jika valid
            hideNotification(notification);
            input.classList.remove('error-border');
            input.classList.add('success-border');
        }

        return isValid;
    }

    // Fungsi untuk menampilkan notifikasi
    function showNotification(notificationElement, message) {
        if (notificationElement) {
            const messageElement = notificationElement.querySelector('span');
            if (messageElement) {
                messageElement.textContent = message;
            }
            notificationElement.classList.add('show');
        }
    }

    // Fungsi untuk menyembunyikan notifikasi
    function hideNotification(notificationElement) {
        if (notificationElement) {
            notificationElement.classList.remove('show');
        }
    }

    // Validasi NIK
    function validateNIK(input) {
        const nik = input.value.replace(/\D/g, ''); // Hapus non-digit
        const nikError = document.getElementById('nik-error');
        const notification = document.getElementById('nik-notification');
        
        // Batasi hanya 16 digit
        if (nik.length > 16) {
            input.value = nik.substring(0, 16);
        } else {
            input.value = nik;
        }
        
        // Tampilkan error jika kurang dari 16 digit
        if (nik.length < 16 && nik.length > 0) {
            nikError.textContent = 'NIK harus tepat 16 digit angka';
            nikError.classList.remove('hidden');
            showNotification(notification, 'NIK harus tepat 16 digit angka');
            input.classList.add('error-border');
            input.classList.remove('success-border');
        } else if (nik.length === 16) {
            nikError.classList.add('hidden');
            hideNotification(notification);
            input.classList.remove('error-border');
            input.classList.add('success-border');
        } else {
            nikError.classList.add('hidden');
            if (input.hasAttribute('required') && nik.length === 0) {
                showNotification(notification, 'NIK harus diisi');
                input.classList.add('error-border');
            } else {
                hideNotification(notification);
                input.classList.remove('error-border', 'success-border');
            }
        }
    }

    // Validasi file upload
    function validateFile(input, type) {
        const file = input.files[0];
        const errorElement = document.getElementById(`${type}-error`);
        const fieldName = input.name;
        const notification = document.getElementById(`${fieldName}-notification`);
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        
        if (file) {
            // Validasi tipe file
            if (!allowedTypes.includes(file.type)) {
                errorElement.textContent = 'Format file harus JPG, PNG, atau JPEG';
                errorElement.classList.remove('hidden');
                showNotification(notification, 'Format file harus JPG, PNG, atau JPEG');
                input.value = '';
                input.classList.add('error-border');
                return false;
            }
            
            // Validasi ukuran file
            if (file.size > maxSize) {
                errorElement.textContent = 'Ukuran file maksimal 2MB';
                errorElement.classList.remove('hidden');
                showNotification(notification, 'Ukuran file maksimal 2MB');
                input.value = '';
                input.classList.add('error-border');
                return false;
            }
            
            // Jika valid
            errorElement.classList.add('hidden');
            hideNotification(notification);
            input.classList.remove('error-border');
            input.classList.add('success-border');
        } else {
            // Jika tidak ada file
            if (input.hasAttribute('required')) {
                showNotification(notification, 'File harus diunggah');
                input.classList.add('error-border');
            }
        }
        
        return true;
    }

    // Auto uppercase untuk input nama
    function setupAutoUppercase() {
        const namaInputs = ['nama_tk', 'ahli_waris'];
        
        namaInputs.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                // Saat input berubah
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
                
                // Saat paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                    this.value = pastedText.toUpperCase();
                });
            }
        });
    }

    $(document).ready(function() {
        let timer;
        let timeLeft = 120;
        let isVerified = false;

        // Element references
        const btnKirimKode = $('#btn-kirim-kode');
        const btnVerifikasi = $('#btn-verifikasi-kode');
        const verifikasiGroup = $('#verifikasi-group');
        const noHpInput = $('#no_hp');
        const kodeInput = $('#kode_verifikasi');
        const tokenInput = $('#verifikasi_token');
        const timerInfo = $('#timer-info');
        const submitBtn = $('#submitBtn');
        const antrianForm = $('#antrianForm');
        const nikInput = $('#nik_tk');

        // Setup auto uppercase
        setupAutoUppercase();

        // Event listener untuk tombol close toast
        $('#toast-close').on('click', function() {
            hideToast();
        });

        // Disable submit button initially
        submitBtn.prop('disabled', true);

        // Cek kuota function
        function cekKuota() {
            let tgl = $('#tanggal').val();

            $.get("{{ route('antrian.kuota') }}", { tanggal: tgl }, function(res) {
                if (res.tersisa <= 0) {
                    $('#kuotaInfo').html(`
                        <div class="flex items-center justify-center text-red-600">
                            <i class="fas fa-times-circle mr-2"></i>
                            <span class="font-medium mobile-text sm:text-base">Antrian habis untuk tanggal ini, silakan pilih tanggal lain</span>
                        </div>
                    `);
                    submitBtn.prop('disabled', true);
                    submitBtn.removeClass('pulse-animation');
                } else {
                    $('#kuotaInfo').html(`
                        <div class="flex items-center justify-center text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="font-medium mobile-text sm:text-base">Sisa antrian: ${res.tersisa}</span>
                        </div>
                    `);
                    // Only enable if WhatsApp is verified dan NIK valid
                    const isNIKValid = nikInput.val().length === 16;
                    submitBtn.prop('disabled', !(isVerified && isNIKValid));
                    
                    if (isVerified && isNIKValid) {
                        submitBtn.addClass('pulse-animation');
                    } else {
                        submitBtn.removeClass('pulse-animation');
                    }
                }
            }).fail(function() {
                $('#kuotaInfo').html(`
                    <div class="flex items-center justify-center text-red-600">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-medium mobile-text sm:text-base">Gagal memuat informasi antrian</span>
                    </div>
                `);
            });
        }

        // Validasi form sebelum submit
        function validateForm() {
            let isValid = true;
            let firstErrorField = null;
            const fields = [
                { id: 'nama_tk', name: 'nama', label: 'Nama Tenaga Kerja' },
                { id: 'nik_tk', name: 'nik', label: 'NIK' },
                { id: 'ahli_waris', name: 'ahli_waris', label: 'Nama Ahli Waris' },
                { id: 'no_hp', name: 'no_hp', label: 'Nomor WhatsApp' },
                { id: 'tanggal', name: 'tanggal', label: 'Tanggal Antrian' },
                { id: 'foto_ktp_aw', name: 'foto_ktp_aw', label: 'Foto KTP' },
                { id: 'foto_diri_aw', name: 'foto_diri_aw', label: 'Foto Diri' }
            ];

            // Validasi semua field
            fields.forEach(field => {
                const input = document.getElementById(field.id);
                if (input && !validateField(input, field.name)) {
                    isValid = false;
                    // Simpan field error pertama untuk auto scroll
                    if (!firstErrorField) {
                        firstErrorField = { input: input, label: field.label };
                    }
                }
            });

            // Validasi khusus NIK
            const nik = nikInput.val();
            if (nik.length !== 16) {
                showNotification(document.getElementById('nik-notification'), 'NIK harus tepat 16 digit angka');
                nikInput.classList.add('shake-animation');
                setTimeout(() => nikInput.classList.remove('shake-animation'), 500);
                isValid = false;
                if (!firstErrorField) {
                    firstErrorField = { input: nikInput[0], label: 'NIK' };
                }
            }

            if (!isVerified) {
                showToast('Verifikasi WhatsApp', 'Silakan verifikasi nomor WhatsApp terlebih dahulu sebelum mengambil antrian.', 'warning');
                if (!firstErrorField) {
                    firstErrorField = { input: noHpInput[0], label: 'Nomor WhatsApp' };
                }
                isValid = false;
            }

            if (!tokenInput.val() && isVerified) {
                showToast('Token Tidak Valid', 'Token verifikasi tidak valid. Silakan verifikasi ulang nomor WhatsApp.', 'error');
                isValid = false;
            }

            // Jika ada error, tampilkan toast dan scroll ke field pertama yang error
            if (!isValid && firstErrorField) {
                const errorCount = fields.filter(field => {
                    const input = document.getElementById(field.id);
                    return input && !validateField(input, field.name);
                }).length;

                showToast(
                    'Perbaiki Form Terlebih Dahulu', 
                    `Ada ${errorCount} field yang perlu diperbaiki sebelum mengambil antrian.`, 
                    'error'
                );

                // Auto scroll ke field yang error
                setTimeout(() => {
                    firstErrorField.input.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                    
                    // Tambah efek highlight
                    firstErrorField.input.classList.add('shake-animation');
                    firstErrorField.input.focus();
                    
                    // Hapus efek setelah beberapa detik
                    setTimeout(() => {
                        firstErrorField.input.classList.remove('shake-animation');
                    }, 1000);
                }, 300);
            }

            return isValid;
        }

        // Kirim kode verifikasi
        btnKirimKode.on('click', function() {
            const noHp = noHpInput.val().trim();
            
            if (!noHp) {
                showNotification(document.getElementById('no_hp-notification'), 'Nomor WhatsApp harus diisi');
                noHpInput.classList.add('shake-animation');
                setTimeout(() => noHpInput.classList.remove('shake-animation'), 500);
                noHpInput.focus();
                showToast('Nomor WhatsApp Kosong', 'Harap isi nomor WhatsApp terlebih dahulu.', 'warning');
                return;
            }

            // Validasi format nomor sederhana
            if (!/^08[0-9]{8,11}$/.test(noHp)) {
                showNotification(document.getElementById('no_hp-notification'), 'Format nomor WhatsApp tidak valid. Contoh: 081234567890');
                noHpInput.classList.add('shake-animation');
                setTimeout(() => noHpInput.classList.remove('shake-animation'), 500);
                noHpInput.focus();
                showToast('Format Nomor Salah', 'Format nomor WhatsApp tidak valid. Contoh: 081234567890', 'error');
                return;
            }

            // Disable button dan show loading
            btnKirimKode.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> <span class="hidden sm:inline">Mengirim</span>...');

            // Gunakan FormData untuk menghindari preflight issues
            const formData = new FormData();
            formData.append('no_hp', noHp);
            formData.append('_token', "{{ csrf_token() }}");

            fetch("{{ route('antrian.kirim-verifikasi') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.status === 419) {
                    throw new Error('SESSION_EXPIRED');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Kode Dikirim', 'Kode verifikasi telah dikirim via WhatsApp ke ' + (data.no_hp || noHp), 'success');
                    verifikasiGroup.removeClass('hidden');
                    startTimer();
                } else {
                    showToast('Gagal Mengirim Kode', 'Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                if (error.message === 'SESSION_EXPIRED') {
                    showToast('Session Expired', 'Session expired. Silakan refresh halaman.', 'error');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast('Kesalahan Jaringan', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                }
            })
            .finally(() => {
                btnKirimKode.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> <span class="hidden sm:inline">Kirim</span> Kode');
            });
        });

        // Verifikasi kode
        btnVerifikasi.on('click', function() {
            const noHp = noHpInput.val().trim();
            const kode = kodeInput.val().trim();

            if (!kode || kode.length !== 6) {
                showNotification(document.getElementById('kode_verifikasi-notification'), 'Masukkan 6 digit kode verifikasi');
                kodeInput.classList.add('shake-animation');
                setTimeout(() => kodeInput.classList.remove('shake-animation'), 500);
                kodeInput.focus();
                showToast('Kode Verifikasi', 'Masukkan 6 digit kode verifikasi yang dikirim via WhatsApp.', 'warning');
                return;
            }

            btnVerifikasi.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memverifikasi...');

            // Gunakan FormData
            const formData = new FormData();
            formData.append('no_hp', noHp);
            formData.append('kode_verifikasi', kode);
            formData.append('_token', "{{ csrf_token() }}");

            fetch("{{ route('antrian.verifikasi-kode') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.status === 419) {
                    throw new Error('SESSION_EXPIRED');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Verifikasi Berhasil', 'Nomor WhatsApp berhasil diverifikasi!', 'success');
                    tokenInput.val(data.token);
                    isVerified = true;
                    verifikasiGroup.addClass('hidden');
                    clearTimer();
                    
                    // Enable submit button jika kuota tersedia dan NIK valid
                    cekKuota();
                } else {
                    showToast('Verifikasi Gagal', data.message, 'error');
                }
            })
            .catch(error => {
                if (error.message === 'SESSION_EXPIRED') {
                    showToast('Session Expired', 'Session expired. Silakan refresh halaman.', 'error');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast('Kesalahan Jaringan', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                }
            })
            .finally(() => {
                btnVerifikasi.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Verifikasi');
            });
        });

        // Timer functions
        function startTimer() {
            timeLeft = 120;
            timerInfo.removeClass('hidden');
            updateTimerDisplay();
            
            timer = setInterval(function() {
                timeLeft--;
                updateTimerDisplay();
                
                if (timeLeft <= 0) {
                    clearTimer();
                    btnKirimKode.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> <span class="hidden sm:inline">Kirim</span> Ulang Kode');
                } else {
                    btnKirimKode.prop('disabled', true).html(`<i class="fas fa-clock mr-1"></i> <span class="hidden sm:inline">Kirim</span> Ulang (${timeLeft}s)`);
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerInfo.html(`<i class="fas fa-clock mr-1"></i> Kode berlaku: ${minutes}:${seconds.toString().padStart(2, '0')}`);
        }

        function clearTimer() {
            if (timer) {
                clearInterval(timer);
            }
            timerInfo.addClass('hidden');
        }

        // Event handlers
        $('#tanggal').on('change', function() {
            cekKuota();
            validateField(this, 'tanggal');
        });

        // Validasi NIK real-time
        nikInput.on('input', function() {
            validateNIK(this);
            cekKuota(); // Update status submit button
        });

        // Validasi nama real-time
        $('#nama_tk, #ahli_waris').on('input', function() {
            this.value = this.value.toUpperCase();
            // Hapus karakter selain huruf dan spasi
            this.value = this.value.replace(/[^A-Z\s]/g, '');
            validateField(this, this.id);
        });

        // Validasi real-time untuk field lainnya
        $('#no_hp, #kode_verifikasi').on('input', function() {
            validateField(this, this.id);
        });

        // Form submission validation
        antrianForm.on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }

            if (submitBtn.prop('disabled')) {
                e.preventDefault();
                showToast('Kuota Habis', 'Kuota tidak tersedia untuk tanggal yang dipilih. Silakan pilih tanggal lain.', 'error');
                return false;
            }

            // Show loading
            submitBtn.prop('disabled', true);
            $('#submitText').addClass('hidden');
            $('#submitLoading').removeClass('hidden');
        });

        // Cek jika ada error dari session, reset button state
        @if(session('error') || $errors->any())
            submitBtn.prop('disabled', false);
            $('#submitText').removeClass('hidden');
            $('#submitLoading').addClass('hidden');
        @endif

        // Real-time validation untuk nomor HP
        noHpInput.on('input', function() {
            // Reset verifikasi status jika nomor berubah
            if (isVerified) {
                isVerified = false;
                tokenInput.val('');
                submitBtn.prop('disabled', true);
                verifikasiGroup.addClass('hidden');
                clearTimer();
                submitBtn.removeClass('pulse-animation');
                
                // Update kuota info
                cekKuota();
            }
        });

        // Handle page visibility change (tab switch)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && isVerified) {
                // Re-check kuota ketika kembali ke tab
                cekKuota();
            }
        });

        // Auto-format nomor HP
        noHpInput.on('blur', function() {
            let value = $(this).val().trim();
            // Hapus semua non-digit
            value = value.replace(/\D/g, '');
            // Pastikan diawali 08
            if (value && !value.startsWith('08')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                } else if (value.startsWith('62')) {
                    value = '0' + value.substring(2);
                }
            }
            $(this).val(value);
            validateField(this, 'no_hp');
        });

        // Cek kuota saat halaman dimuat
        cekKuota();
    });
    </script>
</body>
</html>