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
        return view('auth.login');
    }

    protected function authenticate(Request $request)
    {
        $agent = new Agent();
        $request->validate([
            'nip'=>'required|string',
            'password' => 'required|string',
        ]);
        // dd($request);
        $user = MasterUser::where('nip',$request->nip)->first();
        
        $credentials = $request->only('nip','password');
        // auth()->logoutOtherDevices('password');
    //    Auth::logoutOtherDevices(request('password'));
        if (Auth::attempt($credentials) ) {
            // dd(Auth::logoutOtherDevices('password'));
            
            $stats = Auth::User()->role_id;
            $user = Auth::user()->name;
            if($stats==1){
                // dd(Auth::logoutOtherDevices('password'));
                // Auth::logoutOtherDevices($request->password);
                // dd(Auth::logoutOtherDevices($request->password));
                $device = $agent->platform();
                // dd($device);
                activity()->log($user.' Telah Login (Admin) pada platform ' . $device);
                return redirect('/admin/dashboard');
            }
            elseif($stats == 2){
                Auth::logoutOtherDevices($request->password);
                
                $device = $agent->platform();
                $browser = $agent->browser();
               
                activity()->log($user.' Telah Login (Staff) pada platform ' . $device);
                return redirect('/staff/dashboard')->with('status', 'Selamat Datang di HRIS! Anda sekarang sedang Login menggunakan Browser '.$browser);
                // return view('staff',['test'=>$test]);
            }

            
        }
        else if ( !Hash::check($request->password,$user['password']) or $request->nip!=$user['nip']){
            // $request->validate([
            //     // 'oldpassword'=>User::get()->password,
            //     'newpassword'=>'required'
            //     ]);
            return back()->with('error','NIP atau Password Salah !');
        }
        // else if($request->nip!=$user['nip']){
        //     return back()->with('errornip','NIP tidak ditemukan !');
        // }
        // else if (!Hash::check($request->nip, $user[0]->nip)){

        // }

        // return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');

        }
        public function logout() {
            $stats = Auth::User()->role_id;
            $user = Auth::user()->name;
            if($stats==1){
                // Log::channel('hris_log')->info($user.' Telah Login (Admin)');
                activity()->log($user.' Telah Logout (Admin)');
            
            }
            elseif($stats == 2){
                // Log::channel('hris_log')->info($user.' Telah Login (Staff)');
                activity()->log($user.' Telah Logout (Staff)');
               
            }
            Auth::logout();
            return redirect('/login');
        }
    }


