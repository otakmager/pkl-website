<?php

namespace App\Http\Controllers;
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Http\Request;

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
            'jenis' => 'required',
            '_token' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //download setup
        $jenis = $request->input('jenis');
        $fileName = $request->input('name');

        //download
        return Excel::download(new LaporanKeuanganExport($jenis), $fileName);
    }
}
