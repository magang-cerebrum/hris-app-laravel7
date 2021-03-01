<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{


    public function edit()
    {
        // $message = "Error";
       // dd(MasterUser::where('id', '=',Auth::user()->id)->select('password')->get());
       $id = Auth::user()->id;
       $pass = Auth::user()->password;
        if(Route::current()->uri == "admin/password" && Gate::allows('is_admin')){
           
            return view('auth.editpass',['pass' => $pass,
            'id'=>$id,
            ]);
        }
        elseif(Route::current()->uri == "admin/password" && Gate::denies('is_admin')){
            return back();
        }
        elseif(Route::current()->uri == "staff/password" && Gate::allows('is_staff')){
            return view('auth.editpass',['pass' => $pass,
            'id'=>$id,
            ]);
        }
        elseif(Route::current()->uri == "staff/password" && Gate::denies('is_staff')){
            return back();
        }
        // else dd("no");
        // dd(Route::current()->uri);
    }

    
    public function update(Request $request)
    {   
        $id = Auth::user()->id;
        $pass = Auth::user()->password;
        if (Hash::check($request->oldpassword, $pass)) {
            // dd(strlen($request->password));
            $request->validate(
                [
                'oldpassword'=>MasterUser::where('id', '=',Auth::user()->id)->select('password')->get(),
                'newpassword'=>'required|min:8'
                ]
            );
            
                
           }
           elseif(!Hash::check($request->oldpassword,MasterUser::where('id', '=',Auth::user()->id)->select('password')->get())) {
               return back()->with('error','Password Lama Salah');
            
            }
            // elseif (strlen($request->newpassword) < 8){
            //     return back()->with('error2','Password Harus 8 karakter');
            // }
            
            MasterUser::Where('id',$id)->update([
               'password'=>Hash::make($request->newpassword)
           ]);
           Alert::success('Berhasil!', 'Password akun anda berhasil di rubah!');
           if(Auth::user()->role_id == 1){
            return redirect('/admin/dashboard');
           }
           else return redirect('/staff/dashboard');
            
    }

}
