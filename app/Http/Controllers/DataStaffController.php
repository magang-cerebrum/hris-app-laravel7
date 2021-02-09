<?php

namespace App\Http\Controllers;

use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $staff = DB::table('master_users')
        ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->leftJoin('master_roles','master_users.role_id','=','master_roles.id')
        ->leftJoin('master_shifts','master_users.shift_id','=','master_shifts.id')
        ->select(
                'master_users.*',
                'master_divisions.name as division_name',
                'master_positions.name as position_name',
                'master_roles.name as role_name',
                'master_shifts.name as shift_name',
                'master_shifts.start_working_time as start_working_time',
                'master_shifts.end_working_time as end_working_time'
                )
        ->paginate(5);
        // $staff = MasterUser::paginate(5);
        return view('masterdata.datastaff.list',[
            'staff' => $staff,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as division_name','id as division_id')->get();
        $positions = DB::table('master_positions')->select('name as position_name','id as position_id')->get();
        $roles = DB::table('master_roles')->select('name as role_name','id as role_id')->get();
        $shifts = DB::table('master_shifts')->select('name as shift_name','id as shift_id')->get();

        return view('masterdata.datastaff.create',[
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:master_users,nip',
            'name' => 'required',
            'dob' => 'required',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'password' => 'required',
            'employee_status' => 'required',
            'employee_type' => 'required',
            'status' => 'required',
            'contract_duration'=> 'numeric|nullable',
            'start_work_date' => 'required',
            'yearly_leave_remaining' => 'numeric',
            'division_id' => 'numeric',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'shift_id' => 'numeric'
        ]);
        MasterUser::create($request->all());
        return redirect('/admin/data-staff')->with('status','Data Staff Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function show(MasterUser $masterUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterUser $staff)
    {
        $user = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();
        $shifts = DB::table('master_shifts')->select('name as shifts_name','id as shifts_id')->get();

        return view('masterdata.datastaff.edit',[
            'staff' => $staff,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterUser $staff)
    {
        $request->validate([
            'nip' => 'required|numeric',
            'name' => 'required',
            'dob' => 'required',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'password' => 'required',
            'employee_status' => 'required',
            'employee_type' => 'required',
            'status' => 'required',
            'contract_duration'=> 'numeric|nullable',
            'start_work_date' => 'required',
            'yearly_leave_remaining' => 'numeric',
            'division_id' => 'numeric',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'shift_id' => 'numeric'
        ]);
        MasterUser::where('id', $staff->id)
            ->update([
                'nip' => $request->nip,
                'name' => $request->name,
                'dob' => $request->dob,
                'live_at' => $request->live_at,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => $request->password,
                'profile_photo' => $request->profile_photo,
                'employee_status' => $request->employee_status,
                'employee_type' => $request->employee_type,
                'status' => $request->status,
                'contract_duration'=> $request->contract_duration,
                'start_work_date' => $request->start_work_date,
                'end_work_date' => $request->end_work_date,
                'yearly_leave_remaining' => $request->yearly_leave_remaining,
                'division_id' => $request->division_id,
                'position_id' => $request->position_id,
                'role_id' => $request->role_id,
                'shift_id' => $request->shift_id
            ]);
        return redirect('/admin/data-staff')->with('status','Data Staff Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterUser  $masterUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterUser $staff)
    {
        MasterUser::destroy($staff->id);
        return redirect('/admin/data-staff')->with('status','Data Staff Berhasil Dihapus');
    }
    public function destroyAll(Request $request){
        foreach ($request->selectid as $item) {
            DB::table('master_users')->where('id','=',$item)->delete();
        }
        return redirect('/admin/data-staff')->with('status','Data User Terpilih Berhasil Dihapus');
    }
}
