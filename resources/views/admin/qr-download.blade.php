<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Antrian JKM - BPJS Ketenagakerjaan</title>
    <style>
        /* Reset untuk print */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm;
            height: 297mm;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        
        .print-container {
            width: 180mm;
            height: auto;
            margin: 0 auto;
            padding: 15mm;
            box-shadow: none;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            page-break-inside: avoid;
            page-break-after: avoid;
        }
        
        .print-center {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        
        .print-logo {
            width: 30mm;
            height: auto;
        }
        
        .print-qr {
            max-width: 80mm;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .print-qr svg {
            width: 100%;
            height: auto;
            max-width: 80mm;
        }
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10mm;
            margin-bottom: 8mm;
            width: 100%;
        }
        
        .logo {
            width: 24mm;
            height: auto;
            margin-bottom: 4mm;
        }
        
        .title {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 2mm;
            color: #333;
        }
        
        .subtitle {
            font-size: 10pt;
            color: #666;
        }
        
        /* QR Section */
        .qr-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 8mm;
            margin-bottom: 8mm;
            width: 100%;
        }
        
        /* Instructions */
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 6mm;
            margin-bottom: 8mm;
            width: 100%;
        }
        
        .instructions-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 4mm;
            color: #856404;
            text-align: center;
        }
        
        .instruction-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3mm;
        }
        
        .instruction-item {
            display: flex;
            align-items: flex-start;
            gap: 3mm;
        }
        
        .instruction-number {
            width: 6mm;
            height: 6mm;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 8pt;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .instruction-text {
            font-size: 9pt;
            color: #856404;
            line-height: 1.3;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 4mm;
            width: 100%;
        }
        
        .footer-title {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1mm;
            color: #333;
        }
        
        .footer-subtitle {
            font-size: 9pt;
            color: #666;
        }

        @page {
            size: A4;
            margin: 20mm;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <div class="print-center">
                <img src="{{ asset('assets/icon-bpjstk.png') }}" 
                     alt="BPJS Ketenagakerjaan" 
                     class="logo">
            </div>
            
            <!-- Title -->
            <h1 class="title">QR Code Antrian JKM</h1>
            <p class="subtitle">Sistem Antrian Digital BPJS Ketenagakerjaan</p>
        </div>

        <!-- QR Code Section -->
        <div class="qr-section">
            <div class="print-qr">
                {!! $qr !!}
            </div>
        </div>

        <!-- Instructions Section -->
        <div class="instructions">
            <h3 class="instructions-title">Cara Penggunaan</h3>
            <div class="instruction-grid">
                <div class="instruction-item">
                    <div class="instruction-number">1</div>
                    <p class="instruction-text">Buka kamera atau scanner QR</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-number">2</div>
                    <p class="instruction-text">Arahkan ke QR code</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-number">3</div>
                    <p class="instruction-text">Tunggu deteksi otomatis</p>
                </div>
                <div class="instruction-item">
                    <div class="instruction-number">4</div>
                    <p class="instruction-text">Isi form data lengkap</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-title">BPJS Ketenagakerjaan</p>
            <p class="footer-subtitle">Sistem Antrian Digital</p>
        </div>
    </div>

    <script>
        // Auto print ketika halaman loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Auto print setelah 500ms
            setTimeout(function() {
                window.print();
            }, 500);
        });

        // Redirect back setelah print (optional)
        window.addEventListener('afterprint', function() {
            setTimeout(function() {
                window.close(); // atau window.history.back() jika ingin kembali
            }, 500);
        });
    </script>
</body>
</html>