<?php

namespace App\Http\Controllers;

use App\Models\TKeluar;
use App\Http\Requests\StoreTKeluarRequest;
use App\Http\Requests\UpdateTKeluarRequest;

class TKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.tkeluar', [
            'tkeluars' => TKeluar::all(),
        ]);
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
     * @param  \App\Http\Requests\StoreTKeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTKeluarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TKeluar  $tKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(TKeluar $tKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TKeluar  $tKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(TKeluar $tKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTKeluarRequest  $request
     * @param  \App\Models\TKeluar  $tKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTKeluarRequest $request, TKeluar $tKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TKeluar  $tKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(TKeluar $tKeluar)
    {
        //
    }
}
