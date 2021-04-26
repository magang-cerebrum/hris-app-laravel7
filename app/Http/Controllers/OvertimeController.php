<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterOvertime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class OvertimeController extends Controller
{
    public function index()
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $overtime = MasterOvertime::paginate(10);
        return view('masterdata.overtime.searchOvertime', [
            'overtime' => $overtime,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function ajaxList(Request $request)
    {
        $data = MasterOvertime::leftJoin('master_users','master_overtimes.user_id','=','master_users.id')
        ->where('month',switch_month(explode('-',$request->periode)[1]))
        ->where('year',explode('-',$request->periode)[0])
        ->select([
            'master_overtimes.*',
            'master_users.name as user_name'
        ])
        ->get();
        return view('masterdata.overtime.list', [
            'data' => $data,
            'month' => explode('-',$request->periode)[1],
            'year' => explode('-',$request->periode)[0]
        ]);
    }

    public function create(Request $request)
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $user_overtime = array();
        $user_schedule = array();
        $data_user = DB::table('master_users')->select(['id'])->get();
        $data_overtime = MasterOvertime::where('month',switch_month($request->month))
        ->where('year',$request->year)
        ->select(['user_id'])
        ->get();
        $data_schedule = DB::table('master_job_schedules')
        ->where('month',switch_month($request->month))
        ->where('year',$request->year)
        ->select(['user_id'])
        ->get();
        $data_division = DB::table('master_divisions')
        ->whereNotIn('id',[7])
        ->select(['name'])
        ->get();
        foreach ($data_overtime as $item) {
            foreach ($data_user as $ids) {
                if($item->user_id == $ids->id){
                    $user_overtime[] = $item->user_id;
                }
            }
        }
        foreach ($data_schedule as $item) {
            foreach ($data_user as $ids) {
                if($item->user_id == $ids->id){
                    $user_schedule[] = $item->user_id;
                }
            }
        }
        $data =  DB::table('master_users')
        ->leftJoin('master_job_schedules','master_users.id','=','master_job_schedules.user_id')
        ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->where('master_users.status','Aktif')
        ->whereNotIn('master_users.division_id',[7])
        ->whereNotIn('master_users.id',$user_overtime)
        ->whereIn('master_users.id',$user_schedule)
        ->select([
            'master_users.id as user_id',
            'master_users.nip as user_nip',
            'master_users.name as user_name',
            'master_users.salary as user_salary',
            'master_job_schedules.total_hour as user_hour',
            'master_divisions.name as division_name'
        ])
        ->get();
        return view('masterdata.overtime.create', [
            'data' => $data,
            'data_division' => $data_division,
            'month' => $request->month,
            'year' => $request->year,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request)
    {
        MasterOvertime::create([
            'month' => switch_month(explode('/',$request->periode)[0]),
            'year' => explode('/',$request->periode)[1],
            'user_id' => $request->user_id,
            'hour' => $request->hour,
            'payment' => $request->payment,
            'status' => 'Pending'
        ]);
        Alert::success('Berhasil!', 'Data lembur baru telah ditambahkan!');
        return redirect('/admin/overtime');
    }

}
