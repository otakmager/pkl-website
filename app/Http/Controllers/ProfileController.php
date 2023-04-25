<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Open view
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'name' => auth()->user()->name,
            'username' => auth()->user()->username,
            'email' => auth()->user()->email,
            'image' => auth()->user()->image,
            'image' => auth()->user()->image,
        ];
        return view('profile.index', [
            'data' => $data,
        ]);
    }

    /**
     * Update name, email, and image to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'    => 'required',
            'username'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'image'     => 'image|file|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Perbarui Data, Data Tidak Sesuai dan Pastikan Gambar Harus Kurang dari 2 MB!',
            ]);
        }     
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah x!',
            'data' => [
                'name' => $request->name,
                'email' => $request->email,
                'imageAuth' => auth()->user()->image,
                'image' => $request->image,
            ],
        ]);   
        if (auth()->user()->username != $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Perbarui Data, Username Tidak Sesuai!',
            ]);
        }
        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('profile-images');
        }

        //update user
        $user->update([
            'name'     => $request->name,
            'email'     => $request->email,
            'image'     => $request->image,
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah x!',
                'data' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'image' => auth()->user()->image,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Diubah!',
            ]);
        }    
    }
    
    /**
     * Reset password and then update to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPass(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'        => 'required',
            'username'      => 'required',
            'oldPassword'   => 'required',
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
        if (auth()->user()->username != $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menghapus Foto Profile, Username Tidak Sesuai!',
            ]);
        }
        if ($request->newpassword != $request->renewpassword) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Data Tidak Sesuai!',
            ]);
        }
        if ($request->newpassword != $user->password) {
            return response()->json([
                'success' => false,
                'message' => 'Password Gagal Diubah, Password Lama Salah!',
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

    /**
     * Delete image profile and delete from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request, User $user){
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'username' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menghapus Foto Profile, Data Tidak Sesuai!',
            ]);
        }
        if (auth()->user()->username != $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menghapus Foto Profile, Username Tidak Sesuai!',
            ]);
        }

        //update image
        $user->update([
            'image'   => NULL
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Foto Profile Berhasil Diubah!',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Foto Profile Gagal Diubah!',
            ]);
        } 
    }

    

    /**
     * Get recovery info
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function recovInfo(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token'    => 'required',
            'username'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error, Data Tidak Sesuai!',
            ]);
        }
        if (auth()->user()->username != $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Error, Username Tidak Sesuai!',
            ]);
        }

        //check data
        if(is_null($user->soal)){
            $data = [
                'isAda' => false,
                'soal' => NULL,
                'jawaban' => NULL,
            ];
        }else{
            $data = [
                'isAda' => true,
                'soal' => $user->soal,
                'jawaban' => $user->jawaban,
            ];
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Bisa diproses!',
            'data' => $data,
        ]);   
    }

    /**
     * Update recovery method (soal+jawaban)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRecov(Request $request, User $user){
        //define validation rules
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'username' => 'required',
            'flag' => 'required',
            'soal' => 'required',
            'jawaban' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Update, Data Tidak Sesuai!',
            ]);
        }
        if (auth()->user()->username != $request->username) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Update, Username Tidak Sesuai!',
            ]);
        }

        $isSuccess = false;
        //update data recovery
        if($request->flag == "NULL"){
            $user->update([
                'soal'   => NULL,
                'jawaban'   => NULL,
            ]);
            $isSuccess = true;
        }else if($request->flag == "NOT NULL"){
            $user->update([
                'soal'   => intval($request->soal),
                'jawaban'   => $request->jawaban,
            ]);
            $isSuccess = true;
        }        

        //return response
        if ($user && $isSuccess) {
            return response()->json([
                'success' => true,
                'message' => 'Metode Pemulihan Berhasil Diubah!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Metode Pemulihan Gagal Diubah!',
            ]);
        } 
    }
}
