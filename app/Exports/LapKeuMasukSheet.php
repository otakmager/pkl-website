<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
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
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class LapKeuMasukSheet implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithColumnWidths, WithTitle
{
    private $sheetTitle;
    private $str_date;
    private $end_date;

    // Constructor
    public function __construct($sheetTitle, $str_date, $end_date)
    {
        $this->sheetTitle = $sheetTitle;
        $this->str_date = $str_date;
        $this->end_date = $end_date;
    }

    // Set title sheet
    public function title(): string
    {
        return $this->sheetTitle;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        DB::select(DB::raw("SET lc_time_names = 'id_ID'"));
        // Generate laporan dengan menggunakan data dari model TMasuk dan TKeluar
        $data = DB::table(function ($query) {
            $subquery = TMasuk::select(DB::raw("'masuk' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                ->from('t_masuks')
                ->whereNull('deleted_at')
                ->whereBetween('tanggal', [$this->str_date, $this->end_date]);

            $query->fromSub($subquery, 'sub');
        }, 'subquery')
        ->orderByRaw("MIN(subquery.tanggal) ASC, MIN(subquery.created_at) ASC")
        ->join('labels', 'labels.id', '=', 'subquery.label_id')
        ->select(DB::raw("DATE_FORMAT(subquery.tanggal, '%W, %d-%m-%Y') as tanggal"), 'subquery.name', 'labels.name as labels_name')
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'masuk' THEN subquery.nominal ELSE 0 END) AS nominal_masuk")
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'keluar' THEN subquery.nominal ELSE 0 END) AS nominal_keluar")
        ->groupBy('subquery.id', 'subquery.name', 'subquery.label_id', 'labels.name')
        ->get();           

        $nomor = 1;
        foreach($data as $key => $row) {
            $data[$key] = (object)array_merge(array('nomor' => $nomor), (array)$row);
            $nomor++;
        }

        return $data;
    }

    // Tambahan

    public function startCell(): string
    {
        return 'A1';
    }

    public function columnWidths(): array
    {
        return [
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 20,
            'F' => 20,
        ];
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
                '',
            ],
            [
                'Jalan Cempaka Putih Gang Bimasakti Karanganyar, Jawa Tengah',
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
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                'Nomor',
                'Tanggal',
                'Nama',
                'Label',
                'Nominal Masuk',
                'Nominal Keluar',
            ],
        ];
    }

    public function footer(): array
    {
        return [
            [
                '', 'Total pemasukan:',
                '',
                45000,
            ],
            [
                '', 'Total pengeluaran:',
                '',
                35000,
            ],
            [
                '', 'Sisa kas:',
                '',
                15000,
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge and style CV Berkah Makmur row
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->getStyle('A1:F1')->applyFromArray([
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
                $event->sheet->mergeCells('A2:F2');
                $event->sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Add empty rows
                $event->sheet->mergeCells('A3:F3');
                $event->sheet->mergeCells('A4:F4');
                $event->sheet->getStyle('A3:F4')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Style Header Column
                $event->sheet->getStyle('A5:F5')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Add footer Kosong
                $footerStartRow = $event->sheet->getHighestRow() + 1;
                $footerEndRow = $footerStartRow + count($this->footer()) - 1;
                $footerRange = "A{$footerStartRow}:E{$footerEndRow}";
                $event->sheet->getStyle($footerRange)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                // Add footer rekap
                foreach ($this->footer() as $row) {
                    $event->sheet->append($row);
                    $rowPost = $event->sheet->getHighestRow();
                    $footerJudul = "B{$rowPost}:C{$rowPost}";
                    $event->sheet->getStyle($footerJudul)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_RIGHT,
                        ],
                    ]);
                    $event->sheet->mergeCells('B' . $rowPost . ':C' . $rowPost);
                }
            },
        ];
    }

    // End tambahan
}
