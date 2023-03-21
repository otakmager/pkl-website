<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
            return response()->json($validator->errors(), 422);
        }

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        //update post
        $user->update([
            'name'     => $request->name,
            'email'     => $request->email,
            'image'     => $request->image,
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diubah!',
                'data' => $user,
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
        ]);

        //check if validation fails
        if ($validator->fails() || ($request->oldpassword != $request->newpassword)) {
            return response()->json($validator->errors(), 422);
        }

        //update post
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
            return response()->json($validator->errors(), 422);
        }

        $username = $request->input('username');
        $checkUser = User::findOrFail($username);
        if($checkUser){
            $user->update([
                'image'   => NULL,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Foto Profile Berhasil Dihapus!',
            ]);
        }else{
            return response()->json($validator->errors(), 422);
        }
    }
}
