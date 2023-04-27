<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
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

    public function getSoal(Request $request, User $user){
        return view('forgetPassword.index');
    }
    public function validasaiSoal(Request $request, User $user){
        return view('forgetPassword.index');
    }

    public function resetPass(Request $request, User $user){
        
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'        => 'required',
            'email'      => 'required',
            'newPassword'   => 'required',
            'renewPassword'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Data Tidak Sesuai!',
            ]);
        }
        if ($request->newpassword != $request->renewpassword) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Data Tidak Sesuai!',
            ]);
        }

        //update password
        $user->update([
            'password'   => Hash::make($request->newpassword)
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Password Berhasil Diubah!',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah!',
            ]);
        } 
    }
}
