<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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

            // $tmasuks = Label::join('labels', 'labels.id', '=', 't_masuks.label_id')
            //         ->select('t_masuks.*')
            //         ->where(function($query) use ($search, $labels, $strDate, $endDate) {
            //             $query->whereIn('t_masuks.label_id', $labels)
            //                     ->where(function($query) use ($search) {
            //                         $query->where('t_masuks.name', 'like', '%' .$search. '%')
            //                         ->orWhere('t_masuks.nominal', 'like', '%' .$search. '%');
            //                     })->whereBetween('t_masuks.tanggal', [$strDate, $endDate]);
            //         })
            //         ->orderBy($sort_by == 'label_id' ? 'labels.name' : $sort_by, $sort_type)->paginate($maxData);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        //
    }
}
