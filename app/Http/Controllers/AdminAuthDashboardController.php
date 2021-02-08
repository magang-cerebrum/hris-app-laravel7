<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
class AdminAuthDashboardController extends Controller
{
    public function index(){
        if(Gate::denies('is_admin')){
            return abort(403,'Must be Admin');
        }
        else if(Gate::allows('is_admin')){
            // return 'Admin';
            $user = Auth::user();

            return view('dashboard.admin',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }
}
