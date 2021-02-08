<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
class StaffAuthDashboardController extends Controller
{
    public function index(){
        if(Gate::denies('is_staff')/*&& Auth::check()==false*/){
            return abort(403,'Staff must Login First');
        }
        else if(Gate::allows('is_staff') /*&& Auth::check()==true*/){
            // return 'Staff';
            $user = Auth::user(); 
            return view('dashboard.staff',[
                'nama'=>$user->name,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }
    
}
