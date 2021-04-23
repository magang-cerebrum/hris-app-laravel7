<?php

namespace App\Http\Controllers;

use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class DataStaffController extends Controller
{
    public function index()
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $aktif = MasterUser::leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->leftJoin('master_roles','master_users.role_id','=','master_roles.id')
        ->select(
            'master_users.*',
            'master_divisions.name as division_name',
            'master_positions.name as position_name',
            'master_roles.name as role_name'
        )
        ->where('master_users.status','=','Aktif')
        ->paginate(10);
        
        $naktif = MasterUser::leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->leftJoin('master_roles','master_users.role_id','=','master_roles.id')
        ->select(
            'master_users.*',
            'master_divisions.name as division_name',
            'master_positions.name as position_name',
            'master_roles.name as role_name'
        )
        ->where('master_users.status','=','Non-Aktif')
        ->paginate(10);
        $count_aktif = MasterUser::where('status','=','Aktif')->count();
        $count_naktif = MasterUser::where('status','=','Non-Aktif')->count();
        return view('masterdata.datastaff.list',[
            'aktif' => $aktif,
            'naktif' => $naktif,
            'count_aktif' => $count_aktif,
            'count_naktif' => $count_naktif,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create()
    {   
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as division_name','id as division_id')->where('status','Aktif')->get();
        $positions = DB::table('master_positions')->select('name as position_name','id as position_id')->where('status','Aktif')->get();
        $roles = DB::table('master_roles')->select('name as role_name','id as role_id')->get();

        return view('masterdata.datastaff.create',[
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

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
            'contract_duration'=> 'required_if:employee_status,Kontrak,Probation',
            'yearly_leave_remaining' => 'numeric',
            'division_id' => 'numeric',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'credit_card_bank' => 'required',
            'credit_card_number' => 'required|numeric',
            'salary' => 'required'
        ]);

        $salary = preg_replace('/[Rp. ]/','',$request->salary);
        
        if ($request->employee_status == 'Tetap') {
            $duration = null;
            $end_work_date = null;
        } else {
            if ($request->contract_duration != '') {
                $duration = $request->contract_duration;
                $end_work_date = date_add(date_create(date('Y/m/d')),date_interval_create_from_date_string($duration . ' months'));
            }
        }

        MasterUser::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'dob' => $request->dob,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => $request->password,
            'profile_photo' => $request->photo_profile,
            'employee_status' => $request->employee_status,
            'employee_type' => $request->employee_type,
            'status' => $request->status,
            'contract_duration'=> $duration,
            'start_work_date' => date('Y/m/d'),
            'end_work_date' => $end_work_date,
            'yearly_leave_remaining' => $request->yearly_leave_remaining,
            'salary' => $salary,
            'credit_card_bank' => $request->credit_card_bank,
            'credit_card_number' => $request->credit_card_number,
            'division_id' => $request->division_id,
            'position_id' => $request->position_id,
            'role_id' => $request->role_id,
        ]);
        Alert::success('Berhasil!', 'Staff baru telah ditambahkan!');
        return redirect('/admin/data-staff');
    }

    public function edit(MasterUser $staff)
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->where('status','Aktif')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->where('status','Aktif')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();
        
        return view('masterdata.datastaff.edit',[
            'staff' => $staff,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function update(Request $request, MasterUser $staff)
    {
        $request->validate([
            'nip' => 'required|numeric',
            'name' => 'required',
            'dob' => 'required',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'employee_status' => 'required',
            'employee_type' => 'required',
            'status' => 'required',
            'contract_duration'=> 'required_if:employee_status,Kontrak,Probation',
            'yearly_leave_remaining' => 'numeric',
            'division_id' => 'numeric',
            'position_id' => 'numeric',
            'role_id' => 'numeric',
            'credit_card_bank' => 'required',
            'credit_card_number' => 'required|numeric',
            'salary' => 'required'
        ]);
        $salary = preg_replace('/[Rp. ]/','',$request->salary);
        
        if ($request->employee_status == 'Tetap') {
            $duration = null;
            $end_work_date = null;
        } else {
            if ($request->contract_duration != '') {
                $duration = $request->contract_duration;
                $end_work_date = date_add(date_create(date('Y/m/d')),date_interval_create_from_date_string($duration . ' months'));
            }
        }
        
        MasterUser::where('id', $staff->id)
            ->update([
                'nip' => $request->nip,
                'name' => $request->name,
                'dob' => $request->dob,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
                'employee_status' => $request->employee_status,
                'employee_type' => $request->employee_type,
                'status' => $request->status,
                'contract_duration'=> $duration,
                'end_work_date' => $end_work_date,
                'yearly_leave_remaining' => $request->yearly_leave_remaining,
                'salary' => $salary,
                'credit_card_bank' => $request->credit_card_bank,
                'credit_card_number' => $request->credit_card_number,
                'division_id' => $request->division_id,
                'position_id' => $request->position_id,
                'role_id' => $request->role_id,
            ]);
        Alert::success('Berhasil!', 'Staff dengan nama '. $request->name . ' berhasil diperbaharui!');
        return redirect('/admin/data-staff');
    }

    public function destroySelected(Request $request){
        if ($request->selectid[0] != '') {
            foreach ($request->selectid as $item) {
                MasterUser::where('id','=',$item)->delete();
            }            
        } else {
            foreach ($request->selectid_active as $item) {
                MasterUser::where('id','=',$item)->delete();
            }
        }
        Alert::success('Berhasil!', 'Staff yang dipilih berhasil dihapus!');
        return redirect('/admin/data-staff');
    }

    public function reset_pass(Request $request){
        MasterUser::where('id', $request->id)->update(['password' => Hash::make('cerebrum')]);
        return response()->json(['name'=> $request->name]);
    }

    public function search(Request $request){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        if ($request->get('query') == null) {return redirect('/admin/data-staff');}
        $user = Auth::user();
        $aktif = MasterUser::leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->leftJoin('master_roles','master_users.role_id','=','master_roles.id')
        ->select(
            'master_users.*',
            'master_divisions.name as division_name',
            'master_positions.name as position_name',
            'master_roles.name as role_name'
        )
        ->where('master_users.status','=','Aktif')
        ->where(function ($query) use ($request){
            $query->whereRaw("master_users.nip LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("master_users.name LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("master_divisions.name LIKE '%" . $request->get('query') . "%'");
        })
        ->paginate(10);
        $naktif = MasterUser::leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->leftJoin('master_roles','master_users.role_id','=','master_roles.id')
        ->select(
            'master_users.*',
            'master_divisions.name as division_name',
            'master_positions.name as position_name',
            'master_roles.name as role_name'
        )
        ->where('master_users.status','=','Non-Aktif')
        ->where(function ($query) use ($request){
            $query->whereRaw("master_users.nip LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("master_users.name LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("master_divisions.name LIKE '%" . $request->get('query') . "%'");
        })
        ->paginate(10);
        return view('masterdata.datastaff.result',[
            'aktif' => $aktif,
            'naktif' => $naktif,
            'search' => $request->get('query'),
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
        
    }

    public function toogle_status(Request $request){
        if ($request->status == 'Aktif') {$change = 'Non-Aktif';}
        else {$change = 'Aktif';}
        MasterUser::where('id', $request->id)->update(['status' => $change]);
        return response()->json(['name'=> $request->name, 'status' => $change]);
    }

    public function promotion(MasterUser $staff){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        if ($staff->employee_status == 'Tetap') {
            //ambil bulan setaun dari mulai tanggal kerja
            $months = array();
            $periode = array();
            $month_of_work = explode('-',$staff->start_work_date)[1];
            for ($i=0; $i < 12; $i++) { 
                $months[$i] = switch_month($month_of_work);
                if ($month_of_work == 12) {
                    $month_of_work = 1;
                } else {
                    $month_of_work++;
                }
            }
            //ambil data performanya
            $data_performance = array();
            $year = date('Y') - 1;
            for ($i=0; $i < 12; $i++) { 
                $get_data_score = DB::table('master_performances')
                ->where('month',$months[$i])
                ->where('year',$year)
                ->where('user_id',$staff->id)
                ->select('performance_score')
                ->get();

                if ($get_data_score->isEmpty()) {
                    $data_performance[$i] = null;
                } else {
                    $data_performance[$i] = $get_data_score[0]->performance_score;
                }
                $periode[$i] = $months[$i] . ' - ' . $year;
                if ($months[$i] == 'Desember') {
                    $year++;
                }
            }
            $total_score = array_sum($data_performance);
            $average_score = round($total_score / count($data_performance),1);
        } else {
            $periode = null;
            $data_performance = null;
            $total_score = null;
            $average_score = null;
        }
        return view('masterdata.datastaff.promote',[
            'staff' => $staff,
            'periode' => $periode,
            'performance' => $data_performance,
            'total' => $total_score,
            'average' => $average_score,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function promotion_calculate(Request $request){
        if($request->type == 'Persentase'){
            $salary_after = $request->salary_before + (($request->salary_before * $request->percentage) / 100);
        } elseif($request->type == 'Penambahan'){
            $salary_after = $request->salary_before + $request->direct_add;
        }
        $info = 'Perhitungan gaji setelah promosi didapat dari gaji sebelumnya (<b>' . rupiah($request->salary_before) . '</b>) ditambah dengan <b>' . $request->type . '</b> sebesar (<b>' . ($request->type == 'Persentase' ? $request->percentage . '%' : rupiah($request->direct_add)) . '</b>)';
        
        return response()->json([
            'info' => $info,
            'type' => $request->type,
            'salary_after' => rupiah($salary_after),
            'percentage' => $request->percentage,
            'direct_add' => rupiah($request->direct_add)
        ]);
    }

    public function promotion_approved(Request $request){
        $request->validate([
            'nip' => 'required',
            'new_employee_status' => 'required',
            'percentage' => 'required_if:salary_raise_type,Persentase',
            'direct_add' => 'required_if:salary_raise_type,Penambahan',
            'salary_after' => 'required'
        ]);

        if ($request->status_befpre == 'Tetap') {
            $salary_after = preg_replace('/[Rp. ]/','',$request->salary_after);
            MasterUser::where('nip',$request->nip)->update([
                'salary' => $salary_after
            ]);
            Alert::success('Berhasil!', 'Kenaikan gaji staff "' . $request->name . '" berhasil!');
        } else {
            $salary_after = preg_replace('/[Rp. ]/','',$request->salary_after);
            $end_work_date = date_add(date_create(date('Y/m/d')),date_interval_create_from_date_string('12 months'));
            
            MasterUser::where('nip',$request->nip)->update([
                'employee_status' => $request->new_employee_status,
                'contract_duration' => ($request->new_employee_status == 'Kontrak' ? 12 : null),
                'end_work_date' => ($request->new_employee_status == 'Kontrak' ? $end_work_date : null),
                'salary' => $salary_after
            ]);
            Alert::success('Berhasil!', 'Staff ' . $request->name . ' berhasil dipromosikan!');
        }
        return redirect('/admin/data-staff');
    }
}
