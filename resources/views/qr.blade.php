<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Antrian JKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 
                        0 10px 10px -5px rgba(0,0,0,0.04);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">

        <!-- Header Public -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-bold mb-2">Antrian Jaminan Kematian (JKM)</h1>
                <p class="text-green-100 opacity-90">Silakan scan QR Code untuk mengambil antrian</p>
            </div>

            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20">
                <i class="fas fa-qrcode text-6xl"></i>
            </div>

            <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute -top-8 -left-8 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <!-- QR Code Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 card-hover">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-1">QR Code Pendaftaran</h2>
                <p class="text-gray-600 text-sm">Scan menggunakan kamera smartphone Anda</p>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-2xl p-6 border border-green-100 relative overflow-hidden">
                <!-- Background Shape -->
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-green-100 rounded-full -ml-4 -mb-4"></div>

                <div class="max-w-xs mx-auto relative z-10">
                    <div class="relative group flex justify-center items-center">
                        {!! $qr !!}
                        <div class="absolute inset-0 bg-green-500 bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all duration-300 bg-white bg-opacity-90 p-3 rounded-full shadow-lg">
                                <i class="fas fa-expand text-green-600 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-green-600 text-sm mt-4 flex items-center justify-center">
                    <i class="fas fa-mobile-alt mr-2"></i>
                    Scan untuk memulai pendaftaran
                </p>
            </div>
        </div>

        <!-- Instructions Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                    <i class="fas fa-info-circle text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Cara Menggunakan</h2>
                    <p class="text-gray-600">Ikuti langkah-langkah sederhana berikut</p>
                </div>
            </div>

            <div class="space-y-4">

                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-amber-800 mb-1">Scan QR Code</h4>
                        <p class="text-amber-700 text-sm">Gunakan kamera smartphone atau aplikasi scanner.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-fuchsia-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-800 mb-1">Isi Formulir</h4>
                        <p class="text-green-700 text-sm">Lengkapi data diri dan informasi yang diperlukan.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Verifikasi WhatsApp</h4>
                        <p class="text-blue-700 text-sm">Kode verifikasi akan dikirim ke WhatsApp Anda.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border border-purple-200">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">4</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-purple-800 mb-1">Dapatkan Nomor Antrian</h4>
                        <p class="text-purple-700 text-sm">Nomor antrian akan dikirim setelah verifikasi selesai.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>
