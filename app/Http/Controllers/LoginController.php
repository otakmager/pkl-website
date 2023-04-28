<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }
    public function authenticate(Request $request){
        $credential = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if(Auth::attempt($credential)){
            $request->session()->regenerate();

            // Delete sampah masuk
            $maxSave = 14; // jumlah hari maksimal untuk menyimpan data terhapus
            $deletedTMasuks = TMasuk::onlyTrashed()
                                ->where('deleted_at', '<=', now()->subDays($maxSave))
                                ->get();
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
            // Delete sampah keluar
            $deletedTKeluars = TKeluar::onlyTrashed()
                                ->where('deleted_at', '<=', now()->subDays($maxSave))
                                ->get();
            foreach ($deletedTKeluars as $deletedTKeluar) {
                // Check related label to delete label permanent
                $labelId = $deletedTKeluar->label_id;
                $label = Label::findOrFail($labelId);
                $related = TKeluar::withTrashed()->where('label_id', $label->id)->count();
                if($label && $label->deleted_at !== NULL && $related == 1){
                    // Delete data permanent
                    $deletedTKeluar->forceDelete();
                    // Delete label permanent
                    $label->delete();
                }else{
                    // Delete data permanent
                    $deletedTMasuk->forceDelete();
                }
            }

            // Redirect ke dashboard
            return redirect()->intended('/dashboard');
        }
        return back()->with('loginError', 'Email atau kata sandi salah!');
    }
    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
