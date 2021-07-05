<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
use App\WorkFromHome;
use App\MasterUser;
use App\AcceptedWorkFromHome;
use DateTime;

class WorkFromHomeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $data = WorkFromHome::whereIn('work_from_homes.status', ['Diterima-Chief','Pending'])
            ->leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
            ->select(
                'work_from_homes.*',
                'master_users.name as user_name',
                'master_users.nip as user_nip'
                )
            ->paginate(5);
            $user = Auth::user();
            
            return view('masterData.workFromHome.list', [
                'menu'=>['m-data','s-data-wfh'],
                'data' => $data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function history()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $data = DB::table('work_from_homes')
            ->whereNotIn('work_from_homes.status',['Diajukan', 'Pending-Chief','Diterima-Chief'])
            ->leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
            ->select(
                'work_from_homes.*',
                'master_users.name as user_name',
                'master_users.nip as user_nip'
                )
            ->paginate(5);
            $user = Auth::user();
    
            return view('masterData.workFromHome.history', [
                'menu'=>['m-data','s-data-wfh'],
                'data' => $data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function create()
    {
        if(Auth::check()){
            $user = Auth::user();
            return view('staff.workFromHome.create', [
                'menu'=>['m-wfh','s-wfh-pengajuan'],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'left'=>$user->yearly_leave_remaining
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function calculate(Request $request)
    {
        if(Auth::check()){
            $interval = (new DateTime($request->yearly_start))->diff(new DateTime($request->yearly_end));
            $wfh_days = ($interval->format('%a')) + 1;
            if($request->yearly_start == '') $wfh_days = 0;
            
            return response()->json([
                'yearly_days'=>$wfh_days
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'user_id'=>'required',
                'wfh_date_start'=>'required',
                'wfh_date_end'=>'required',
                'needs'=>'required'
            ]);
    
            $info = "-";
            
            $user = Auth::user();
    
            if ( $user->position_id != 11 ){
                $status = "Diterima-Chief";
            }
            else {
                $status = "Diajukan";
            }
    
            $date_start = date('Y/m/d',strtotime($request->wfh_date_start));
            $date_end = date('Y/m/d',strtotime($request->wfh_date_end));
            $needs = $request->needs;
            $interval = (new DateTime($request->wfh_date_start))->diff(new DateTime($request->wfh_date_end));
            $wfh = ($interval->format('%a')) + 1;
            
            $start = date('Y/m/d', strtotime('-1 days', strtotime($date_start)));
            $days_wfh = 0;
            for ($i = 0; $i < $wfh; $i++) {
                $check_days = date('Y/m/d', strtotime('+1 days', strtotime($start)));
                $check_name_days = date('l', strtotime($check_days));
    
                $table_schedule = DB::table('master_job_schedules')
                ->where('user_id', '=', $request->user_id)
                ->where('month', '=', switch_month(date('m', strtotime($check_days))))
                ->where('year', '=', date('Y', strtotime($check_days)))->get();
    
                if (count($table_schedule) == 0) {
                    if ($user->division_id == 5) {
                        $check_paid_leave = DB::table('accepted_paid_leaves')
                        ->where('date','=',$check_days)->get();
    
                        if ((count($check_paid_leave) == 0)) {
                            $days_wfh++;
                        }
                    }
                    else {
                        $check_holiday = DB::table('master_holidays')
                        ->where('date','=',$check_days)->get();
    
                        $check_paid_leave = DB::table('accepted_paid_leaves')
                        ->where('date','=',$check_days)->get();
    
                        if ($check_name_days != "Saturday" && $check_name_days != "Sunday" && (count($check_holiday) == 0) && (count($check_paid_leave) == 0)) {
                            $days_wfh++;
                        }
                    }
                }
                else {
                    $name_for_get_shift = 'shift_' .date('j', strtotime($check_days));
                    $shift = $table_schedule[0]->$name_for_get_shift;
                    if ($shift != 'Cuti' || $shift != 'Off') {
                        $days_wfh++;
                    }
                }
    
                $start = $check_days;
            }
    
            WorkFromHome::create([
                'user_id'=>$request->user_id,
                'wfh_date_start'=>$date_start,
                'wfh_date_end'=>$date_end,
                'days'=>$days_wfh,
                'status'=>$status,
                'needs'=>$needs,
                'informations'=>$info
    
            ]);
            Alert::success('Berhasil!', 'Pengajuan wfh berhasil terkirim!');
            return redirect('/staff/wfh/history');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function show()
    {
        if(Auth::check()){
            $user = Auth::user();
            $data = DB::table('work_from_homes')
            ->where('user_id', '=', $user->id)
            ->paginate(5);
            
            return view('staff.workFromHome.history',[
                'menu'=>['m-wfh','s-wfh-riwayat'],
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function reject(WorkFromHome $reject, Request $request){
        if(Auth::check()){
            $request->validate(['informations' => 'required']);
            WorkFromHome::where('id', $reject->id)
                ->update(['informations' => $request->informations,'status' => 'Ditolak']);
            $name = WorkFromHome::where('work_from_homes.id',$reject->id)
            ->join('master_users','work_from_homes.user_id','=','master_users.id')
            ->select('master_users.name as user_name')->get();
            foreach ($name as $item) {
                Alert::success('Berhasil!', 'Pengajuan WFH atas nama '. $item->user_name . ' ditolak!');
            }
            return redirect('/admin/wfh');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update_approve(Request $request)
    {
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $check_id) {
                $data = WorkFromHome::where("id",$check_id)->first();
                $data_user = MasterUser::where("id",$data->user_id)->first();
                $data->update(['status' => 'Diterima']);
    
                $interval = (new DateTime($data->wfh_date_start))->diff(new DateTime($data->wfh_date_end));
                $wfh = ($interval->format('%a')) + 1;
    
                $start = date('Y-m-d', strtotime('-1 days', strtotime($data->wfh_date_start)));
                for ($i = 0; $i < $wfh; $i++) {
                    $check_days = date('Y-m-d', strtotime('+1 days', strtotime($start)));
                    $check_name_days = date('l', strtotime($check_days));
                    $check_month = switch_month(date('m', strtotime($check_days)));
                    $check_year = date('Y', strtotime($check_days));
    
                    $check_holiday = DB::table('master_holidays')
                    ->where('date','=',$check_days)->get();
    
                    $check_paid_leave = DB::table('accepted_paid_leaves')
                    ->where('date','=',$check_days)->get();
    
                    $data_schedule = DB::table('master_job_schedules')
                    ->where('user_id', '=', $data->user_id)
                    ->where('month','=',$check_month)
                    ->where('year','=',$check_year)
                    ->get();
    
                    if (count($data_schedule) == 0) {
                        if ($data_user->division_id == 5) {
                            $temp_accept_wfh = DB::table('accepted_work_from_homes')
                            ->where('date', '=', $check_days)
                            ->where('user_id', '=', $data->user_id)
                            ->get();
                            if(count($temp_accept_wfh) == 0 ) {
                                AcceptedWorkFromHome::create([
                                    'wfh_id'=>$data->id,
                                    'user_id'=>$data->user_id,
                                    'date'=>$check_days
                                ]);
                            }
                        }
                        else {
                            if ($check_name_days != "Saturday" && $check_name_days != "Sunday" && (count($check_holiday) == 0) && (count($check_paid_leave) == 0)) {
                                $temp_accept_wfh = DB::table('accepted_work_from_homes')
                                ->where('date', '=', $check_days)
                                ->where('user_id', '=', $data->user_id)
                                ->get();
                                if(count($temp_accept_wfh) == 0 ) {
                                    AcceptedWorkFromHome::create([
                                        'wfh_id'=>$data->id,
                                        'user_id'=>$data->user_id,
                                        'date'=>$check_days
                                    ]);
                                }
                            }
                        }
                    }
                    else {
                        $day = date('j', strtotime($check_days));
                        $temp = 'shift_'.$day;
                        $shift_day = $data_schedule[0]->$temp;
    
                        if($shift_day != 'Cuti' && $shift_day != 'Off' && $shift_day != 'WFH') {
                            $total_hour = $data_schedule[0]->total_hour - check_hour_shift($shift_day) + check_hour_shift('WFH');
                            DB::table('master_job_schedules')
                            ->where('id', '=', $data_schedule[0]->id)
                            ->update([$temp => 'WFH', 'total_hour' => $total_hour]);
    
                            $temp_accept_wfh = DB::table('accepted_work_from_homes')
                            ->where('date', '=', $check_days)
                            ->where('user_id', '=', $data->user_id)
                            ->get();
                            if(count($temp_accept_wfh) == 0 ) {
                                AcceptedWorkFromHome::create([
                                    'wfh_id'=>$data->id,
                                    'user_id'=>$data->user_id,
                                    'date'=>$check_days
                                ]);
                            }
                        }
                    }
    
                    $start = $check_days;
                }
            }
            Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil di setujui!');
            return redirect('/admin/wfh');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update_pending(Request $request){
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $check_id) {
                WorkFromHome::where("id",$check_id)->update(['status' => 'Pending']);
            }
            Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil di pending!');
            return redirect('/admin/wfh');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function division(){
        if(Auth::check()){
            $user = Auth::user();

            $data = WorkFromHome::leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
            ->where('master_users.division_id',$user->division_id)
            ->whereIn('work_from_homes.status',['Diajukan','Pending-Chief'])
            ->select(
                'work_from_homes.*',
                'master_users.nip as user_nip',
                'master_users.name as user_name'
            )
            ->paginate(5);
            return view('staff.workFromHome.listDivision',[
                'menu'=>['m-d-wfh',''],
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function division_history(){
        if(Auth::check()){
            $user = Auth::user();
            $data = DB::table('work_from_homes')
            ->where('master_users.division_id',$user->division_id)
            ->leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
            ->select(
                'work_from_homes.*',
                'master_users.nip as user_nip',
                'master_users.name as user_name'
                )
            ->paginate(5);
            
            return view('staff.workFromHome.historyDivision',[
                'menu'=>['m-d-wfh',''],
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function division_approve(Request $request){
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $check_id) {
                WorkFromHome::where("id",$check_id)->update(['status' => 'Diterima-Chief']);
            }
            Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil diterima!');
            return redirect('/staff/wfh/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function division_pending(Request $request){
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $check_id) {
                WorkFromHome::where("id",$check_id)->update(['status' => 'Pending-Chief']);
            }
            Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil di-pending!');
            return redirect('/staff/wfh/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function division_reject(WorkFromHome $reject, Request $request){
        if(Auth::check()){
            $request->validate(['informations' => 'required']);
            WorkFromHome::where('id', $reject->id)
                ->update(['informations' => $request->informations,'status' => 'Ditolak-Chief']);
            $name = WorkFromHome::where('work_from_homes.id',$reject->id)
            ->join('master_users','work_from_homes.user_id','=','master_users.id')
            ->select('master_users.name as user_name')->get();
            foreach ($name as $item) {
                Alert::success('Berhasil!', 'Pengajuan WFH atas nama '. $item->user_name . ' ditolak!');
            }
            return redirect('/staff/wfh/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroy(Request $request)
    {
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $deletes) {
                $data = WorkFromHome::where("id",$deletes)->first();
                $data->delete();
            }
            return redirect('/admin/wfh');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function cancel_staff(WorkFromHome $id){
        if(Auth::check()){
            WorkFromHome::where('id','=', $id->id)->update(['status' => 'Cancel']);
            Alert::info('Berhasil!', 'Pengajuan WFH telah di cancel!');
            return redirect('/staff/wfh/history');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
