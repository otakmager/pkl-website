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
                ->groupBy('labels.id', 'labels.name')
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

    /**
     * Remove permanent the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedTMasuk = TMasuk::onlyTrashed()->findOrFail($id);

        // Check related label to delete label permanent
        $labelId = $deletedTMasuk->label_id;
        $label = Label::findOrFail($labelId);
        $related = TMasuk::withTrashed()->where('label_id', $label->id)->count();
        if($label && $label->deleted_at !== NULL && $related == 1){
            // Delete data permanent
            $deletedTMasuk->forceDelete();
            // Delete label permanent
            $label->delete();
        }else{
            // Delete data permanent
            $deletedTMasuk->forceDelete();
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => "Data sampah transaksi masuk berhasil dihapus secara permanen.",
        ]); 
    }

    /**
     * Remove permanent some tmasuks
     *
     * @param Request $request
     * @return message
     */
    public function destroySelectedData(Request $request)
    {
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $deletedTMasuk = TMasuk::onlyTrashed()->findOrFail($id);

            // Check related label to delete label permanent
            $labelId = $deletedTMasuk->label_id;
            $label = Label::findOrFail($labelId);
            $related = TMasuk::withTrashed()->where('label_id', $label->id)->count();
            if($label && $label->deleted_at !== NULL && $related == 1){
                // Delete data permanent
                $deletedTMasuk->forceDelete();
                // Delete label permanent
                $label->delete();
            }else{
                // Delete data permanent
                $deletedTMasuk->forceDelete();
            }
        }
        //return response
        return response()->json([
            'success' => true,
            'message' =>  $request->input('total') . " data sampah transaksi masuk berhasil dihapus secara permanen.",
        ]);
    }

    /**
     * Remove permanent all tmasuks
     *
     * @param
     * @return message
     */
    public function destoryAll()
    {
        // Get all trashed data
        $deletedTMasuks = TMasuk::onlyTrashed()->get();

        foreach ($deletedTMasuks as $deletedTMasuk) {
            // Check related label to delete label permanent
            $labelId = $deletedTMasuk->label_id;
            $label = Label::findOrFail($labelId);
            $related = TMasuk::withTrashed()->where('label_id', $label->id)->count();
            if($label && $label->deleted_at !== NULL && $related == 1){
                // Delete data permanent
                $deletedTMasuk->forceDelete();
                // Delete label permanent
                $label->delete();
            }else{
                // Delete data permanent
                $deletedTMasuk->forceDelete();
            }
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => "Semua data sampah transaksi masuk berhasil dihapus secara permanen.",
        ]);
    }

    /**
     * Restore tmasuks
     *
     * @param $id
     * @return message
     */
    public function restore($id)
    {
        // Get data
        $data = TMasuk::onlyTrashed()->findOrFail($id);
        
        // Check label to restore if it's deleted
        $labelId = $data->label_id;
        $label = Label::findOrFail($labelId);
        if($label && $label->deleted_at !== NULL){
            $label->update([
                'deleted_at' => NULL,
            ]);
        }

        // Restore data
        $data->restore();
        
        //return response
        return response()->json([
            'success' => true,
            'message' => "Data berhasil dipulihkan.",
        ]);
    }

    /**
     * Restore some tmasuks
     *
     * @param Request $request
     * @return message
     */
    public function restoreSelectedData(Request $request)
    {
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            // Get data 
            $data = TMasuk::onlyTrashed()->findOrFail($id);

            // Check label to restore if it's deleted
            $labelId = $data->label_id;
            $label = Label::findOrFail($labelId);
            if($label && $label->deleted_at !== NULL){
                $label->update([
                    'deleted_at' => NULL,
                ]);
            }

            // Restore data 
            $data->restore();
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => $request->input('total') . " data yang terpilih berhasil dipulihkan.",
        ]);
    }

    /**
     * Restore all tmasuks
     *
     * @param
     * @return message
     */
    public function restoreAll()
    {
        // Get all trashed data
        $datas = TMasuk::onlyTrashed()->get();

        foreach ($datas as $data) {
            // Check label to restore if it's deleted
            $labelId = $data->label_id;
            $label = Label::findOrFail($labelId);
            if($label && $label->deleted_at !== NULL){
                $label->update([
                    'deleted_at' => NULL,
                ]);
            }

            // Restore data 
            $data->restore();
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => "Semua data transaksi masuk berhasil dipulihkan.",
        ]);
    }
}
