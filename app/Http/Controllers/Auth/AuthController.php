<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;
class AuthController extends Controller
{
    public function login()
    {

    return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'nip'=>'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('nip','password');
        if (Auth::attempt($credentials) ) {
            $stats = Auth::User()->role_id;
            if($stats==1){
                return redirect('/dashboard/admin');
            }
            elseif($stats == 2){
                return redirect('/dashboard/staff');
            }
        }
        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }
}
