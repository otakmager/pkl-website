<?php

namespace App\Http\Controllers;
use App\Exports\LaporanKeuanganExport;
use App\Exports\LapKeuDriverExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use App\Models\Dana;
use Illuminate\Http\Request;
// use Dompdf\Options;
// use Dompdf\Dompdf;
// use PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
// use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as PdfDompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App;
use Dompdf\Dompdf;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $labels = Label::whereNull('deleted_at')->orderBy('jenis')->get();
        $labelsMsk = [];
        $labelsKlr = [];
        foreach ($labels as $label) {
            if($label->jenis == 0){
                array_push($labelsMsk, $label);
            }else{
                array_push($labelsKlr, $label);
            }
        }

        return view('dashboard.download', [
            'title' => "Download",
            'labelsMsk' => $labelsMsk,
            'labelsKlr' => $labelsKlr,
            'labels' => $labels,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function templatePDF()
    {
        $data = TMasuk::whereNull('deleted_at')->get();
        return view('pdfTemplate.export', [
            'title' => "Laporan Keuangan",
            'datas' => $data,
        ]);
    }
    public function templatePDF2($dataBig, $monthName, $dataStartDate, $dataEndDate)
    {
        return view('pdfTemplate.export', [
            'title' => "Laporan Keuangan",
            'dataBig' => $dataBig,
            'monthName' => $monthName,
            'dataStartDate' => $dataStartDate,
            'dataEndDate' => $dataEndDate,
        ]);
    }

    /**
     * Export Data to excel based on jenis (format laporan)
     *
     * @return file
     */
    public function downloadExcel(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'formatLaporan' => 'required',
            'str_date' => 'required',
            'end_date' => 'required',
            'label' => 'required',
            '_token' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //download setup
        $formatLaporan = $request->input('formatLaporan');
        $fileName = $request->input('name');
        $str_date = $request->input('str_date');
        $end_date = $request->input('end_date');
        $labels = $request->input('label');
        $labels = explode(',', $labels);
        $labels = array_map('intval', $labels);

        //download
        return Excel::download(new LapKeuDriverExport($formatLaporan, $str_date, $end_date, $labels), $fileName);
    }    

    /**
     * Export Data to excel based on jenis (format laporan)
     *
     * @return file
     */
    public function downloadPDF(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'formatLaporan' => 'required',
            'str_date' => 'required',
            'end_date' => 'required',
            'label' => 'required',
            '_token' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //download setup
        $formatLaporan = $request->input('formatLaporan');
        $fileName = $request->input('name');
        $str_date = $request->input('str_date');
        $end_date = $request->input('end_date');
        $labels = $request->input('label');
        $labels = explode(',', $labels);
        $labels = array_map('intval', $labels);

        // Create looping
        $monthName = [];
        $dataBig = [];
        $dataStartDate = [];
        $dataEndDate = [];

        $startDate = Carbon::parse($str_date);
        $endDate = Carbon::parse($end_date);
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($startDate, $interval, $endDate);        
        $nMonth = count(iterator_to_array($period));
        $i = 1;

        switch($formatLaporan){
            case "semua":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName[] = $carbonDt->locale('id')->isoFormat("MMMM Y");
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
                    $dataBig[] = $this->getAllData($startDateOfMonth, $endDateOfMonth, $labels);
                    $dataStartDate[] = Carbon::parse($startDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                    $dataEndDate[] = Carbon::parse($endDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                }
                break;
            case "tmasuk":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName[] = $carbonDt->locale('id')->isoFormat("MMMM Y");
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
                    $dataBig[] = $this->getDataMasuk($startDateOfMonth, $endDateOfMonth, $labels);
                    $dataStartDate[] = Carbon::parse($startDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                    $dataEndDate[] = Carbon::parse($endDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                }
                break;
            case "tkeluar":
                foreach ($period as $dt) {
                    $carbonDt = Carbon::instance($dt);
                    $monthName[] = $carbonDt->locale('id')->isoFormat("MMMM Y");
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
                    $dataBig[] = $this->getDataKeluar($startDateOfMonth, $endDateOfMonth, $labels);
                    $dataStartDate[] = Carbon::parse($startDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                    $dataEndDate[] = Carbon::parse($endDateOfMonth)->locale('id')->isoFormat("D MMMM Y");
                }
                break;
            default: 
                break;
        } 
        // return $dataBig;
        $saldoAwal = Dana::sum('uang') 
                    + TMasuk::where('tanggal', '<', $str_date)->sum('nominal') 
                    - TKeluar::where('tanggal', '<', $str_date)->sum('nominal');

        ini_set('max_execution_time', 300);
        // Generate HTML
        $html = view('pdfTemplate.export', [
            'title' => $fileName,
            'dataBig' => $dataBig,
            'monthName' => $monthName,
            'dataStartDate' => $dataStartDate,
            'dataEndDate' => $dataEndDate,
            'saldoAwal' => $saldoAwal,
        ])->render();

        // Instantiate Dompdf
        $dompdf = new Dompdf();

        // Load HTML
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Stream PDF to browser (true = auto download || false = preview pdf)
        $dompdf->stream($fileName, array('Attachment' => false));
    }   

    /**
     * Get all data (tmasuk & tkeluar)
     *
     * @return $data
     */
    public function getAllData($str_date, $end_date, $labels)
    {
        $data = DB::table(function ($query) use ($str_date, $end_date, $labels) {
            $subquery = TMasuk::select(DB::raw("'masuk' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                ->from('t_masuks')
                ->whereNull('deleted_at')
                ->whereIn('label_id', $labels)
                ->whereBetween('tanggal', [$str_date, $end_date])
                ->union(
                    TKeluar::select(DB::raw("'keluar' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                    ->whereNull('deleted_at')
                    ->whereIn('label_id', $labels)
                    ->whereBetween('tanggal', [$str_date, $end_date])
                );

            $query->fromSub($subquery, 'sub');
        }, 'subquery')
        ->orderByRaw("MIN(subquery.tanggal) ASC, MIN(subquery.created_at) ASC")
        ->join('labels', 'labels.id', '=', 'subquery.label_id')
        ->select('subquery.tanggal', 'subquery.name', 'labels.name as labels_name')
        // ->select(DB::raw("DATE_FORMAT(subquery.tanggal, '%W, %d-%m-%Y') as tanggal"), 'subquery.name', 'labels.name as labels_name')
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'masuk' THEN subquery.nominal ELSE 0 END) AS nominal_masuk")
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'keluar' THEN subquery.nominal ELSE 0 END) AS nominal_keluar")
        ->groupBy('subquery.id', 'subquery.name', 'subquery.label_id', 'labels.name')
        ->get();  

        return $data;
    }   

    /**
     * Get tmasuk data
     *
     * @return $data
     */
    public function getDataMasuk($str_date, $end_date, $labels)
    {
        $data = DB::table(function ($query) use ($str_date, $end_date, $labels) {
            $subquery = TMasuk::select(DB::raw("'masuk' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                ->from('t_masuks')
                ->whereNull('deleted_at')
                ->whereIn('label_id', $labels)
                ->whereBetween('tanggal', [$str_date, $end_date]);

            $query->fromSub($subquery, 'sub');
        }, 'subquery')
        ->orderByRaw("MIN(subquery.tanggal) ASC, MIN(subquery.created_at) ASC")
        ->join('labels', 'labels.id', '=', 'subquery.label_id')
        ->select(DB::raw("DATE_FORMAT(subquery.tanggal, '%W, %d-%m-%Y') as tanggal"), 'subquery.name', 'labels.name as labels_name')
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'masuk' THEN subquery.nominal ELSE 0 END) AS nominal_masuk")
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'keluar' THEN subquery.nominal ELSE 0 END) AS nominal_keluar")
        ->groupBy('subquery.id', 'subquery.name', 'subquery.label_id', 'labels.name')
        ->get();  

        return $data;
    
    }   
    /**
     * Get tkeluar data
     *
     * @return $data
     */
    public function getDataKeluar($str_date, $end_date, $labels)
    {
        $data = DB::table(function ($query) use ($str_date, $end_date, $labels) {
            $subquery = TKeluar::select(DB::raw("'keluar' AS tipe"), 'id', 'name', 'label_id', 'nominal', 'tanggal', 'created_at')
                ->from('t_keluars')
                ->whereNull('deleted_at')
                ->whereIn('label_id', $labels)
                ->whereBetween('tanggal', [$str_date, $end_date]);

            $query->fromSub($subquery, 'sub');
        }, 'subquery')
        ->orderByRaw("MIN(subquery.tanggal) ASC, MIN(subquery.created_at) ASC")
        ->join('labels', 'labels.id', '=', 'subquery.label_id')
        ->select(DB::raw("DATE_FORMAT(subquery.tanggal, '%W, %d-%m-%Y') as tanggal"), 'subquery.name', 'labels.name as labels_name')
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'masuk' THEN subquery.nominal ELSE 0 END) AS nominal_masuk")
        ->selectRaw("SUM(CASE WHEN subquery.tipe = 'keluar' THEN subquery.nominal ELSE 0 END) AS nominal_keluar")
        ->groupBy('subquery.id', 'subquery.name', 'subquery.label_id', 'labels.name')
        ->get();  

        return $data;
    }   

}
