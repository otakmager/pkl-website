<?php

namespace App\Http\Controllers;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index(){
        $maxData = 5;
        $tmasuks = TMasuk::onlyTrashed()->latest('deleted_at')->paginate($maxData);
        $labels = Label::withTrashed()->get();
        return view('dashboard.sampah', [
            'tmasuks' => $tmasuks,
            'labels' => $labels,
            'maxData' => 5,
        ]);
    }
}
