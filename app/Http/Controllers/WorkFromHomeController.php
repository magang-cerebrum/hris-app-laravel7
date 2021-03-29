<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\WorkFromHome;
use App\MasterUser;
use App\AcceptedWorkFromHome;
use DateTime;

class WorkFromHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function history()
    {
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
            'data' => $data,
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
        return view('staff.workFromHome.create', [
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'left'=>$user->yearly_leave_remaining
        ]);
    }

    public function calculate(Request $request)
    {
        $interval = (new DateTime($request->yearly_start))->diff(new DateTime($request->yearly_end));
        $wfh_days = ($interval->format('%a')) + 1;
        if($request->yearly_start == '') $wfh_days = 0;
        
        return response()->json([
            'yearly_days'=>$wfh_days
        ]);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $data = DB::table('work_from_homes')
        ->where('user_id', '=', $user->id)
        ->paginate(5);
        
        return view('staff.workFromHome.history',[
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function reject(WorkFromHome $reject, Request $request){
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

    public function update_approve(Request $request)
    {
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

                    if($shift_day != 'Cuti' || $shift_day != 'Off') {
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

    public function update_pending(Request $request){
        $ids = $request->input('check');
        foreach($ids as $check_id) {
            WorkFromHome::where("id",$check_id)->update(['status' => 'Pending']);
        }
        Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil di pending!');
        return redirect('/admin/wfh');
    }

    public function division(){
        $user = Auth::user();

        $data = WorkFromHome::leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
        ->whereIn('master_users.division_id',division_members($user->position_id))
        ->whereIn('work_from_homes.status',['Diajukan','Pending-Chief'])
        ->select(
            'work_from_homes.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
        )
        ->paginate(5);
        return view('staff.workFromHome.listDivision',[
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function division_history(){
        $user = Auth::user();
        $data = DB::table('work_from_homes')
        ->whereIn('master_users.division_id',division_members($user->position_id))
        ->leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
        ->select(
            'work_from_homes.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
            )
        ->paginate(5);
        
        return view('staff.workFromHome.historyDivision',[
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function division_approve(Request $request){
        $ids = $request->input('check');
        foreach($ids as $check_id) {
            WorkFromHome::where("id",$check_id)->update(['status' => 'Diterima-Chief']);
        }
        Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil diterima!');
        return redirect('/staff/wfh/division');
    }

    public function division_pending(Request $request){
        $ids = $request->input('check');
        foreach($ids as $check_id) {
            WorkFromHome::where("id",$check_id)->update(['status' => 'Pending-Chief']);
        }
        Alert::success('Berhasil!', 'Pengajuan WFH terpilih berhasil di-pending!');
        return redirect('/staff/wfh/division');
    }

    public function division_reject(WorkFromHome $reject, Request $request){
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('check');
        foreach($ids as $deletes) {
            $data = WorkFromHome::where("id",$deletes)->first();
            $data->delete();
        }
        return redirect('/admin/wfh');
    }

    public function cancel_staff(WorkFromHome $id){
        WorkFromHome::where('id','=', $id->id)->update(['status' => 'Cancel']);
        Alert::info('Berhasil!', 'Pengajuan WFH telah di cancel!');
        return redirect('/staff/wfh/history');
    }
}
