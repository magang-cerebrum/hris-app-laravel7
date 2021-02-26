<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
class UserController extends Controller
{


    public function edit(MasterUser $user)
    {
        // $message = "Error";
       // dd(MasterUser::where('id', '=',Auth::user()->id)->select('password')->get());
        
        if(Route::current()->uri == "admin/password/{user}" && Gate::allows('is_admin')){
            return view('auth.editpass',['pass' => $user,
            // 'message'=>$message
            ]);
        }
        elseif(Route::current()->uri == "admin/password/{user}" && Gate::denies('is_admin')){
            return back();
        }
        elseif(Route::current()->uri == "staff/password/{user}" && Gate::allows('is_staff')){
            return view('auth.editpass',['pass' => $user,
            // 'message'=>$message
            ]);
        }
        elseif(Route::current()->uri == "staff/password/{user}" && Gate::denies('is_staff')){
            return back();
        }
        // else dd("no");
        // dd(Route::current()->uri);
    }

    
    public function update(Request $request, MasterUser $user)
    {   
        
        if (Hash::check($request->oldpassword, $user->password)) {
            // dd(strlen($request->password));
            $request->validate(
                [
                'oldpassword'=>MasterUser::where('id', '=',Auth::user()->id)->select('password')->get(),
                'newpassword'=>'required|min:8'
                ],
            );
            
                
           }
           elseif(!Hash::check($request->oldpassword,MasterUser::where('id', '=',Auth::user()->id)->select('password')->get())) {
               return back()->with('error','Password Lama Salah');
            
            }
            // elseif (strlen($request->newpassword) < 8){
            //     return back()->with('error2','Password Harus 8 karakter');
            // }
            MasterUser::Where('id',$user->id)->update([
               'password'=>Hash::make($request->newpassword)
           ]);
           if(Auth::user()->role_id == 1){
            return redirect('/admin/dashboard');
           }
           else return redirect('/staff/dashboard');
            
    }

}
