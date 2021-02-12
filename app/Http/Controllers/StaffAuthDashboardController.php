<?php

namespace App\Http\Controllers;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StaffAuthDashboardController extends Controller
{
    public function index(){
        if(Gate::denies('is_staff')){
            return abort(403,'Staff must Login First');
        }
        else if(Gate::allows('is_staff')){
            // return 'Staff';
            $user = Auth::user(); 

            return view('dashboard.staff',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }
    public function profile()
    {
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->where('id', '=', $data->division_id)->get();
        $positions = DB::table('master_positions')->where('id', '=', $data->position_id)->get();
        $roles = DB::table('master_roles')->where('id', '=', $data->role_id)->get();
        $shifts = DB::table('master_shifts')->where('id', '=', $data->shift_id)->get();

        return view('dashboard.profile',[
            'id' =>$data->id,
            'name'=> $data->name,
            'email'=> $data->email,
            'profile_photo'=> $data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts
            ]);
    }
    public function editprofile()
    {
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();
        $shifts = DB::table('master_shifts')->select('name as shifts_name','id as shifts_id')->get();

        return view('dashboard.editprofile',[
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts
            ]);
    }
    public function updateprofile(Request $request, MasterUser $user)
    {
        // dd($request);
        $request->validate([
            'nip' => 'required|numeric',
            'name' => 'required',
            'dob' => 'required',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'password' => 'required'
        ]);
        MasterUser::where('id', $user->id)
            ->update([
                'nip' => $request->nip,
                'name' => $request->name,
                'dob' => $request->dob,
                'live_at' => $request->live_at,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
                'profile_photo' => $request->profile_photo,
            ]);
            Alert::success('Berhasil!', 'Info profil anda berhasil di rubah!');
        return redirect('/staff/profile');
    }
    
}
