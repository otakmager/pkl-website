<?php

namespace App\Http\Controllers;
use App\Models\TKeluar;
use App\Models\Label;
use Illuminate\Http\Request;

class SampahKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $maxData = 5;
        $tkeluars = TKeluar::onlyTrashed()->latest('deleted_at')->paginate($maxData);
        $labels = Label::join('t_keluars', 't_keluars.label_id', '=', 'labels.id')
                ->whereNotNull('t_keluars.deleted_at')
                ->select('labels.id', 'labels.name')
                ->get();

        return view('dashboard.sampah', [
            'title' => "Sampah Transaksi Keluar",
            'transactions' => $tkeluars,
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
    public function sampah_ajax(Request $request){
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
           
            $tkeluars = TKeluar::onlyTrashed()
            ->join('labels', 'labels.id', '=', 't_keluars.label_id')
            ->select('t_keluars.*')
            ->where(function($query) use ($search, $labels, $strDate, $endDate) {
                $query->whereIn('t_keluars.label_id', $labels)
                        ->where(function($query) use ($search) {
                            $query->where('t_keluars.name', 'like', '%' .$search. '%')
                            ->orWhere('t_keluars.nominal', 'like', '%' .$search. '%');
                        })->whereBetween('t_keluars.tanggal', [$strDate, $endDate]);
            })
            ->orderBy($sort_by == 'label_id' ? 'labels.name' : $sort_by, $sort_type)->paginate($maxData);
            return view('dashboard.fetch.sampah-data', [
                'transactions' => $tkeluars,
                'page' => $request->get('page'),
                'maxData' =>$maxData,
            ]);
        }
    }
}
