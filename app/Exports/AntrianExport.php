<?php

namespace App\Exports;

use App\Models\Antrian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class AntrianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $tanggal;

    public function __construct($startDate = null, $endDate = null, $tanggal = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $query = Antrian::query();

        if ($this->tanggal) {
            $query->where('tanggal', $this->tanggal);
        } elseif ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('tanggal', 'desc')
                    ->orderBy('nomor')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'NO ANTRIAN',
            'TANGGAL',
            'JAM KEDATANGAN',
            'NAMA TENAGA KERJA',
            'NIK TENAGA KERJA',
            'NAMA AHLI WARIS',
            'NOMOR WHATSAPP',
            'STATUS',
            'WAKTU PENDAFTARAN'
        ];
    }

    public function map($antrian): array
    {
        // Format status ke dalam bahasa Indonesia
        $statusMap = [
            'pending' => 'Menunggu',
            'dibayarkan' => 'Dibayarkan',
            'cek_kasus' => 'Cek Kasus',
            'ditolak' => 'Ditolak'
        ];
        
        $statusText = $statusMap[$antrian->status] ?? $antrian->status;

        return [
            $antrian->nomor,
            $antrian->tanggal,
            $antrian->jam,
            $antrian->nama_tk,
            "'" . $antrian->nik_tk,
            $antrian->ahli_waris,
            "'" . $antrian->no_hp,
            $statusText,
            $antrian->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply header style
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => Color::COLOR_WHITE]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4F46E5'] // Indigo
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Auto size columns
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Apply borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:I' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFCCCCCC'],
                ],
            ],
        ]);

        // Center align for specific columns
        $centerColumns = ['A', 'B', 'C', 'H', 'I'];
        foreach ($centerColumns as $column) {
            $sheet->getStyle($column . '2:' . $column . $lastRow)
                  ->getAlignment()
                  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }

    public function title(): string
    {
        return 'Data Antrian';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Add filter
                $event->sheet->getDelegate()->setAutoFilter('A1:I1');
                
                // Freeze header row
                $event->sheet->getDelegate()->freezePane('A2');
                
                // Apply color to status column based on value
                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                
                for ($row = 2; $row <= $lastRow; $row++) {
                    $status = $event->sheet->getDelegate()->getCell('H' . $row)->getValue();
                    
                    // Warna yang lebih baik
                    $fillColor = match($status) {
                        'Dibayarkan' => 'C6EFCE', // Hijau muda (Excel default green)
                        'Cek Kasus' => 'FFEB9C', // Kuning muda (Excel default yellow)
                        'Ditolak' => 'FFC7CE', // Merah muda (Excel default red)
                        'Menunggu' => 'D9D9D9', // Abu-abu muda (Excel default gray)
                        default => 'FFFFFF'
                    };
                    
                    // Warna teks
                    $fontColor = match($status) {
                        'Dibayarkan' => '006100', // Hijau tua
                        'Cek Kasus' => '9C5700', // Coklat tua
                        'Ditolak' => '9C0006', // Merah tua
                        'Menunggu' => '000000', // Hitam
                        default => '000000'
                    };
                    
                    $event->sheet->getDelegate()->getStyle('H' . $row)
                        ->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => $fillColor]
                            ],
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => $fontColor]
                            ]
                        ]);
                }
                
                // Format tanggal column
                $event->sheet->getDelegate()->getStyle('B2:B' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');
                
                // Format waktu column
                $event->sheet->getDelegate()->getStyle('I2:I' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd hh:mm:ss');
            },
        ];
    }
}