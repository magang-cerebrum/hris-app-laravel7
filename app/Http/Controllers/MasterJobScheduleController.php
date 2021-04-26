<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterJobSchedule;
use App\MasterUser;
use App\MasterShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
class MasterJobScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index_month()
    {
        $user = Auth::user();
        if($user->role_id == 1){
            return view('masterData.schedule.list', [
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            return view('staff.schedule.list', [
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }

    public function index(Request $request)
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $data = DB::table('master_job_schedules')
        ->where('month', '=', $request->month)
        ->where('year', '=', $request->year)
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->select(
            'master_job_schedules.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
        )->get();

        $cal = CAL_GREGORIAN;
        $month = switch_month($request->month, false);
        $days_in_month = cal_days_in_month($cal, $month, $request->year);

        // dd($days_in_month);

        return view('masterData.schedule.result', [
            'data'=>$data,
            'count_day'=>$days_in_month
        ]);
    }

    public function staff_calendar()
    {
        $cal = CAL_GREGORIAN;
        $month = date('m');
        $year = date('Y');
        $days_in_month = cal_days_in_month($cal, $month, $year);

        $this_month = switch_month($month);
        $next_month = switch_month(intval($month) + 1);

        $user = Auth::user();
        $data_this_month = MasterJobSchedule::leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('user_id', '=', $user->id)
        ->where('month', '=', $this_month)
        ->where('year', '=', $year)
        ->select(
            'master_job_schedules.*',
            'master_users.name as user_name'
        )
        ->get();
        $data_next_month = MasterJobSchedule::leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('user_id', '=', $user->id)
        ->where('month', '=', $next_month)
        ->where('year', '=', $year)
        ->select(
            'master_job_schedules.*',
            'master_users.name as user_name'
        )
        ->get();
        $data_shift = DB::table('master_shifts')->get();
        return view('staff.schedule.calendar', [
            'data_this_month'=>$data_this_month,
            'data_next_month'=>$data_next_month,
            'data_shift'=>$data_shift,
            'day'=>$days_in_month,            
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function filter()
    {
        // if(Gate::denies('is_admin')){
        //     Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
        //     return back();
        // }
        $user = Auth::user();
        $data_division = DB::table('master_divisions')->select('name')->where('status','Aktif')->get();
        if ($user->role_id == 1) {
            $data = DB::table('master_users')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('master_users.status','=','Aktif')
            ->whereNotIn('master_users.division_id',[7])
            ->select(
                'master_users.id as user_id',
                'master_users.nip as user_nip',
                'master_users.name as user_name',
                'master_users.division_id',
                'master_users.position_id',
                'master_divisions.name as division_name',
                'master_positions.name as position_name'
                )
            ->get();
            return view('masterData.schedule.create', [
                'data'=>$data,
                'data_division'=>$data_division,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            $data = DB::table('master_users')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('master_users.status','=','Aktif')
            ->where('master_users.division_id',$user->division_id)
            ->whereNotIn('master_users.division_id',[7])
            ->select(
                'master_users.id as user_id',
                'master_users.nip as user_nip',
                'master_users.name as user_name',
                'master_users.division_id',
                'master_users.position_id',
                'master_divisions.name as division_name',
                'master_positions.name as position_name'
                )
            ->get();
            return view('staff.schedule.create', [
                'data'=>$data,
                'data_division'=>$data_division,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }

    public function filter_edit()
    {
        // if(Gate::denies('is_admin')){
        //     Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
        //     return back();
        // }
        $user = Auth::user();

        $current_month = date('m');
        $current_year = date('Y');
        $month = array();
        $year = array();

        array_push($month, switch_month($current_month));
        array_push($year, $current_year);

        if($current_month - 1 == 0) {
            $temp_month = 12;
            $temp_year = $current_year - 1;

            array_push($month, switch_month($temp_month));
            array_push($year, $temp_year);
        }
        else {
            $temp_month = $current_month - 1;

            array_push($month, switch_month($temp_month));
        }

        if($current_month + 1 == 13) {
            $temp_month = 1;
            $temp_year = $current_year + 1;

            array_push($month, switch_month($temp_month));
            array_push($year, $temp_year);
        }
        else {
            $temp_month = $current_month + 1;

            array_push($month, switch_month($temp_month));
        }
        
        if ($user->role_id == 1) {
            $data = DB::table('master_job_schedules')
            ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('master_users.status','=','Aktif')
            ->whereIn('master_job_schedules.month',$month)
            ->whereIn('master_job_schedules.year',$year)
            ->whereNotIn('master_users.division_id',[7])
            ->select(
                'master_job_schedules.id as id',
                'master_job_schedules.month as month',
                'master_job_schedules.year as year',
                'master_users.id as user_id',
                'master_users.nip as user_nip',
                'master_users.name as user_name',
                'master_users.division_id',
                'master_users.position_id',
                'master_divisions.name as division_name',
                'master_positions.name as position_name'
                )
            ->get();
            return view('masterData.schedule.editCreate', [
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            $data = DB::table('master_job_schedules')
            ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('master_users.status','=','Aktif')
            ->where('master_users.division_id',$user->division_id)
            ->whereIn('master_job_schedules.month',$month)
            ->whereIn('master_job_schedules.year',$year)
            ->whereNotIn('master_users.division_id',[7])
            ->select(
                'master_job_schedules.id as id',
                'master_job_schedules.month as month',
                'master_job_schedules.year as year',
                'master_users.id as user_id',
                'master_users.nip as user_nip',
                'master_users.name as user_name',
                'master_users.division_id',
                'master_users.position_id',
                'master_divisions.name as division_name',
                'master_positions.name as position_name'
                )
            ->get();
            return view('staff.schedule.editCreate', [
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }

    public function schedule_add(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('check');
        $data_user = array();
        $data_id = array();
        foreach($ids as $id) {
            $data = MasterUser::where("id",$id)->first();
            array_push($data_user, $data);
            array_push($data_id, $data->id);
        }
        $data_shift = MasterShift::all();
        $split = explode('/',$request->periode);
        $cal = CAL_GREGORIAN;
        $month = switch_month($split[0]);
        $days_in_month = cal_days_in_month($cal, $split[0], $split[1]);
        $data_holiday = DB::table('master_holidays')
        ->where('date', 'LIKE', $split[1].'-'.$split[0].'%')->get();

        $data_paid_leave = DB::table('accepted_paid_leaves')
        ->where('date', 'LIKE', $split[1].'-'.$split[0].'%')
        ->whereIn('user_id',$data_id)
        ->get();

        $data_wfh = DB::table('accepted_work_from_homes')
        ->where('date', 'LIKE', $split[1].'-'.$split[0].'%')
        ->whereIn('user_id',$data_id)
        ->get();

        if($user->role_id == 1){
            return view('masterData.schedule.add', [
                'data_user'=>$data_user,
                'data_holiday'=>$data_holiday,
                'data_paid_leave'=>$data_paid_leave,
                'data_wfh'=>$data_wfh,
                'count_day'=>$days_in_month,
                'number_of_month'=>$split[0],
                'month'=>$month,
                'year'=>$split[1],
                'data_shift'=>$data_shift,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            return view('staff.schedule.add', [
                'data_user'=>$data_user,
                'data_holiday'=>$data_holiday,
                'data_paid_leave'=>$data_paid_leave,
                'data_wfh'=>$data_wfh,
                'count_day'=>$days_in_month,
                'number_of_month'=>$split[0],
                'month'=>$month,
                'year'=>$split[1],
                'data_shift'=>$data_shift,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }

    public function schedule_edit(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('check');

        $data = DB::table('master_job_schedules')
        ->whereIn('master_job_schedules.id',$ids)
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->select(
            'master_job_schedules.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
        )
        ->get();

        $data_shift = MasterShift::all();

        if($user->role_id == 1){
            return view('masterData.schedule.edit', [
                'data'=>$data,
                'data_shift'=>$data_shift,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            return view('staff.schedule.edit', [
                'data'=>$data,
                'data_shift'=>$data_shift,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
    }

    public function schedule_post(Request $request)
    {
        function check($check_shift, $check_day, $request, $user_id) {
            global $total_hour;
            $id = $request->$check_shift;
            $datas = MasterShift::All();
            $shift_name = '';
            foreach ($datas as $data) {
                if($id == $data->id) {
                    $total_hour += $data->total_hour;
                    $shift_name = $data->name;
                }
            }

            $check_accept_wfh = DB::table('accepted_work_from_homes')
            ->where('date', '=', $request->year.'.'.switch_month($request->month, false).'-'.($check_day/10 < 1 ? '0'.$check_day : $check_day))
            ->where('user_id', '=', $user_id)
            ->get();

            if (count($check_accept_wfh) != 0 && $shift_name != 'WFH') {
                DB::statement('UPDATE work_from_homes SET `days` = `days` - 1 WHERE `id` = '.$check_accept_wfh->wfh_id);
                DB::table('accepted_work_from_homes')->where('id', '=', $check_accept_wfh->id)->delete();
            } 

            $check_accept_paid = DB::table('accepted_paid_leaves')
            ->where('date', '=', $request->year.'.'.switch_month($request->month, false).'-'.($check_day/10 < 1 ? '0'.$check_day : $check_day))
            ->where('user_id', '=', $user_id)
            ->get();

            if (count($check_accept_paid) != 0 && $shift_name != 'Cuti') {
                DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$check_accept_paid->paid_leave_id);
                DB::statement('UPDATE master_users SET `yearly_leave_remaining` = `yearly_leave_remaining` + 1 WHERE `id` = '.$user_id);
                DB::table('accepted_paid_leaves')->where('id', '=', $check_accept_paid->id)->delete();
            }   

            $check_transaction_paid = DB::table('transaction_paid_leaves')
            ->where('user_id', '=', $user_id)
            ->whereNotIn('status', ['Diterima', 'Cancel', 'Ditolak', 'Ditolak-Chief'])
            ->get();
            
            if (count($check_accept_paid) != 0 && $shift_name != 'Cuti') {
                foreach($check_transaction_paid as $item) {
                    $transaction_interval = date_diff(date_create($item->paid_leave_date_start),date_create($item->paid_leave_date_end));
                    $transaction_total_day = $transaction_interval->format('%a') + 1;

                    $transaction_date_start = date('Y-m-d', strtotime('-1 days', strtotime($item->paid_leave_date_start)));
                    for ($x = 0; $x <$transaction_total_day; $x++) {
                        $check_transaction_days = date('Y-m-d', strtotime('+1 days', strtotime($transaction_date_start)));
                        if ($check_transaction_days == $request->year.'-'.$request->month.'-'.$check_day) {
                            DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$item->id);
                        }
                        $transaction_date_start = $check_transaction_days;
                    }
                }
            }

            $check_transaction_wfh = DB::table('work_from_homes')
            ->where('user_id', '=', $user_id)
            ->whereNotIn('status', ['Diterima', 'Cancel', 'Ditolak', 'Ditolak-Chief'])
            ->get();
            
            if (count($check_accept_wfh) != 0 && $shift_name != 'WFH') {
                foreach($check_transaction_wfh as $item_wfh) {
                    $transaction_interval = date_diff(date_create($item_wfh->wfh_date_start),date_create($item_wfh->wfh_date_end));
                    $transaction_total_day = $transaction_interval->format('%a') + 1;

                    $transaction_date_start = date('Y-m-d', strtotime('-1 days', strtotime($item_wfh->wfh_date_start)));
                    for ($x = 0; $x <$transaction_total_day; $x++) {
                        $check_transaction_days = date('Y-m-d', strtotime('+1 days', strtotime($transaction_date_start)));
                        if ($check_transaction_days == $request->year.'-'.$request->month.'-'.$check_day) {
                            DB::statement('UPDATE work_from_homes SET `days` = `days` - 1 WHERE `id` = '.$item_wfh->id);
                        }
                        $transaction_date_start = $check_transaction_days;
                    }
                }
            }
            
            return $shift_name;
        }

        for ($i = 1; $i <= $request->count; $i++) {
            global $total_hour;
            $total_hour = 0;
            
            $user_id = 'id_user_'.$i;
            $shift_1 = check('shift_1_'.$i, $i, $request, $user_id);
            $shift_2 = check('shift_2_'.$i, $i, $request, $user_id);
            $shift_3 = check('shift_3_'.$i, $i, $request, $user_id);
            $shift_4 = check('shift_4_'.$i, $i, $request, $user_id);
            $shift_5 = check('shift_5_'.$i, $i, $request, $user_id);
            $shift_6 = check('shift_6_'.$i, $i, $request, $user_id);
            $shift_7 = check('shift_7_'.$i, $i, $request, $user_id);
            $shift_8 = check('shift_8_'.$i, $i, $request, $user_id);
            $shift_9 = check('shift_9_'.$i, $i, $request, $user_id);
            $shift_10 = check('shift_10_'.$i, $i, $request, $user_id);
            $shift_11 = check('shift_11_'.$i, $i, $request, $user_id);
            $shift_12 = check('shift_12_'.$i, $i, $request, $user_id);
            $shift_13 = check('shift_13_'.$i, $i, $request, $user_id);
            $shift_14 = check('shift_14_'.$i, $i, $request, $user_id);
            $shift_15 = check('shift_15_'.$i, $i, $request, $user_id);
            $shift_16 = check('shift_16_'.$i, $i, $request, $user_id);
            $shift_17 = check('shift_17_'.$i, $i, $request, $user_id);
            $shift_18 = check('shift_18_'.$i, $i, $request, $user_id);
            $shift_19 = check('shift_19_'.$i, $i, $request, $user_id);
            $shift_20 = check('shift_20_'.$i, $i, $request, $user_id);
            $shift_21 = check('shift_21_'.$i, $i, $request, $user_id);
            $shift_22 = check('shift_22_'.$i, $i, $request, $user_id);
            $shift_23 = check('shift_23_'.$i, $i, $request, $user_id);
            $shift_24 = check('shift_24_'.$i, $i, $request, $user_id);
            $shift_25 = check('shift_25_'.$i, $i, $request, $user_id);
            $shift_26 = check('shift_26_'.$i, $i, $request, $user_id);
            $shift_27 = check('shift_27_'.$i, $i, $request, $user_id);
            $shift_28 = check('shift_28_'.$i, $i, $request, $user_id);
            $shift_29 = check('shift_29_'.$i, $i, $request, $user_id);
            $shift_30 = check('shift_30_'.$i, $i, $request, $user_id);
            $shift_31 = check('shift_31_'.$i, $i, $request, $user_id);

            $data_check = DB::table('master_job_schedules')
            ->where('user_id', '=', $request->$user_id)
            ->where('month', '=', $request->month)
            ->where('year', '=', $request->year)
            ->get();

            if (count($data_check) == 0 ) {
                MasterJobSchedule::create([
                    'month'=>$request->month,
                    'year'=>$request->year,
                    'user_id'=>$request->$user_id,
                    'shift_1'=>$shift_1,
                    'shift_2'=>$shift_2,
                    'shift_3'=>$shift_3,
                    'shift_4'=>$shift_4,
                    'shift_5'=>$shift_5,
                    'shift_6'=>$shift_6,
                    'shift_7'=>$shift_7,
                    'shift_8'=>$shift_8,
                    'shift_9'=>$shift_9,
                    'shift_10'=>$shift_10,
                    'shift_11'=>$shift_11,
                    'shift_12'=>$shift_12,
                    'shift_13'=>$shift_13,
                    'shift_14'=>$shift_14,
                    'shift_15'=>$shift_15,
                    'shift_16'=>$shift_16,
                    'shift_17'=>$shift_17,
                    'shift_18'=>$shift_18,
                    'shift_19'=>$shift_19,
                    'shift_20'=>$shift_20,
                    'shift_21'=>$shift_21,
                    'shift_22'=>$shift_22,
                    'shift_23'=>$shift_23,
                    'shift_24'=>$shift_24,
                    'shift_25'=>$shift_25,
                    'shift_26'=>$shift_26,
                    'shift_27'=>$shift_27,
                    'shift_28'=>$shift_28,
                    'shift_29'=>$shift_29,
                    'shift_30'=>$shift_30,
                    'shift_31'=>$shift_31,
                    'total_hour'=>$total_hour
                ]);
            }
        }
        Alert::success('Berhasil!', 'Jadwal staff baru berhasil ditambahkan!');
        if (Auth::user()->role_id == 1) {
            return redirect('/admin/schedule');
        } else {
            return redirect('/staff/schedule/division');
        }
    }

    public function edit_post(Request $request)
    {
        function checkEdit($check_shift, $request) {
            global $total_hour;
            $id = $request->$check_shift;
            $shift_name = '';
            if ($id != null) {
                $datas = MasterShift::All();
                foreach ($datas as $data) {
                    if($id == $data->id) {
                        $total_hour += $data->total_hour;
                        $shift_name = $data->name;
                    }
                }
            }
            return $shift_name;
        }

        for ($i = 1; $i <= $request->count; $i++) {
            global $total_hour;
            $total_hour = 0;

            $check_id = 'id_'.$i;
            $shift_1 = checkEdit('shift_1_'.$i, $request);
            $shift_2 = checkEdit('shift_2_'.$i, $request);
            $shift_3 = checkEdit('shift_3_'.$i, $request);
            $shift_4 = checkEdit('shift_4_'.$i, $request);
            $shift_5 = checkEdit('shift_5_'.$i, $request);
            $shift_6 = checkEdit('shift_6_'.$i, $request);
            $shift_7 = checkEdit('shift_7_'.$i, $request);
            $shift_8 = checkEdit('shift_8_'.$i, $request);
            $shift_9 = checkEdit('shift_9_'.$i, $request);
            $shift_10 = checkEdit('shift_10_'.$i, $request);
            $shift_11 = checkEdit('shift_11_'.$i, $request);
            $shift_12 = checkEdit('shift_12_'.$i, $request);
            $shift_13 = checkEdit('shift_13_'.$i, $request);
            $shift_14 = checkEdit('shift_14_'.$i, $request);
            $shift_15 = checkEdit('shift_15_'.$i, $request);
            $shift_16 = checkEdit('shift_16_'.$i, $request);
            $shift_17 = checkEdit('shift_17_'.$i, $request);
            $shift_18 = checkEdit('shift_18_'.$i, $request);
            $shift_19 = checkEdit('shift_19_'.$i, $request);
            $shift_20 = checkEdit('shift_20_'.$i, $request);
            $shift_21 = checkEdit('shift_21_'.$i, $request);
            $shift_22 = checkEdit('shift_22_'.$i, $request);
            $shift_23 = checkEdit('shift_23_'.$i, $request);
            $shift_24 = checkEdit('shift_24_'.$i, $request);
            $shift_25 = checkEdit('shift_25_'.$i, $request);
            $shift_26 = checkEdit('shift_26_'.$i, $request);
            $shift_27 = checkEdit('shift_27_'.$i, $request);
            $shift_28 = checkEdit('shift_28_'.$i, $request);
            $shift_29 = checkEdit('shift_29_'.$i, $request);
            $shift_30 = checkEdit('shift_30_'.$i, $request);
            $shift_31 = checkEdit('shift_31_'.$i, $request);


            DB::table('master_job_schedules')
            ->where('id', $request->$check_id)
            ->update([
                'shift_1'=>$shift_1,
                    'shift_2'=>$shift_2,
                    'shift_3'=>$shift_3,
                    'shift_4'=>$shift_4,
                    'shift_5'=>$shift_5,
                    'shift_6'=>$shift_6,
                    'shift_7'=>$shift_7,
                    'shift_8'=>$shift_8,
                    'shift_9'=>$shift_9,
                    'shift_10'=>$shift_10,
                    'shift_11'=>$shift_11,
                    'shift_12'=>$shift_12,
                    'shift_13'=>$shift_13,
                    'shift_14'=>$shift_14,
                    'shift_15'=>$shift_15,
                    'shift_16'=>$shift_16,
                    'shift_17'=>$shift_17,
                    'shift_18'=>$shift_18,
                    'shift_19'=>$shift_19,
                    'shift_20'=>$shift_20,
                    'shift_21'=>$shift_21,
                    'shift_22'=>$shift_22,
                    'shift_23'=>$shift_23,
                    'shift_24'=>$shift_24,
                    'shift_25'=>$shift_25,
                    'shift_26'=>$shift_26,
                    'shift_27'=>$shift_27,
                    'shift_28'=>$shift_28,
                    'shift_29'=>$shift_29,
                    'shift_30'=>$shift_30,
                    'shift_31'=>$shift_31,
                    'total_hour'=>$total_hour
            ]);
        }
        Alert::success('Berhasil!', 'Jadwal staff berhasil dirubah!');
        if (Auth::user()->role_id == 1) {
            return redirect('/admin/schedule');
        } else {
            return redirect('/staff/schedule/division');
        }
    }

    public function result_calendar(Request $request)
    {
        $user = Auth::user();
        $split = explode('/', $request->periode);
        $data = MasterJobSchedule::leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('month', '=',switch_month($split[0]))
        ->where('year', '=', $split[1])
        ->select(
            'master_job_schedules.*',
            'master_users.name as user_name'
        )->get();
        $data_staff = MasterJobSchedule::leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('month', '=',switch_month($split[0]))
        ->where('year', '=', $split[1])
        ->where('master_users.division_id',$user->division_id)
        ->select(
            'master_job_schedules.*',
            'master_users.name as user_name'
        )->get();
        
        $cal = CAL_GREGORIAN;
        $month = switch_month($split[0]);
        $days_in_month = cal_days_in_month($cal, $split[0] , date('Y'));
        $data_shift = DB::table('master_shifts')->get();
        if ($user->role_id == 1) {
            return view('masterData.schedule.calendar', [
                'data'=>$data,
                'data_shift'=>$data_shift,
                'day'=>$days_in_month,
                'month'=>$split[0],
                'year'=>$split[1],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            return view('staff.schedule.result', [
                'data'=>$data_staff,
                'data_shift'=>$data_shift,
                'day'=>$days_in_month,
                'month'=>$split[0],
                'year'=>$split[1],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        
    }


    public function CopySchedule(Request $request){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $carbon = Carbon::now('UTC');
        $acm = switch_month( $carbon->addMonthsNoOverflow(1)->format('m'));
        $data = DB::table('master_job_schedules')
        ->where('month', '=', switch_month(date('m')))
        ->OrWhere('month','=',$acm)
        ->where('year', '=',date('Y'))
        ->whereNotIn('division_id',[7])
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->select(
            'master_job_schedules.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
        )->get();
        
        $user = Auth::user();
        return view('masterData.schedule.copy',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data,
        ]);
    }

    public function ajaxCal(Request $request){
        if(Route::current()->uri == "admin/schedule/copyschedule/calculate"){
            $carbon = Carbon::now('UTC'); // current datetime in UTC is 8:54 AM October 31, 2016
            $acm = switch_month( $carbon->addMonthsNoOverflow(1)->format('m'));
            $firstPeriode = $request->first_periode;
            $splitFirstPeriode = explode('/',$firstPeriode);
            $dataScheduleFirstPeriode = DB::table('master_job_schedules')
            ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
                ->where('month','=',switch_month($splitFirstPeriode[0]))
                ->where('year', '=',$splitFirstPeriode[1])
                ->where('master_users.status','Aktif')
                ->whereNotIn('division_id',[7])
                ->select(
                    'master_job_schedules.*',
                    'master_users.nip as user_nip',
                    'master_users.name as user_name'
                )->get();
                $id = array();
                foreach($dataScheduleFirstPeriode as $periodeItems){
                    array_push($id,$periodeItems->user_id);
                }
            $dataUser = DB::table('master_users')
            ->whereNotIn('id',$id)
            ->where('master_users.status','Aktif')
            ->whereNotIn('division_id',[7])
            ->select('name','id')->get();
            
            
        return response()->json([
            'dataUser'=>$dataUser,
        ]);
        }
        elseif(Route::current()->uri == "staff/schedule/copyschedule/calculate"){
            $user = Auth::user();
            $carbon = Carbon::now('UTC'); // current datetime in UTC is 8:54 AM October 31, 2016
            $acm = switch_month( $carbon->addMonthsNoOverflow(1)->format('m'));
            $firstPeriode = $request->first_periode;
            $splitFirstPeriode = explode('/',$firstPeriode);
            $dataScheduleFirstPeriode = DB::table('master_job_schedules')
            ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
                ->where('month','=',switch_month($splitFirstPeriode[0]))
                ->where('year', '=',$splitFirstPeriode[1])
                ->where('master_users.status','Aktif')
                ->whereNotIn('division_id',[7])
                ->select(
                    'master_job_schedules.*',
                    'master_users.nip as user_nip',
                    'master_users.name as user_name'
                )->get();
                $id = array();
                foreach($dataScheduleFirstPeriode as $periodeItems){
                    array_push($id,$periodeItems->user_id);
                }
            $dataUser = DB::table('master_users')
            ->whereNotIn('id',$id)
            ->where('master_users.division_id',$user->division_id)
            ->where('id','!=',Auth::user()->id)
            ->where('master_users.status','Aktif')
            ->whereNotIn('division_id',[7])
            // ->select('name','id')
            ->get();

            return response()->json([
                // 'uri'=>"Route::current()->uri",
                'dataUser'=>$dataUser,
                
            ]); 
        }
        
    }
    public function ajaxCheckBox(Request $request){
        $check = $request->checkBox_val;
        $chosens = $request->chosen;
        $chosenUser = DB::table('master_users')
        ->select('name')
        ->where('id',$chosens)
        ->get();
        $nameofUser = DB::table('master_users')
        ->whereIn('id',$check)
        ->select('name')
        ->get();
       return response()->json([
        'names'=>$nameofUser,
        'chosenUser'=>$chosenUser,
        'check'=>$chosenUser
       ]);
    }

    public function copied(Request $request){
        $date = explode('/',$request->first);
        $chosenCopy = $request->chosen;
        $chosenTargetToCopy = $request->chosen_checkbox;
        $dataScheduleCopy = DB::table('master_job_schedules')
        ->where('user_id',$chosenCopy)
        ->where('year',$date[1])
        ->where('month',switch_month($date[0]) )
        ->first();

        $arrayData = array();
        for($i = 1 ; $i<=31;$i++ ){
            $tempName = 'shift_'.$i;
            array_push($arrayData,$dataScheduleCopy->$tempName);
        }
        $totalHour = $dataScheduleCopy->total_hour;
        foreach($chosenTargetToCopy as $itemTargetCopy){
            MasterJobSchedule::create([
                'month'=>switch_month($date[0]),
                'year'=>$date[1],
                'user_id'=>$itemTargetCopy,
                'shift_1'=>$arrayData[0],
                'shift_2'=>$arrayData[1],
                'shift_3'=>$arrayData[2],
                'shift_4'=>$arrayData[3],
                'shift_5'=>$arrayData[4],
                'shift_6'=>$arrayData[5],
                'shift_7'=>$arrayData[6],
                'shift_8'=>$arrayData[7],
                'shift_9'=>$arrayData[8],
                'shift_10'=>$arrayData[9],
                'shift_11'=>$arrayData[10],
                'shift_12'=>$arrayData[11],
                'shift_13'=>$arrayData[12],
                'shift_14'=>$arrayData[13],
                'shift_15'=>$arrayData[14],
                'shift_16'=>$arrayData[15],
                'shift_17'=>$arrayData[16],
                'shift_18'=>$arrayData[17],
                'shift_19'=>$arrayData[18],
                'shift_20'=>$arrayData[19],
                'shift_21'=>$arrayData[20],
                'shift_22'=>$arrayData[21],
                'shift_23'=>$arrayData[22],
                'shift_24'=>$arrayData[23],
                'shift_25'=>$arrayData[24],
                'shift_26'=>$arrayData[25],
                'shift_27'=>$arrayData[26],
                'shift_28'=>$arrayData[27],
                'shift_29'=>$arrayData[28],
                'shift_30'=>$arrayData[29],
                'shift_31'=>$arrayData[30],
                'total_hour'=>$totalHour
            ]);
        }
        return redirect('/admin/schedule');
        // dd($arrayData);
    }


    public function ChiefCopySchedule(Request $request){
        $carbon = Carbon::now('UTC'); // current datetime in UTC is 8:54 AM October 31, 2016
        $acm = switch_month( $carbon->addMonthsNoOverflow(1)->format('m'));
        $user = Auth::user();
        $data = DB::table('master_job_schedules')
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('master_users.division_id',$user->division_id)
        ->whereNotIn('master_users.division_id',[7])
        ->where('month', '=', switch_month(date('m')))
        ->orWhere('month','=',$acm)
        ->where('year', '=',date('Y'))
        ->select(
            'master_job_schedules.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name',
            'master_users.division_id as division_id',
            'master_users.role_id as role_id'
        )
        ->get();
        // dd();
        
        
        return view('masterData.schedule.Chiefcopy',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data,
        ]);
    }

    public function Chiefcopied(Request $request){
        $date = explode('/',$request->first);
        $chosenCopy = $request->chosen;
        $chosenTargetToCopy = $request->chosen_checkbox;
        $dataScheduleCopy = DB::table('master_job_schedules')
        ->where('user_id',$chosenCopy)
        ->where('year',$date[1])
        ->where('month',switch_month($date[0]) )
        ->first();

        $arrayData = array();
        for($i = 1 ; $i<=31;$i++ ){
            $tempName = 'shift_'.$i;
            array_push($arrayData,$dataScheduleCopy->$tempName);
        }
        $totalHour = $dataScheduleCopy->total_hour;
        foreach($chosenTargetToCopy as $itemTargetCopy){
            MasterJobSchedule::create([
                'month'=>switch_month($date[0]),
                'year'=>$date[1],
                'user_id'=>$itemTargetCopy,
                'shift_1'=>$arrayData[0],
                'shift_2'=>$arrayData[1],
                'shift_3'=>$arrayData[2],
                'shift_4'=>$arrayData[3],
                'shift_5'=>$arrayData[4],
                'shift_6'=>$arrayData[5],
                'shift_7'=>$arrayData[6],
                'shift_8'=>$arrayData[7],
                'shift_9'=>$arrayData[8],
                'shift_10'=>$arrayData[9],
                'shift_11'=>$arrayData[10],
                'shift_12'=>$arrayData[11],
                'shift_13'=>$arrayData[12],
                'shift_14'=>$arrayData[13],
                'shift_15'=>$arrayData[14],
                'shift_16'=>$arrayData[15],
                'shift_17'=>$arrayData[16],
                'shift_18'=>$arrayData[17],
                'shift_19'=>$arrayData[18],
                'shift_20'=>$arrayData[19],
                'shift_21'=>$arrayData[20],
                'shift_22'=>$arrayData[21],
                'shift_23'=>$arrayData[22],
                'shift_24'=>$arrayData[23],
                'shift_25'=>$arrayData[24],
                'shift_26'=>$arrayData[25],
                'shift_27'=>$arrayData[26],
                'shift_28'=>$arrayData[27],
                'shift_29'=>$arrayData[28],
                'shift_30'=>$arrayData[29],
                'shift_31'=>$arrayData[30],
                'total_hour'=>$totalHour
            ]);
        }
        return redirect('/staff/schedule/division');
        // dd($arrayData);
    }
    
}
