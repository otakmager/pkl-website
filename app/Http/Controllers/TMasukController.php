<?php

namespace App\Http\Controllers;

// use App\DataTables\TMasukDataTable;
use App\Models\TMasuk;
use App\Http\Requests\StoreTMasukRequest;
use App\Http\Requests\UpdateTMasukRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
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
     * @param  \App\Http\Requests\StoreTMasukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTMasukRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(TMasuk $tMasuk)
    {
        //
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
     * @param  \App\Http\Requests\UpdateTMasukRequest  $request
     * @param  \App\Models\TMasuk  $tMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTMasukRequest $request, TMasuk $tMasuk)
    {
        //
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
