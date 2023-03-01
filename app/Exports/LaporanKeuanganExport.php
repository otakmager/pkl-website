<?php

namespace App\Exports;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use App\Models\Dana;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanKeuanganExport implements FromCollection
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
}
