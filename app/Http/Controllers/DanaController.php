<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use App\Models\TMasuk;
use App\Models\TKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Dana  $dana
     * @return \Illuminate\Http\Response
     */
    public function show(Dana $dana)
    {
        //return response
        return response()->json($dana);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dana  $dana
     * @return \Illuminate\Http\Response
     */
    public function edit(Dana $dana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  \App\Models\Dana  $dana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dana $dana)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'uang' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update post
        $dana->update([
            'uang'     => $request->uang, 
        ]);

        //return response
        if ($dana) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah!',
                'sisa' => intval(Dana::sum('uang') + TMasuk::sum('nominal') - TKeluar::sum('nominal')),
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
     * @param  \App\Models\Dana  $dana
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dana $dana)
    {
        //
    }
}
