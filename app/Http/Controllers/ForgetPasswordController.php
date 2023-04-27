<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    public function index(){
        return view('forgetPassword.index');
    }

    // Cek Email
    public function cek(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Melakukan Pengecekan, Data Tidak Sesuai!',
            ]);
        }

        // check if user with email exists
        $email = $request->email;
        $userExists = User::where('email', $email)->exists();
    
        if ($userExists) {
            return response()->json([
                'success' => true,
                'message' => 'Email ditemukan!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan!',
            ]);
        }
    }
}
