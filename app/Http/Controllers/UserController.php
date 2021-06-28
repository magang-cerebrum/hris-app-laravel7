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
        if(Auth::check()){
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
        else {
            return redirect('/login');
        }
    }

    
    public function update(Request $request)
    {   
        if(Auth::check()){
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
        else {
            return redirect('/login');
        }
    }

    public function change_photo_profile(Request $request){
        if(Auth::check()){
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
            Alert::success('Berhasil!','Foto Profil berhasil diperbaharui!');
        }
        else {
            return redirect('/login');
        }
    }

    public function test(){
        if(Auth::check()){
            $data_max_performance = array();
            $data_max_achievement = array();
            
            $division_data = DB::table('master_divisions')->whereNotIn('id',[7])->select('id')->get();
    
            foreach ($division_data as $division) {
                $data = DB::table('master_performances')
                ->leftJoin('master_users','master_performances.user_id','=','master_users.id')
                ->leftJoin('master_divisions','master_performances.division_id','=','master_divisions.id')
                ->where('master_performances.division_id',$division->id)
                ->select([
                    'master_users.name as user_name',
                    'master_divisions.name as division_name',
                    'master_performances.performance_score as score',
                    'month',
                    'year'
                ])
                ->orderBy('performance_score','desc')
                ->first();
                array_push($data_max_performance,$data);
            }
            
            foreach ($division_data as $division) {
                $data = DB::table('master_achievements')
                ->leftJoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
                ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->where('master_users.division_id',$division->id)
                ->select([
                    'master_users.name as user_name',
                    'master_divisions.name as division_name',
                    'master_achievements.score as score',
                    'month',
                    'year'
                ])
                ->orderBy('score','desc')
                ->first();
                array_push($data_max_achievement,$data);
            }
    
            dd($data_max_performance,$data_max_achievement);
        }
        else {
            return redirect('/login');
        }
    }
}
