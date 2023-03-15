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
use Illuminate\Http\Request;
use Dompdf\Options;
use Dompdf\Dompdf;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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

        // Get Data
        if($formatLaporan == "semua"){
            $data = $this->getAllData($str_date, $end_date, $labels);
        }else if($formatLaporan == "tmasuk"){
            $data = $this->getDataMasuk($str_date, $end_date, $labels);
        }else if($formatLaporan == "tkeluar"){
            $data = $this->getDataKeluar($str_date, $end_date, $labels);
        }

        // Group the data by month
        $dataByMonth = $data->groupBy(function($item) {
            return date('Y-m', strtotime($item->tanggal));
        });
        
        $output = "";

        foreach ($dataByMonth as $month => $data) {
            // Generate the header
            $header = '<table style="width: 100%; border-collapse: collapse;">' .
                        '<tr>' .
                          '<td style="width: 100px;"><img src="{{ asset(' . public_path('img/logo.png') . ') }}" width="85" height="31"></td>' .
                          '<td style="text-align: center; vertical-align: middle;">' .
                            '<h2>CV Berkah Makmur</h2>' .
                            '<p>Jalan Bimasakti, Perum Argokiloso, Tasikmadu, Karanganyar, Jawa Tengah</p>' .
                          '</td>' .
                        '</tr>' .
                      '</table>' .
                      '<hr>' .
                      '<p>Bulan: ' . date('F Y', strtotime($month . '-01')) . '</p>' .
                      '<table style="width: 100%; border-collapse: collapse;">' .
                      '<thead>' .
                      '<tr>' .
                      '<th>Nomor</th>' .
                      '<th>Tanggal</th>' .
                      '<th>Nama</th>' .
                      '<th>Label ID</th>' .
                      '<th>Nominal masuk</th>' .
                      '<th>Nominal keluar</th>' .
                      '</tr>' .
                      '</thead>' .
                      '<tbody>';
    
            // Generate the rows
            $rows = '';
            $i = 1;
            foreach ($data as $row) {
                $rows .= '<tr>' .
                         '<td>' . $i++ . '</td>' .
                         '<td>' . $row->tanggal . '</td>' .
                         '<td>' . $row->nama . '</td>' .
                         '<td>' . $row->label_id . '</td>' .
                         '<td>' . $row->nominal_masuk . '</td>' .
                         '<td>' . $row->nominal_keluar . '</td>' .
                         '</tr>';
            }
    
            // Generate the footer
            $footer = '</tbody>' .
                      '</table>';
    
            // Concatenate the header, rows, and footer
            $output .= $header . $rows . $footer;
    
            // Add a page break if there is more than one page
            if (!$data->isEmpty() && $data->count() > 20) {
                $output .= '<pagebreak>';
            }
        }

        //download
        // return response($output)
        // $pdf = PDF::loadview('pegawai_pdf',['pegawai'=>$pegawai]);
        return response($data)
            ->header('Content-Type', 'application/pdf')
            // ->header('Content-Disposition', 'attachment; filename=' . $fileName);
            ->header('Content-Disposition', 'inline; filename=' . $fileName);

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
        ->select(DB::raw("DATE_FORMAT(subquery.tanggal, '%W, %d-%m-%Y') as tanggal"), 'subquery.name', 'labels.name as labels_name')
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
