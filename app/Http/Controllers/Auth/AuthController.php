<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function redirect(){
        return redirect('/login');
    }
    public function login()
    {
        if (Auth::check()==false){
            Cookie::forget('XSRF-TOKEN');
            Cookie::forget('laravel_session');
            return view('auth/login');
        }
        else if(Auth::check() == true){
            Cookie::forget('XSRF-TOKEN');
            Cookie::forget('laravel_session');
            $stats = Auth::User()->role_id;
            if($stats==1){
                return redirect('/admin/dashboard');
            }
            else if($stats == 2){
                return redirect('/staff/dashboard');
            }
        }
    }

    protected function authenticate(Request $request)
    {
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
                Alert::toast('Selamat Datang di HRIS! Anda sekarang Login menggunakan Browser '.$browser, 'success')
                ->width(460)
                ->timerProgressBar()
                ->background('#FFDB26');
                return redirect()->intended('/admin/dashboard');
            }
            elseif($stats == 2 && $employeeStats=="Aktif"){
                Auth::logoutOtherDevices($request->password);
                $device = $agent->platform();
                $browser = $agent->browser();
                activity()->log($user.' Telah Login (Staff) pada platform ' . $device);
                Alert::toast('Selamat Datang di HRIS! Anda sekarang Login menggunakan Browser '.$browser, 'success')
                ->width(460)
                ->timerProgressBar()
                ->background('#FFDB26');
                return redirect('/staff/dashboard');
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
            if (empty(Auth::user()->role_id)) {
                return redirect('/login');
            }
            $stats = Auth::user()->role_id;
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