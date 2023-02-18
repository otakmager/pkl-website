<?php

namespace App\Http\Controllers;
use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Http\Request;

class SampahKeluarController extends Controller
{
    public function index(){
        $maxData = 5;
        $tkeluars = TKeluar::onlyTrashed()->latest('deleted_at')->paginate($maxData);
        $labels = Label::withTrashed()->get();
        return view('dashboard.sampah', [
            'title' => "Sampah Transaksi Keluar",
            'transactions' => $tkeluars,
            'labels' => $labels,
            'maxData' => 5,
        ]);
    }
}
