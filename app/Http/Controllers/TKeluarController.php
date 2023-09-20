<?php

namespace App\Http\Controllers;

use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxData = 5;
        $tkeluars = TKeluar::latest()->paginate($maxData);
        $labels = Label::whereNull('deleted_at')->where('jenis', 1)->get();
        return view('dashboard.tkeluar', [
            'tkeluars' => $tkeluars,
            'labels' => $labels,
            'maxData' => 5,
        ]);
    }

    /**
     * Filter, pencarian, dan sorting dengan ajax
     *
     * @param Request $request
     * @return view + data query + data untuk pagination
     */
    public function tkeluar_ajax(Request $request){
        if(request()->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $maxData= (int)$request->get('maxdata');
            $labels = $request->get('labeldata');
            $labels = explode(',', $labels);
            $labels = array_map('intval', $labels);
            $strDate = $request->get('strdate');
            $endDate = $request->get('enddate');
           
            $tkeluars = TKeluar::join('labels', 'labels.id', '=', 't_keluars.label_id')
                    ->select('t_keluars.*')
                    ->where(function($query) use ($search, $labels, $strDate, $endDate) {
                        $query->whereIn('t_keluars.label_id', $labels)
                                ->where(function($query) use ($search) {
                                    $query->where('t_keluars.name', 'like', '%' .$search. '%')
                                    ->orWhere('t_keluars.nominal', 'like', '%' .$search. '%');
                                })->whereBetween('t_keluars.tanggal', [$strDate, $endDate]);
                    })
                    ->orderBy($sort_by == 'label_id' ? 'labels.name' : $sort_by, $sort_type)->paginate($maxData);

            return view('dashboard.fetch.tkeluar-data', [
                'tkeluars' => $tkeluars,
                'page' => $request->get('page'),
                'maxData' =>$maxData,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'label' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $tkeluar = TKeluar::create([
            'name'     => $request->name, 
            'label_id'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
            'slug'   => Str::slug("tkeluar" . $request->label . Str::random(16) . $request->tanggal),
        ]);

        //return response
        if ($tkeluar) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan!',
            ]);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TKeluar  $tkeluar
     * @return \Illuminate\Http\Response
     */
    public function show(TKeluar $tkeluar)
    {
        //return response
        return response()->json($tkeluar);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TKeluar  $tkeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(TKeluar $tkeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\Models\TKeluar  $tkeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TKeluar $tkeluar)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'label' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update post
        $tkeluar->update([
            'name'     => $request->name, 
            'label_id'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
        ]);

        //return response
        if ($tkeluar) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah!',
                'data' => $tkeluar,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Diubah!',
            ]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TKeluar  $tkeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(TKeluar $tkeluar)
    {
        $deletedTKeluar = TKeluar::findOrFail($tkeluar->id);
        $deletedTKeluar->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => "Data transaksi keluar berhasil dihapus\ndan dapat dipulihkan sebelum 14 hari sejak dihapus.",
        ]); 
    }
}
