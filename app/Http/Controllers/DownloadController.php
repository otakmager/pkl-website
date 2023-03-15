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

        }else if($formatLaporan == "tmasuk"){

        }else if($formatLaporan == "tkeluar"){

        }
        
        $output = "";

        //download
        return response($output)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename=' . $fileName);

    }   

}
