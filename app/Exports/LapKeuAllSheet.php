<?php

namespace App\Exports;
use Illuminate\Support\Carbon;
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

class LapKeuAllSheet implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, WithColumnWidths, WithTitle
{
    private $sheetTitle;
    private $str_date;
    private $end_date;
    private $labels;

    // Constructor
    public function __construct($sheetTitle, $str_date, $end_date, $labels)
    {
        $this->sheetTitle = $sheetTitle;
        $this->str_date = $str_date;
        $this->end_date = $end_date;
        $this->labels = $labels;
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
                ->whereIn('label_id', $this->labels)
                ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                ->union(
                    TKeluar::select(DB::raw("'keluar' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                    ->whereNull('deleted_at')
                    ->whereIn('label_id', $this->labels)
                    ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                );

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
            'A' => 10,
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
                'Perum Argokiloso, Gang Bima Sakti Blok A. No. 19 Rt 01/ 06, Ngijo Tasikmadu, Karanganyar',
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
                'Bulan:',
                Carbon::parse($this->str_date)->locale('id')->isoFormat('MMMM Y'),
                '',
                '',
                '',
                '',
            ],
            [
                'Tanggal:',
                Carbon::parse($this->str_date)->locale('id')->isoFormat('D MMMM YYYY') 
                . " - " . Carbon::parse($this->end_date)->locale('id')->isoFormat('D MMMM YYYY'),
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
        $saldoAwal = Dana::sum('uang') 
                    + TMasuk::where('tanggal', '<', $this->str_date)->sum('nominal') 
                    - TKeluar::where('tanggal', '<', $this->str_date)->sum('nominal');
        $totMasuk = TMasuk::whereNull('deleted_at')
                    ->whereIn('label_id', $this->labels)
                    ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                    ->selectRaw('COALESCE(SUM(nominal), 0) as total_pemasukan')
                    ->get();
        $totKeluar = TKeluar::whereNull('deleted_at')
                    ->whereIn('label_id', $this->labels)
                    ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                    ->selectRaw('COALESCE(SUM(nominal), 0) as total_pengeluaran')
                    ->get();
        
        return [
            [
                '', 'Saldo awal:',
                $saldoAwal,
            ],
            [
                '', 'Total pemasukan:',
                $totMasuk[0]['total_pemasukan'],
            ],
            [
                '', 'Total pengeluaran:',
                $totKeluar[0]['total_pengeluaran'],
            ],
            [
                '', 'Saldo akhir:',
                $saldoAwal + $totMasuk[0]['total_pemasukan'] - $totKeluar[0]['total_pengeluaran'],
            ],
        ];
    }

    public function footerLabelMasuk(): array
    { 
        $labelsMasuk = TMasuk::whereNull('t_masuks.deleted_at')
                    ->whereIn('label_id', $this->labels)
                    ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                    ->join('labels', 'labels.id', '=', 't_masuks.label_id')
                    ->selectRaw('labels.name as name, COALESCE(SUM(nominal), 0) as sum')
                    ->groupBy('labels.name')
                    ->get();
        $result = [];
        $sum = 0;
        if ($labelsMasuk->isNotEmpty()){
            $result[] = [' ',' ', ' '];
            $result[] = [' ',' ', ' '];
            $result[] = ['', 'Rekap Label Pemasukan', ''];
            foreach($labelsMasuk as $labels) {
                $result[] = ['', $labels['name'], $labels['sum']];
                $sum += $labels['sum'];
            }
            $result[] = ['', 'Total:', $sum];
        }
        return $result;
    }

    public function footerLabelKeluar(): array
    {
        $labelsKeluar = TKeluar::whereNull('t_keluars.deleted_at')
                    ->whereIn('label_id', $this->labels)
                    ->whereBetween('tanggal', [$this->str_date, $this->end_date])
                    ->join('labels', 'labels.id', '=', 't_keluars.label_id')
                    ->selectRaw('labels.name as name, COALESCE(SUM(nominal), 0) as sum')
                    ->groupBy('labels.name')
                    ->get();
        $result = [];
        $sum = 0;
        if ($labelsKeluar->isNotEmpty()){
            $result[] = [' ',' ', ' '];
            $result[] = [' ',' ', ' '];
            $result[] = ['', 'Rekap Label Pengeluaran', ''];
            foreach($labelsKeluar as $labels) {
                $result[] = ['', $labels['name'], $labels['sum']];
                $sum += $labels['sum'];
            }
            $result[] = ['', 'Total:', $sum];
        }
        return $result;
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

                // Style Keterangan bulan dan rentang tanggal
                $event->sheet->getStyle('A5:F6')->applyFromArray([
                    'font' => [
                        'size' => 12,
                    ],
                ]);
                $event->sheet->getStyle('A5:A6')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);
                $event->sheet->getStyle('B5:C6')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
                $event->sheet->mergeCells('B5:C5');
                $event->sheet->mergeCells('B6:C6');
                
                // Style Header Column
                $event->sheet->getStyle('A8:F8')->applyFromArray([
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
                $footerEndRow = $footerStartRow + count($this->footer()) - 3;
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
                }

                // Add footer rekap Label Masuk
                $footerLabelMasuk = $this->footerLabelMasuk();
                $count = count($footerLabelMasuk);
                foreach ($footerLabelMasuk as $index => $row) {
                    $event->sheet->append($row);
                    $rowPost = $event->sheet->getHighestRow();
                    if ($index === 2) {
                        $footerJudul = "B{$rowPost}:C{$rowPost}";
                        $event->sheet->getStyle($footerJudul)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                            ],
                        ]);
                        $event->sheet->mergeCells($footerJudul);
                    }else if($index === $count-1){
                        $footerJudul = "B{$rowPost}";
                        $event->sheet->getStyle($footerJudul)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            ],
                        ]);
                    }else{
                        $event->sheet->getStyle('C'.$rowPost)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            ],
                        ]);
                    }
                }
                
                // Add footer rekap Label Keluar
                $footerLabelKeluar = $this->footerLabelKeluar();
                $count = count($footerLabelKeluar);
                foreach ($footerLabelKeluar as $index => $row) {
                    $event->sheet->append($row);
                    $rowPost = $event->sheet->getHighestRow();
                    if ($index === 2) {
                        $footerJudul = "B{$rowPost}:C{$rowPost}";
                        $event->sheet->getStyle($footerJudul)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_CENTER,
                            ],
                        ]);
                        $event->sheet->mergeCells($footerJudul);
                    }else if($index === $count-1){
                        $footerJudul = "B{$rowPost}";
                        $event->sheet->getStyle($footerJudul)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            ],
                        ]);
                    }else{
                        $event->sheet->getStyle('C'.$rowPost)->applyFromArray([
                            'alignment' => [
                                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            ],
                        ]);
                    }
                }
            },
        ];
    }

    // End tambahan
}
