<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Antrian JKM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto bg-white mt-10 p-6 shadow-md rounded-lg">

    <h2 class="text-2xl font-bold mb-4 text-center">Form Antrian JKM</h2>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('antrian.store') }}" method="POST" enctype="multipart/form-data" id="antrianForm">
        @csrf

        {{-- NAMA --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Tenaga Kerja *</label>
            <input type="text" name="nama_tk" id="nama_tk" class="w-full border p-2 rounded uppercase" 
                   required value="{{ old('nama_tk') }}" 
                   oninput="this.value = this.value.toUpperCase()"
                   pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi diperbolehkan">
            <small class="text-gray-500">Otomatis huruf besar</small>
        </div>

        {{-- NIK --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">NIK Tenaga Kerja *</label>
            <input type="text" name="nik_tk" id="nik_tk" class="w-full border p-2 rounded" 
                   required value="{{ old('nik_tk') }}"
                   pattern="[0-9]{16}" 
                   title="NIK harus 16 digit angka"
                   maxlength="16"
                   oninput="validateNIK(this)">
            <small class="text-gray-500">Harus tepat 16 digit angka</small>
            <div id="nik-error" class="text-red-500 text-sm mt-1 hidden"></div>
        </div>

        {{-- AHLI WARIS --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nama Ahli Waris *</label>
            <input type="text" name="ahli_waris" id="ahli_waris" class="w-full border p-2 rounded uppercase" 
                   required value="{{ old('ahli_waris') }}"
                   oninput="this.value = this.value.toUpperCase()"
                   pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi diperbolehkan">
            <small class="text-gray-500">Otomatis huruf besar</small>
        </div>

        {{-- NO HP dengan VERIFIKASI --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nomor WhatsApp Aktif *</label>
            <div class="flex space-x-2">
                <input type="text" name="no_hp" id="no_hp" placeholder="08xxxxxxxxxx" 
                       class="flex-1 border p-2 rounded" required value="{{ old('no_hp') }}"
                       pattern="08[0-9]{8,11}" title="Format: 08xxxxxxxxxx">
                <button type="button" id="btn-kirim-kode" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded whitespace-nowrap">
                    Kirim Kode
                </button>
            </div>
            <small class="text-gray-500">Pastikan nomor WhatsApp aktif dan benar</small>
        </div>

        {{-- VERIFIKASI KODE --}}
        <div class="mb-4 hidden" id="verifikasi-group">
            <label class="block mb-2 font-semibold">Kode Verifikasi *</label>
            <div class="flex space-x-2">
                <input type="text" name="kode_verifikasi" id="kode_verifikasi" 
                       placeholder="6 digit kode" maxlength="6"
                       class="flex-1 border p-2 rounded"
                       pattern="[0-9]{6}" title="6 digit angka">
                <button type="button" id="btn-verifikasi-kode" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded whitespace-nowrap">
                    Verifikasi
                </button>
            </div>
            <small class="text-gray-500">Masukkan 6 digit kode yang dikirim via WhatsApp</small>
            <div id="timer-info" class="text-sm text-orange-600 mt-1 hidden"></div>
        </div>

        <input type="hidden" name="verifikasi_token" id="verifikasi_token">

        {{-- FOTO KTP --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Upload Foto KTP Ahli Waris *</label>
            <input type="file" name="foto_ktp_aw" accept="image/*" class="w-full border p-2 rounded" required
                   onchange="validateFile(this, 'ktp')">
            <small class="text-gray-500">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
            <div id="ktp-error" class="text-red-500 text-sm mt-1 hidden"></div>
        </div>

        {{-- FOTO DIRI --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Upload Foto Diri Ahli Waris *</label>
            <input type="file" name="foto_diri_aw" accept="image/*" class="w-full border p-2 rounded" required
                   onchange="validateFile(this, 'diri')">
            <small class="text-gray-500">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
            <div id="diri-error" class="text-red-500 text-sm mt-1 hidden"></div>
        </div>

        {{-- TANGGAL --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Tanggal Antrian *</label>
            <input type="date" name="tanggal" id="tanggal" 
                   class="w-full border p-2 rounded" 
                   value="{{ date('Y-m-d') }}" 
                   min="{{ date('Y-m-d') }}" required>
        </div>

        {{-- KUOTA --}}
        <div class="mb-4">
            <p id="kuotaInfo" class="text-sm text-blue-600">Cek kuota...</p>
        </div>

        {{-- BUTTON --}}
        <button type="submit" id="submitBtn" 
                class="w-full bg-green-600 hover:bg-green-700 text-white p-3 rounded font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed transition duration-200">
            <span id="submitText">Ambil Antrian</span>
            <div id="submitLoading" class="hidden">
                <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </button>
    </form>

</div>

<script>
// Validasi NIK
function validateNIK(input) {
    const nik = input.value.replace(/\D/g, ''); // Hapus non-digit
    const nikError = document.getElementById('nik-error');
    
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
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
    } else if (nik.length === 16) {
        nikError.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');
    } else {
        nikError.classList.add('hidden');
        input.classList.remove('border-red-500', 'border-green-500');
    }
}

// Validasi file upload
function validateFile(input, type) {
    const file = input.files[0];
    const errorElement = document.getElementById(`${type}-error`);
    const maxSize = 2 * 1024 * 1024; // 2MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
    if (file) {
        // Validasi tipe file
        if (!allowedTypes.includes(file.type)) {
            errorElement.textContent = 'Format file harus JPG, PNG, atau JPEG';
            errorElement.classList.remove('hidden');
            input.value = '';
            input.classList.add('border-red-500');
            return false;
        }
        
        // Validasi ukuran file
        if (file.size > maxSize) {
            errorElement.textContent = 'Ukuran file maksimal 2MB';
            errorElement.classList.remove('hidden');
            input.value = '';
            input.classList.add('border-red-500');
            return false;
        }
        
        // Jika valid
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');
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

    // Disable submit button initially
    submitBtn.prop('disabled', true);

    // Cek kuota function
    function cekKuota() {
        let tgl = $('#tanggal').val();

        $.get("{{ route('antrian.kuota') }}", { tanggal: tgl }, function(res) {
            if (res.tersisa <= 0) {
                $('#kuotaInfo').text("Kuota penuh untuk tanggal ini (0/15 tersisa)")
                               .removeClass().addClass("text-sm text-red-600");
                submitBtn.prop('disabled', true);
            } else {
                $('#kuotaInfo').text("Sisa kuota: " + res.tersisa + " dari 15")
                               .removeClass().addClass("text-sm text-green-600");
                // Only enable if WhatsApp is verified dan NIK valid
                const isNIKValid = nikInput.val().length === 16;
                submitBtn.prop('disabled', !(isVerified && isNIKValid));
            }
        }).fail(function() {
            $('#kuotaInfo').text("Gagal memuat kuota").removeClass().addClass("text-sm text-red-600");
        });
    }

    // Validasi form sebelum submit
    function validateForm() {
        const nik = nikInput.val();
        const namaTk = $('#nama_tk').val();
        const ahliWaris = $('#ahli_waris').val();
        
        // Validasi NIK
        if (nik.length !== 16) {
            alert('NIK harus tepat 16 digit angka');
            nikInput.focus();
            return false;
        }
        
        // Validasi nama (hanya huruf dan spasi)
        const nameRegex = /^[A-Z\s]+$/;
        if (!nameRegex.test(namaTk)) {
            alert('Nama Tenaga Kerja hanya boleh mengandung huruf dan spasi');
            $('#nama_tk').focus();
            return false;
        }
        
        if (!nameRegex.test(ahliWaris)) {
            alert('Nama Ahli Waris hanya boleh mengandung huruf dan spasi');
            $('#ahli_waris').focus();
            return false;
        }
        
        return true;
    }

    // Kirim kode verifikasi
    btnKirimKode.on('click', function() {
        const noHp = noHpInput.val().trim();
        
        if (!noHp) {
            alert('Masukkan nomor WhatsApp terlebih dahulu');
            return;
        }

        // Validasi format nomor sederhana
        if (!/^08[0-9]{8,11}$/.test(noHp)) {
            alert('Format nomor WhatsApp tidak valid. Contoh: 081234567890');
            return;
        }

        // Disable button dan show loading
        btnKirimKode.prop('disabled', true).text('Mengirim...');

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
                alert('Kode verifikasi telah dikirim via WhatsApp ke ' + (data.no_hp || noHp));
                verifikasiGroup.removeClass('hidden');
                startTimer();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            if (error.message === 'SESSION_EXPIRED') {
                alert('Session expired. Silakan refresh halaman.');
                location.reload();
            } else {
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            }
        })
        .finally(() => {
            btnKirimKode.prop('disabled', false).text('Kirim Kode');
        });
    });

    // Verifikasi kode
    btnVerifikasi.on('click', function() {
        const noHp = noHpInput.val().trim();
        const kode = kodeInput.val().trim();

        if (!kode || kode.length !== 6) {
            alert('Masukkan 6 digit kode verifikasi');
            return;
        }

        btnVerifikasi.prop('disabled', true).text('Memverifikasi...');

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
                alert('Nomor WhatsApp berhasil diverifikasi!');
                tokenInput.val(data.token);
                isVerified = true;
                verifikasiGroup.addClass('hidden');
                clearTimer();
                
                // Enable submit button jika kuota tersedia dan NIK valid
                cekKuota();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            if (error.message === 'SESSION_EXPIRED') {
                alert('Session expired. Silakan refresh halaman.');
                location.reload();
            } else {
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            }
        })
        .finally(() => {
            btnVerifikasi.prop('disabled', false).text('Verifikasi');
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
                btnKirimKode.prop('disabled', false).text('Kirim Ulang Kode');
            } else {
                btnKirimKode.prop('disabled', true).text(`Kirim Ulang (${timeLeft}s)`);
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerInfo.text(`Kode berlaku: ${minutes}:${seconds.toString().padStart(2, '0')}`);
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
    });

    // Form submission validation
    antrianForm.on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }

        if (!isVerified) {
            e.preventDefault();
            alert('Silakan verifikasi nomor WhatsApp terlebih dahulu');
            return false;
        }

        if (!tokenInput.val()) {
            e.preventDefault();
            alert('Token verifikasi tidak valid. Silakan verifikasi ulang.');
            return false;
        }

        if (submitBtn.prop('disabled')) {
            e.preventDefault();
            alert('Kuota tidak tersedia untuk tanggal yang dipilih');
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
    });

    // Cek kuota saat halaman dimuat
    cekKuota();
});
</script>

</body>
</html>