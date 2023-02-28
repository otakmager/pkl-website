<?php

namespace App\Exports;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use App\Models\Dana;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanKeuanganExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
