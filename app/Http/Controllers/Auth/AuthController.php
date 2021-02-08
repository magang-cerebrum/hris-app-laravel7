<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\MasterUser;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login()
    {
    if (Auth::check()==false){
        return view('auth.login');
    }
    elseif(Auth::check() == true){
        $stats = Auth::User()->role_id;
        if($stats==1){
            return redirect('/admin/dashboard');
        }
        elseif($stats == 2){
            return redirect('/staff/dashboard');
        }
        // else return redirect('/login');
    }
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'nip'=>'required|string',
            'password' => 'required|string',
        ]);
        // $user = MasterUser::all();
        $credentials = $request->only('nip','password');
        // $remember_me  = $request->remember ? true : false;
        if (Auth::attempt($credentials) ) {
            $userlog = MasterUser::where(['nip'=>$credentials['nip']]);
            $stats = Auth::User()->role_id;
            if($stats==1){
                return redirect('/admin/dashboard');
            }
            elseif($stats == 2){
                return redirect('/staff/dashboard');
            }
            // return dd(MasterUser::all());
        }
        // else if (!Hash::check( $request->password,$user->password)   ){
        //     // $request->validate([
        //     //     // 'oldpassword'=>User::get()->password,
        //     //     'newpassword'=>'required'
        //     //     ]);
        //     return back()->with('error','Password Salah !');
        // }
        // return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
