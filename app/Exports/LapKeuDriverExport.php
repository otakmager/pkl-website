<?php

namespace App\Exports;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LapKeuDriverExport implements WithMultipleSheets
{
    private $formatLaporan;
    private $str_date;
    private $end_date;
    private $labels;

    // Get formatLaporan (format laporan) -> salah satu ['semua', 'tmasuk', 'tkeluar']
    public function __construct($formatLaporan, $str_date, $end_date, $labels)
    {
        $this->formatLaporan = $formatLaporan;
        $this->str_date = $str_date;
        $this->end_date = $end_date;
        $this->labels = $labels;
    }

    /**
    * @return array
    */
    public function sheets(): array
    {
        $sheets = [];

        $startDate = Carbon::parse($this->str_date);
        $endDate = Carbon::parse($this->end_date);
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($startDate, $interval, $endDate);
        $nMonth = count(iterator_to_array($period));
        $i = 1;

        switch($this->formatLaporan){
            case "semua":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName = $carbonDt->locale('id')->isoFormat("MMMM Y");
                    if($nMonth == 1){
                        $startDateOfMonth =  $startDate;
                        $endDateOfMonth = $endDate;
                    }else if($nMonth == 2){
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }
                    }else{                        
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else if($i == $nMonth){
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }
                    }
                    $i++;        
                    $sheets[] = new LapKeuAllSheet($monthName, $startDateOfMonth, $endDateOfMonth, $this->labels);
                }
                break;
            case "tmasuk":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName = $carbonDt->locale('id')->isoFormat("MMMM Y");
                    if($nMonth == 1){
                        $startDateOfMonth =  $startDate;
                        $endDateOfMonth = $endDate;
                    }else if($nMonth == 2){
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }
                    }else{                        
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else if($i == $nMonth){
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }
                    }
                    $i++;        
                    $sheets[] = new LapKeuMasukSheet($monthName, $startDateOfMonth, $endDateOfMonth, $this->labels);
                }
                break;
            case "tkeluar":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName = $carbonDt->locale('id')->isoFormat("MMMM Y");
                    if($nMonth == 1){
                        $startDateOfMonth =  $startDate;
                        $endDateOfMonth = $endDate;
                    }else if($nMonth == 2){
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }
                    }else{                        
                        if($i == 1){
                            $startDateOfMonth =  $startDate;
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }else if($i == $nMonth){
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = $endDate;
                        }else{
                            $startDateOfMonth =  Carbon::parse($dt)->startOfMonth()->format("Y-m-d");
                            $endDateOfMonth = Carbon::parse($dt)->endOfMonth()->format("Y-m-d");
                        }
                    }
                    $i++;        
                    $sheets[] = new LapKeuKeluarSheet($monthName, $startDateOfMonth, $endDateOfMonth, $this->labels);
                }
                break;
            default: 
                break;
        }        

        return $sheets;
    }
}
