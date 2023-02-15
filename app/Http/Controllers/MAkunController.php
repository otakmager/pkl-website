<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maxData = 5;
        $users = User::orderBy('level', 'asc', 'created_at', 'desc')->paginate($maxData);
        return view('dashboard.makun', [
            'users' => $users,
            'maxData' => 5,
        ]);
    }

    /**
     * Filter, pencarian, dan sorting dengan ajax
     *
     * @param Request $request
     * @return view + data query + data untuk pagination
     */
    public function makun_ajax(Request $request){
        if(request()->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $maxData= (int)$request->get('maxdata');
            $status = $request->get('status');
            $status = explode(',', $status);
            $status = array_map('intval', $status);

            $users = User::where(function($query) use ($search, $status) {
                $query->whereIn('status', $status)
                        ->where(function($query) use ($search) {
                            $query->where('name', 'like', '%' .$search. '%')
                            ->orWhere('email', 'like', '%' .$search. '%');
                        });
            })
            ->orderBy('level', 'asc', $sort_by, $sort_type)->paginate($maxData);

            return view('dashboard.fetch.makun-data', [
                'users' => $users,
                'page' => $request->get('page'),
                'maxData' =>$maxData,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $user = User::create([
            'name'     => $request->name, 
            'username'   => Hash::make("user" . $request->name . Str::random(16)),
            'email'   => $request->email,
            'password'   => Hash::make($request->password),
            'level' => 'user',
            'status' => 1,
        ]);

        //return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Akun Berhasil Dibuat!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Akun Gagal Dibuat!',
            ]);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $makun
     * @return \Illuminate\Http\Response
     */
    public function show(User $makun)
    {
        // return response
        return response()->json([
            'id' => $makun->id,
            'username' => $makun->username,
            'name' => $makun->name,
            'email' => $makun->email
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $makun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $makun)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:5|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update post
        $makun->update([
            'password'   => Hash::make($request->password)
        ]);

        //return response
        if ($makun) {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $makun
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $makun)
    {
        $deletedTUser = User::findOrFail($makun->id);
        $deletedTUser->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => "Akun berhasil dihapus secara permanen",
        ]); 
    }
}
