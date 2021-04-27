<?php

namespace App\Http\Controllers;
use App\MasterUser;
use App\MasterRecruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAuthDashboardController extends Controller
{
    public function index(){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        else if(Gate::allows('is_admin')){
            $user = Auth::user();
            $data_paid = DB::table('transaction_paid_leaves')
            ->where('transaction_paid_leaves.status', '=', 'Diajukan')
            ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
            ->select(
                'transaction_paid_leaves.*',
                'master_users.name as user_name',
                'master_users.nip as user_nip'
                )
            ->paginate(5);
            $user_act = DB::table('master_users')
                ->where('status', '=', 'aktif')
                ->get();
            $user_nact = DB::table('master_users')
                ->where('status', '!=', 'aktif')
                ->get();
            $data_ticket = DB::table('transaction_ticketings')
                ->select('status')
                ->where('status','=','Dikirimkan')
                ->orWhere('status','=','On Progress')
                ->get();
            $data_poster = DB::table('sliders')->get();
            $data_rect = MasterRecruitment::paginate(5);

            $data_absensi = DB::table('master_check_presences')
            ->leftJoin('master_users','master_check_presences.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->select([
                'master_check_presences.shift as shift',
                'master_users.name as name',
                'master_divisions.name as division'
            ])->where('working_time','<',date('H:i:s'))->get();

            return view('dashboard.admin',[
                'data_absensi'=>$data_absensi,
                'data_poster'=>$data_poster,
                'data_recruitment'=>$data_rect,
                'data_paid_leave'=>$data_paid,
                'data_user_active'=>$user_act,
                'data_user_non_active'=>$user_nact,
                'data_ticket'=> $data_ticket,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }
    public function profile()
    {
        if(Gate::denies('is_admin')){
            return redirect('/staff/profile');
        }
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->where('id', $data->division_id)->get();
        $positions = DB::table('master_positions')->where('id', $data->position_id)->get();
        $roles = DB::table('master_roles')->where('id', $data->role_id)->get();
        
        return view('dashboard.profile',[
            'name'=>$data->name,
            'email'=>$data->email,
            'id'=>$data->id,
            'profile_photo'=>$data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles
        ]);
    }
    public function editprofile()
    {
        if(Gate::denies('is_admin')){
            return redirect('/staff/profile/edit');
        }
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();
        
        return view('dashboard.editprofile',[
            'name'=>$data->name,
            'email'=>$data->email,
            'id'=>$data->id,
            'profile_photo'=>$data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles
        ]);
    }
    public function updateprofile(Request $request, MasterUser $user)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required',
            'dob' => 'required',
            'address' => 'required|max:200',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'employee_status' => 'required',
            'employee_type' => 'required',
            'status' => 'required',
            'contract_duration'=> 'numeric|nullable',
            'start_work_date' => 'required',
            'yearly_leave_remaining' => 'numeric',
            'division_id' => 'numeric',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'credit_card_number' => 'numeric',
            'salary' => 'required'
        ]);
        $salary = preg_replace('/[Rp. ]/','',$request->salary);
        MasterUser::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'nip' => $request->nip,
                'dob' => $request->dob,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
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
                'credit_card_number' => $request->credit_card_number,
                'salary' => $salary
            ]);
            Alert::success('Berhasil!', 'Info profil anda berhasil di rubah!');
        return redirect('/admin/profile');
    }
}
