<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterJobSchedule;
use App\MasterUser;
use App\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('staff.schedule.calendar', [
            'data_this_month'=>$data_this_month,
            'data_next_month'=>$data_next_month,
            'day'=>$days_in_month,            
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function filter()
    {
        $user = Auth::user();
        $division = division_members($user->position_id);
        $data = DB::table('master_users')
        ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->where('master_users.status','=','Aktif')
        ->whereIn('master_users.division_id',$division)
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
        if ($user->role_id == 1) {
            return view('masterData.schedule.create', [
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        } else {
            return view('staff.schedule.create', [
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
        ->where('date', 'LIKE', $split[1].'-'.$month.'%')->get();

        $data_paid_leave = DB::table('accepted_paid_leaves')
        ->where('date', 'LIKE', $split[1].'-'.$month.'%')
        ->whereIn('user_id',$data_id)
        ->get();
        if($user->role_id == 1){
            return view('masterData.schedule.add', [
                'data_user'=>$data_user,
                'data_holiday'=>$data_holiday,
                'data_paid_leave'=>$data_paid_leave,
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

    public function schedule_post(Request $request)
    {
        function check($check_shift, $check_day, $request, $id) {
            global $total_hour;
            $id = $request->$check_shift;
            $datas = MasterShift::All();
            foreach ($datas as $data) {
                if($id == $data->id) {
                    $total_hour += $data->total_hour;
                    $shift_name = $data->name;
                }
            }
            // dd($request);

            $check_accept_paid = DB::table('accepted_paid_leaves')
            ->where('date', '=', $request->year.'.'.switch_month($request->month, false).'-'.($check_day/10 < 1 ? '0'.$check_day : $check_day))
            ->where('user_id', '=', $id)
            ->get();

            if (count($check_accept_paid) != 0 && $shift_name != 'Cuti') {
                DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$id);
                DB::statement('UPDATE master_users SET `yearly_leave_remaining` = `yearly_leave_remaining` + 1 WHERE `id` = '.$id);
                DB::table('accepted_paid_leaves')->where('id', '=', $id)->delete();
            }   

            $check_transaction_paid = DB::table('transaction_paid_leaves')
            ->where('user_id', '=', $id)
            ->whereIn('status', ['Diajukan', 'Pending'])
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

    public function result_calendar(Request $request)
    {
        $user = Auth::user();
        $division = division_members($user->position_id);
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
        ->whereIn('master_users.division_id',$division)
        ->select(
            'master_job_schedules.*',
            'master_users.name as user_name'
        )->get();
        
        $cal = CAL_GREGORIAN;
        $month = switch_month($split[0]);
        $days_in_month = cal_days_in_month($cal, $split[0] , date('Y'));
        
        if ($user->role_id == 1) {
            return view('masterData.schedule.calendar', [
                'data'=>$data,
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
                'day'=>$days_in_month,
                'month'=>$month,
                'year'=>$split[1],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        
    }
}
