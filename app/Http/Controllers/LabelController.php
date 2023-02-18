<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\TMasuk;
use App\Models\TKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxData = 5;
        $labels = Label::latest()->paginate($maxData);
        return view('dashboard.label', [
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
    public function label_ajax(Request $request){
        if(request()->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $maxData= (int)$request->get('maxdata');
            $jenis = $request->get('jenis');
            $jenis = explode(',', $jenis);
            $jenis = array_map('intval', $jenis);
           
            $labels = Label::where('name', 'like', '%' . $search . '%')->whereIn('jenis', $jenis)
                        ->orderBy($sort_by, $sort_type)->paginate($maxData);

            return view('dashboard.fetch.label-data', [
                'labels' => $labels,
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
            'jenis' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $label = Label::create([
            'name'     => $request->name, 
            'jenis'   => $request->jenis,
            'slug'   => Hash::make("label" . $request->name . Str::random(16) . $request->jenis),
        ]);

        //return response
        if ($label) {
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
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //return response
        return response()->json($label);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'jenis' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update post
        $label->update([
            'name'     => $request->name, 
            'jenis'   => $request->jenis,
        ]);

        //return response
        if ($label) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah!',
                'data' => $label,
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
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function label_sum(Label $label)
    {
        $sumMasuk = TMasuk::where('label_id', $label->id)->count();
        $sumKeluar = TKeluar::where('label_id', $label->id)->count();
        $sum = ($sumMasuk > $sumKeluar)? $sumMasuk : $sumKeluar;

        //return response
        return response()->json([
            'success' => true,
            'sum' => $sum,
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $deletedTLabel = Label::findOrFail($label->id);
        $deletedTLabel->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => "Data label berhasil dihapus",
        ]); 
    }
}
