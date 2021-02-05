<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
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
            'password' => 'required|string',
            'nip'=>'required|string',
        ]);
        $credentials = $request->only('nip','password');
        if (Auth::attempt($credentials) ) {
            $stats = Auth::User()->role;
            if($stats=='Admin'){
                return redirect('/dashboard/admin');
            }
            elseif($stats == 'Staff'){
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
