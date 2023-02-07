<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){        
        // For development
        return view('dashboard.dashboard-admin');

        // For production
        if(auth()->user()->level === 'pimpinan'){
            return view('dashboard.dashboard-admin');
        }else{
            return view('dashboard.dashboard-user');
        }
    }
}
