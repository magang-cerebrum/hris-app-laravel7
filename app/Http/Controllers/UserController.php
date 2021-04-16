<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{


    public function edit()
    {
        $id = Auth::user()->id;
        $pass = Auth::user()->password;
        if(Route::current()->uri == "admin/password" && Gate::allows('is_admin')){
            return view('auth.editpass',[
                'pass' => $pass,
                'id'=>$id,
            ]);
        }
        elseif(Route::current()->uri == "admin/password" && Gate::denies('is_admin')){
            return back();
        }
        elseif(Route::current()->uri == "staff/password" && Gate::allows('is_staff')){
            return view('auth.editpass',[
                'pass' => $pass,
                'id'=>$id,
            ]);
        }
        elseif(Route::current()->uri == "staff/password" && Gate::denies('is_staff')){
            return back();
        }
    }

    
    public function update(Request $request)
    {   
        $id = Auth::user()->id;
        $pass = Auth::user()->password;
        if (Hash::check($request->oldpassword, $pass)) {
            $request->validate([
                'oldpassword'=>MasterUser::where('id', '=',Auth::user()->id)->select('password')->get(),
                'newpassword'=>'required|min:8'
            ]);
        }
        else if(!Hash::check($request->oldpassword,MasterUser::where('id', '=',Auth::user()->id)->select('password')->get())) {
            return back()->with('error','Password Lama Salah');
        }
        MasterUser::Where('id',$id)->update([
            'password'=>Hash::make($request->newpassword)
        ]);
        Alert::success('Berhasil!', 'Password akun anda berhasil di rubah!');
        if(Auth::user()->role_id == 1){
            return redirect('/admin/dashboard');
        }
        else return redirect('/staff/dashboard');
        
    }

    public function change_photo_profile(Request $request){
        $image = $request->image;

        $image_default = Auth::user()->profile_photo;
        if ($image_default != 'defaultL.jpg' || $image_default != 'defaultP.png') {
            DB::table('master_users')
            ->where('id', '=', Auth::user()->id)
            ->update(['profile_photo' => Auth::user()->name .'.png']);
        }

        $image_array_1 = explode(";", $image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $image_name = 'img/profile-photos/' . Auth::user()->name . '.png';
        file_put_contents($image_name, $data);
    }

}
