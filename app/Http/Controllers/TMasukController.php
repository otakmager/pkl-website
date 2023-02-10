<?php

namespace App\Http\Controllers;

// use App\DataTables\TMasukDataTable;
use App\Models\TMasuk;
use App\Http\Requests\StoreTMasukRequest;
use App\Http\Requests\UpdateTMasukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
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
        return view('dashboard.tmasuk', [
            'tmasuks' => $tmasuks,
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
            $strDate = $request->get('strdate');
            $endDate = $request->get('enddate');

            $tmasuks = TMasuk::
                where(function($query) use ($search, $labels, $strDate, $endDate) {
                    $query->whereIn('label', $labels)
                            ->where(function($query) use ($search) {
                                $query->where('name', 'like', '%' .$search. '%')
                                ->orWhere('nominal', 'like', '%' .$search. '%');
                            })->whereBetween('tanggal', [$strDate, $endDate]);
                })
                ->orderBy($sort_by, $sort_type)->paginate($maxData);

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
     * @param  \App\Http\Requests\Request  $request
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
            'label'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
            'slug'   => Hash::make("tmasuk" . $request->label . Str::random(16) . $request->tanggal),
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
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(TMasuk $tMasuk)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $tMasuk  
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(TMasuk $tMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TMasuk $tMasuk)
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
        $tMasuk->update([
            'name'     => $request->name, 
            'label'   => $request->label,
            'nominal'   => $request->nominal,
            'tanggal'   => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
        ]);

        //return response
        if ($tMasuk) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui!',
                'data' => $tMasuk,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Diperbarui!',
            ]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(TMasuk $tMasuk)
    {
        //
    }
}
