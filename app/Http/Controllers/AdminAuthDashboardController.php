<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class AdminAuthDashboardController extends Controller
{
    public function index(){
        if(Gate::denies('is_admin')){
            return abort(403,'Must be Admin');
        }
        else if(Gate::allows('is_admin')){
            // return 'Admin';
            return view('dashboard.admin');
        }
    }
}
