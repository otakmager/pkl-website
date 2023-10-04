<?php

namespace App\Http\Controllers;

// use App\DataTables\TMasukDataTable;
use App\Models\TMasuk;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
class TMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxData = 5;
        $tmasuks = TMasuk::latest()->paginate($maxData);
        $labels = Label::whereNull('deleted_at')->where('jenis', 0)->get();
        return view('dashboard.tmasuk', [
            'tmasuks' => $tmasuks,
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
    public function tmasuk_ajax(Request $request){
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
           
            $tmasuks = TMasuk::join('labels', 'labels.id', '=', 't_masuks.label_id')
                    ->select('t_masuks.*')
                    ->where(function($query) use ($search, $labels, $strDate, $endDate) {
                        $query->whereIn('t_masuks.label_id', $labels)
                                ->where(function($query) use ($search) {
                                    $query->where('t_masuks.name', 'like', '%' .$search. '%')
                                    ->orWhere('t_masuks.nominal', 'like', '%' .$search. '%');
                                })->whereBetween('t_masuks.tanggal', [$strDate, $endDate]);
                    })
                    ->orderBy($sort_by == 'label_id' ? 'labels.name' : $sort_by, $sort_type)->paginate($maxData);

            return view('dashboard.fetch.tmasuk-data', [
                'tmasuks' => $tmasuks,
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
        $tmasuk = TMasuk::create([
            'name'     => $request->name, 
            'label_id'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
            'slug'   => Str::slug("tmasuk" . $request->label . Str::random(16) . $request->tanggal),
        ]);

        //return response
        if ($tmasuk) {
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
     * @param  \App\Models\TMasuk  $tmasuk
     * @return \Illuminate\Http\Response
     */
    public function show(TMasuk $tmasuk)
    {
        //return response
        return response()->json($tmasuk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TMasuk  $tmasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(TMasuk $tmasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\Models\TMasuk  $tmasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TMasuk $tmasuk)
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
        $tmasuk->update([
            'name'     => $request->name, 
            'label_id'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
        ]);

        //return response
        if ($tmasuk) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah!',
                'data' => [
                    'id' => $tmasuk->id,
                    'name' => $tmasuk->name,
                    'label' => $tmasuk->label->name,
                    'nominal' => $tmasuk->nominal,
                    'tanggal' => $tmasuk->tanggal,
                ],
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
     * @param  \App\Models\TMasuk  $tmasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(TMasuk $tmasuk)
    {
        $deletedTMasuk = TMasuk::findOrFail($tmasuk->id);
        $deletedTMasuk->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => "Data transaksi masuk berhasil dihapus\ndan dapat dipulihkan sebelum 14 hari sejak dihapus.",
        ]); 
    }
}
