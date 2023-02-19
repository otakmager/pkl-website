<?php

namespace App\Http\Controllers;
use App\Models\TMasuk;
use App\Models\Label;
use Illuminate\Http\Request;

class SampahMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $maxData = 5;
        $tmasuks = TMasuk::onlyTrashed()->latest('deleted_at')->paginate($maxData);
        $labels = Label::join('t_masuks', 't_masuks.label_id', '=', 'labels.id')
                ->whereNotNull('t_masuks.deleted_at')
                ->select('labels.id', 'labels.name')
                ->get();

        return view('dashboard.sampah', [
            'title' => "Sampah Transaksi Masuk",
            'transactions' => $tmasuks,
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
           
            $tmasuks = TMasuk::onlyTrashed()
            ->join('labels', 'labels.id', '=', 't_masuks.label_id')
            ->select('t_masuks.*')
            ->where(function($query) use ($search, $labels, $strDate, $endDate) {
                $query->whereIn('t_masuks.label_id', $labels)
                        ->where(function($query) use ($search) {
                            $query->where('t_masuks.name', 'like', '%' .$search. '%')
                            ->orWhere('t_masuks.nominal', 'like', '%' .$search. '%');
                        })->whereBetween('t_masuks.tanggal', [$strDate, $endDate]);
            })
            ->orderBy($sort_by == 'label_id' ? 'labels.name' : $sort_by, $sort_type)->paginate($maxData);
            return view('dashboard.fetch.sampah-data', [
                'transactions' => $tmasuks,
                'page' => $request->get('page'),
                'maxData' =>$maxData,
            ]);
        }
    }
}
