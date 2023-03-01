<?php

namespace App\Exports;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use App\Models\Dana;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    private $formatLaporan;

    // Get formatLaporan (format laporan) -> salah satu ['semua', 'tmasuk', 'tkeluar']
    public function __construct($formatLaporan)
    {
        $this->formatLaporan = $formatLaporan;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->formatLaporan == "semua") {
            // Generate laporan dengan menggunakan data dari model TMasuk dan TKeluar
            $data = TMasuk::select('id', 'name', 'label_id', 'nominal', 'tanggal')
                ->whereNull('deleted_at')
                ->union(
                    TKeluar::select('id', 'name', 'label_id', 'nominal', 'tanggal')
                    ->whereNull('deleted_at')
                )
                ->get();
            return $data;

        } else if ($this->formatLaporan == "tmasuk") {
            // Generate laporan dengan menggunakan data dari model TMasuk saja
            return TMasuk::whereNull('deleted_at')->get();
        } else if ($this->formatLaporan == "tkeluar") {
            // Generate laporan dengan menggunakan data dari model TKeluar saja
            return TKeluar::whereNull('deleted_at')->get();
        }
    }

    // Tambahan

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            [
                'CV Berkah Makmur',
                '',
                '',
                '',
                '',
            ],
            [
                'Jalan Cempaka Putih Gang Bimasakti Karanganyar, Jawa Tengah',
                '',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'ID',
                'Nama',
                'Label ID',
                'Nominal',
                'Tanggal',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge and style CV Berkah Makmur row
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Merge and style addres CV Berkah Makmur row
                $event->sheet->mergeCells('A2:E2');
                $event->sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Add empty rows
                $event->sheet->mergeCells('A3:E3');
                $event->sheet->mergeCells('A4:E4');
                $event->sheet->getStyle('A3:E4')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Style Header Column
                $event->sheet->getStyle('A5:E5')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }

    // End tambahan
}
