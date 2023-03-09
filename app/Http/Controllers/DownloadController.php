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
        // return Excel::download(new LaporanKeuanganExport($formatLaporan, $str_date, $end_date), $fileName);
        return Excel::download(new LapKeuDriverExport($formatLaporan, $str_date, $end_date, $labels), $fileName);
    }



    // public function downloadExcel(Request $request)
    // {
    //     // Ambil data dari model TMasuk
    //     $tmasuks = TMasuk::all();

    //     // Definisikan data kas awal bulan ini
    //     $danaBulanIni = 1000000;

    //     // Definisikan header dan footer pada file excel
    //     $header = [
    //         'Nama Perusahaan',
    //         'Alamat Perusahaan',
    //     ];

    //     $footer = [
    //         ['Rekap Akhir', '', '', '', TMasuk::sum('nominal')],
    //         ['Sisa Uang', '', '', '', $danaBulanIni - TMasuk::sum('nominal')],
    //     ];

    //     // Definisikan body pada file excel
    //     $body = [];
    //     $body[] = ['Judul Laporan'];
    //     $body[] = ['', '', '', '', ''];

    //     // Tambahkan data dari model TMasuk ke dalam body
    //     $nomor = 1;
    //     foreach ($tmasuks as $tmasuk) {
    //         $body[] = [
    //             $nomor,
    //             $tmasuk->name,
    //             $tmasuk->label,
    //             $tmasuk->nominal,
    //             $tmasuk->tanggal,
    //         ];
    //         $nomor++;
    //     }

    //     // Generate file excel menggunakan library maatwebsite/excel
    //     $fileName = 'laporan.xlsx';
    //     return Excel::download(function ($excel) use ($header, $body, $footer) {
    //         $excel->sheet('Sheet 1', function ($sheet) use ($header, $body, $footer) {
    //             $sheet->fromArray($header, null, 'A1', false, false);
    //             $sheet->fromArray($body, null, 'A4', false, false);
    //             $sheet->fromArray($footer, null, 'A' . (count($body) + 5), false, false);
    //         });
    //     }, $fileName);
    // }
    

}
