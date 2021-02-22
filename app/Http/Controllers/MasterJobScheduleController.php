<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterJobSchedule;
use App\MasterUser;
use App\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterJobScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = DB::table('master_job_schedules')
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->select(
            'master_job_schedules.*',
            'master_users.nip as user_nip',
            'master_users.name as user_name'
            )->get()
        ;

        return view('masterData.schedule.list', [
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function staff_index()
    {
        function check_month($check){
            switch ($check) {
                case '01' : return "Januari"; break;
                case '02' : return "Februari"; break;
                case '03' : return "Maret"; break;
                case '04' : return "April"; break;
                case '05' : return "Mei"; break;
                case '06' : return "Juni"; break;
                case '07' : return "Juli"; break;
                case '08' : return "Agustus"; break;
                case '09' : return "September"; break;
                case '10' : return "Oktober"; break;
                case '11' : return "November"; break;
                case '12' : return "Desember"; break;
            }
        }

        $cal = CAL_GREGORIAN;
        $month = date('m');
        $year = date('Y');
        $days_in_month = cal_days_in_month($cal, $month, $year);

        $this_month = check_month($month);
        $next_month = check_month(intval($month) + 1);

        $user = Auth::user();
        $data_this_month = DB::table('master_job_schedules')
        ->where('user_id', '=', $user->id)
        ->where('month', '=', $this_month)
        ->where('year', '=', $year)
        ->get();
        $data_next_month = DB::table('master_job_schedules')
        ->where('user_id', '=', $user->id)
        ->where('month', '=', $next_month)
        ->where('year', '=', $year)
        ->get();


        return view('staff.schedule.list', [
            'data_this_month'=>$data_this_month,
            'data_next_month'=>$data_next_month,
            'days'=>$days_in_month,
            'month'=>$month,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function index_add()
    {
        $user = Auth::user();
        $data = DB::table('master_users')
        ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->select(
            'master_users.*',
            'master_divisions.name as division_name',
            'master_positions.name as position_name'
            )
        ->get();
        return view('masterData.schedule.create', [
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function schedule_add(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('check');
        $data_user = array();
        foreach($ids as $id) {
            $data = MasterUser::where("id",$id)->first();
            array_push($data_user, $data);
        }
        $data_shift = MasterShift::all();

        return view('masterData.schedule.add', [
            'data_user'=>$data_user,
            'data_shift'=>$data_shift,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function schedule_post(Request $request)
    {
        function check($check, $request) {
            global $total_hour;
            $id = $request->$check;
            $datas = MasterShift::All();
            foreach ($datas as $data) {
                if($id == $data->id) {
                    $total_hour += $data->total_hour;
                    return $data->name;
                }
            }
        }


        for ($i = 1; $i <= $request->count; $i++) {
            global $total_hour;
            $total_hour = 0;
            
            $user_id = 'id_user_'.$i;
            $shift_1 = check('shift_1_'.$i, $request);
            $shift_2 = check('shift_2_'.$i, $request);
            $shift_3 = check('shift_3_'.$i, $request);
            $shift_4 = check('shift_4_'.$i, $request);
            $shift_5 = check('shift_5_'.$i, $request);
            $shift_6 = check('shift_6_'.$i, $request);
            $shift_7 = check('shift_7_'.$i, $request);
            $shift_8 = check('shift_8_'.$i, $request);
            $shift_9 = check('shift_9_'.$i, $request);
            $shift_10 = check('shift_10_'.$i, $request);
            $shift_11 = check('shift_11_'.$i, $request);
            $shift_12 = check('shift_12_'.$i, $request);
            $shift_13 = check('shift_13_'.$i, $request);
            $shift_14 = check('shift_14_'.$i, $request);
            $shift_15 = check('shift_15_'.$i, $request);
            $shift_16 = check('shift_16_'.$i, $request);
            $shift_17 = check('shift_17_'.$i, $request);
            $shift_18 = check('shift_18_'.$i, $request);
            $shift_19 = check('shift_19_'.$i, $request);
            $shift_20 = check('shift_20_'.$i, $request);
            $shift_21 = check('shift_21_'.$i, $request);
            $shift_22 = check('shift_22_'.$i, $request);
            $shift_23 = check('shift_23_'.$i, $request);
            $shift_24 = check('shift_24_'.$i, $request);
            $shift_25 = check('shift_25_'.$i, $request);
            $shift_26 = check('shift_26_'.$i, $request);
            $shift_27 = check('shift_27_'.$i, $request);
            $shift_28 = check('shift_28_'.$i, $request);
            $shift_29 = check('shift_29_'.$i, $request);
            $shift_30 = check('shift_30_'.$i, $request);
            $shift_31 = check('shift_31_'.$i, $request);

            $data_check = DB::table('master_job_schedules')
            ->where('user_id', '=', $request->$user_id)
            ->where('month', '=', $request->month)
            ->where('year', '=', $request->year)
            ->get();

            if (count($check) == 0 ) {
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

        return redirect('/admin/schedule');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
