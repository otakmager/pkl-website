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
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'email'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Sesuai!',
            ]);
        }

        //check data and return response
        if(is_null($user->soal)){            
            return response()->json([
                'success' => false,
                'message' => 'Opsi pertanyaan pemulihan tidak tersedia. Silakan hubungi admin/pimpinan!',
            ]);
        }else{
            $soal = "";
            $hidden = "";
            switch($user->soal){
                case "1": 
                    $soal = "Siapa nama orang yang kamu kenal pertama kali saat masih kecil?";
                    $hidden = "1";
                    break;
                case "2": 
                    $soal = "Apa nama hewan peliharaanmu pertama kali?";
                    $hidden = "2";
                    break;
                case "3": 
                    $soal = "Apa merek mobil/sepeda motor pertama yang kamu miliki?";
                    $hidden = "3";
                    break;
                case "4": 
                    $soal = "Siapa nama panggilan teman masa kecilmu?";
                    $hidden = "4";
                    break;
                case "5": 
                    $soal = "Apa makanan favorit Anda saat masih kecil?";
                    $hidden = "5";
                    break;
                default:
                    $soal = "";
                    $hidden = "";
            }
            return response()->json([
                'success' => true,
                'message' => 'Silakan jawab pertanyaan pemulihan dengan benar!',
                'soal' => $soal,
                'hidden' => $hidden,
            ]);
        }
    }

    public function validasiSoal(Request $request, User $user){
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'    => 'required',
            'email'     => 'required',
            'soal'      => 'required',
            'jawaban'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Soal & Jawaban Gagal, Data Tidak Sesuai!',
            ]);
        }

        //check soal
        if($request->soal != $user->soal){
            return response()->json([
                'success' => false,
                'message' => 'Validasi Soal Gagal, Data Tidak Sesuai!',
            ]);
        }

        //check jawaban
        $isValid = false;
        $message = "Jawaban salah!";
        if(strtolower($request->jawaban) == strtolower($user->jawaban)){
            $isValid = true;
            $message = "Validasi Berhasil!";
        }

        //return response
        return response()->json([
            'success' => true,
            'isValid' => $isValid,
            'message' => $message,
        ]);
    }

    public function resetPass(Request $request, User $user){
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'        => 'required',
            'email'         => 'required',
            'newPassword'   => 'required|min:5|max:255',
            'renewPassword' => 'required|min:5|max:255',
        ]);

        //check if validation fails
        if ($validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Data Tidak Sesuai!',
            ]);
        }
        if ($request->newPassword != $request->renewPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Data Tidak Sesuai!',
            ]);
        }

        //update password
        $password = Hash::make($request->newPassword);
        $user->update([
            'password'   => $password,
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Password Berhasil Diubah!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah!',
            ]);
        } 
    }
}
