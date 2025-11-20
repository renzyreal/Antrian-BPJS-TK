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
        $filterInfo = "Filter: ";
        
        if ($this->tanggal) {
            $filterInfo .= "Tanggal " . $this->tanggal;
        } elseif ($this->startDate && $this->endDate) {
            $filterInfo .= "Rentang " . $this->startDate . " hingga " . $this->endDate;
        } else {
            $filterInfo .= "Semua Data";
        }

        return [
            [$filterInfo],
            [], // Empty row
            [
                'NO ANTRIAN',
                'TANGGAL',
                'JAM KEDATANGAN',
                'NAMA TENAGA KERJA',
                'NIK TENAGA KERJA',
                'NAMA AHLI WARIS',
                'NOMOR WHATSAPP',
                'WAKTU PENDAFTARAN'
            ]
        ];
    }

    public function map($antrian): array
    {
        return [
            $antrian->nomor,
            $antrian->tanggal,
            $antrian->jam,
            $antrian->nama_tk,
            "'" . $antrian->nik_tk, // Tambahkan apostrof untuk menjaga format NIK
            $antrian->ahli_waris,
            "'" . $antrian->no_hp, // Tambahkan apostrof untuk menjaga format nomor
            $antrian->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk info filter
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FF0000FF']],
            ],
            // Style untuk header
            3 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE6E6FA']
                ]
            ],
        ];
    }

    public function title(): string
    {
        if ($this->tanggal) {
            return 'Antrian ' . $this->tanggal;
        } elseif ($this->startDate && $this->endDate) {
            return 'Antrian ' . $this->startDate . ' to ' . $this->endDate;
        } else {
            return 'Semua Antrian';
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto size columns
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);
            },
        ];
    }
}