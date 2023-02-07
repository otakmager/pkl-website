<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
