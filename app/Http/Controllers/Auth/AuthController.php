<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\MasterUser;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function redirect(){
        return redirect('/login');
    }
    public function login()
    {
        // dd(Auth::guest());
        if (Auth::check()==false){
            // dd(Cookie::get());
            Cookie::forget('XSRF-TOKEN');
            Cookie::forget('laravel_session');
            return view('auth.login');
        }
        elseif(Auth::check() == true){
            Cookie::forget('XSRF-TOKEN');
            Cookie::forget('laravel_session');
            $stats = Auth::User()->role_id;
            if($stats==1){
                return redirect('/admin/dashboard');
            }
            elseif($stats == 2){
                return redirect('/staff/dashboard');
            }
            // else return redirect('/login');
        }

        // return view('auth.login');
    }

    protected function authenticate(Request $request)
    {
        // dd(Auth::guest());
        Cookie::forget('XSRF-TOKEN');
        Cookie::forget('laravel_session');
        $request->session()->flush();
        $agent = new Agent();
        $request->validate([
            'nip'=>'required|string',
            'password' => 'required|string',
        ]);
        $user = MasterUser::where('nip',$request->nip)->first();
        $credentials = $request->only('nip','password');
        if (Auth::attempt($credentials) ) {
            
            $employeeStats= Auth::user()->status;
            $stats = Auth::User()->role_id;
            $user = Auth::user()->name;
            if($stats==1 && $employeeStats=="Aktif"){ 
                Auth::logoutOtherDevices($request->password);
                $device = $agent->platform();
                $browser = $agent->browser();
                activity()->log($user.' Telah Login (Admin) pada platform ' . $device);
                return redirect()->intended('/admin/dashboard')->with('status', 'Selamat Datang di HRIS! Anda sekarang sedang Login menggunakan Browser '.$browser);
            }
            elseif($stats == 2&& $employeeStats=="Aktif"){
                Auth::logoutOtherDevices($request->password);
                
                $device = $agent->platform();
                $browser = $agent->browser();
               
                activity()->log($user.' Telah Login (Staff) pada platform ' . $device);
                return redirect('/staff/dashboard')->with('status', 'Selamat Datang di HRIS! Anda sekarang sedang Login menggunakan Browser '.$browser);
            }
            elseif($stats ==1 && $employeeStats=="Non-Aktif"){
                return redirect('/logout');
            }
            elseif($stats ==2 && $employeeStats=="Non-Aktif"){
                return redirect('/logout');
            }

            
        }
        else if ( !Hash::check($request->password,$user['password']) or $request->nip!=$user['nip']){
            return back()->with('error','NIP atau Password Salah !');
        }
        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');

        }
        public function logout() {
            $stats = Auth::User()->role_id;
            $user = Auth::user()->name;
            if($stats==1){
                activity()->log($user.' Telah Logout (Admin)');
            
            }
            elseif($stats == 2){
                activity()->log($user.' Telah Logout (Staff)');
            }
            Auth::logout();
            return redirect('/login');
        }
    }


