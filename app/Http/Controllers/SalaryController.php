<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Asset\img;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('masterData.salary.search',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function list_data(Request $request)
    {
        $data = DB::table('master_salaries')
        ->leftJoin('master_users','master_salaries.user_id','=','master_users.id')
        ->where('month',switch_month(explode('-',$request->periode)[1]))
        ->where('year',explode('-',$request->periode)[0])
        ->select([
            'master_salaries.*',
            'master_users.name as user_name'
        ])
        ->get();

        return view('masterdata.salary.list', [
            'data' => $data,
            'month' => explode('-',$request->periode)[1],
            'year' => explode('-',$request->periode)[0]
        ]);
    }

    public function get_salary(Request $request)
    {
        global $month;
        global $year;
        $day = date('j');
        $month = $request->month;
        $year = $request->year;
        $data_presences = DB::table('master_presences')
        ->where('presence_date', 'LIKE', $year.'-'.$month.'%')
        ->where('status', 0)->get();

        while (count($data_presences) > 0) {
            $data_presences_by_user_id = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->first();
            global $user_id;
            $user_id = $data_presences_by_user_id->user_id;
            $data_user = DB::table('master_presences')->where('user_id',$user_id)->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
            $total_work_time = [ 0, 0, 0 ];
            $total_late_time = [ 0, 0, 0 ];
            $total_fine = 0;

            foreach ($data_user as $item_user) {
                $work_hour = date('H', strtotime($item_user->inaday_time));
                $work_minute = date('i', strtotime($item_user->inaday_time));
                $work_seconds = date('s', strtotime($item_user->inaday_time));
                $late_hour = date('H', strtotime($item_user->late_time));
                $late_minute = date('i', strtotime($item_user->late_time));
                $late_seconds = date('s', strtotime($item_user->late_time));

                $total_work_time[0] += $work_hour;
                $total_work_time[1] += $work_minute;
                $total_work_time[2] += $work_seconds;
                $total_late_time[0] += $late_hour;
                $total_late_time[1] += $late_minute;
                $total_late_time[2] += $late_seconds;

                $total_fine += $item_user->fine;

                DB::table('master_presences')->where('id',$item_user->id)->update(['status'=>1]);
            }

            if ( $total_work_time[2] >= 60 ) {
                $total_work_time[1] += intval($total_work_time[2]/60);
                $total_work_time[2] = intval($total_work_time[2]%60);
            }
            if ( $total_work_time[1] >= 60 ) {
                $total_work_time[0] += intval($total_work_time[1]/60);
                $total_work_time[1] = intval($total_work_time[1]%60);
            }

            if ( $total_late_time[2] >= 60 ) {
                $total_late_time[1] += intval($total_late_time[2]/60);
                $total_late_time[2] = intval($total_late_time[2]%60);
            }
            if ( $total_late_time[1] >= 60 ) {
                $total_late_time[0] += intval($total_late_time[1]/60);
                $total_late_time[1] = intval($total_late_time[1]%60);
            }

            $default_schedule = DB::table('master_job_schedules')->where('month',switch_month($month))->where('year',$year)->where('user_id',$user_id)->first();
            
            $master_user = DB::table('master_users')->where('id',$user_id)->first();

            $cut_salary = DB::table('master_salary_cuts')
            ->where('type','Semua')
            ->orWhere(function($query) {
                global $user_id;
                global $month;
                global $year;
                $query->where('user_id',$user_id)
                      ->where('month',$month)
                      ->where('year',$year);
            })
            ->get();
            $total_cut_salary = 0;

            foreach($cut_salary as $item_cut) {
                $total_cut_salary += $item_cut->nominal;
            }

            $allowance_salary = DB::table('master_salary_allowances')
            ->where('type','Semua')
            ->orWhere(function($query) {
                global $user_id;
                global $month;
                global $year;
                $query->where('user_id',$user_id)
                      ->where('month',$month)
                      ->where('year',$year);
            })
            ->get();
            $total_allowance_salary = 0;

            foreach($allowance_salary as $item_allowance) {
                $total_allowance_salary += $item_allowance->nominal;
            }

            $total_salary = $master_user->salary - $total_cut_salary + $total_allowance_salary - $total_fine;

            DB::table('master_salaries')->insert([
                'user_id'=>$user_id,
                'month'=>switch_month($month),
                'year'=>$year,
                'total_default_hour'=>$default_schedule->total_hour,
                'total_work_time'=>$total_work_time[0].":".$total_work_time[1].":".$total_work_time[2],
                'total_late_time'=>$total_late_time[0].":".$total_late_time[1].":".$total_late_time[2],
                'total_fine'=>$total_fine,
                'default_salary'=>$master_user->salary,
                'total_salary_cut'=>$total_cut_salary,
                'total_salary_allowance'=>$total_allowance_salary,
                'total_salary'=>$total_salary,
                'file_salary'=>null,
                'status'=>"Pending"
            ]);

            $data_presences = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
        }

        return redirect('/admin/salary');
    }

    public function create_slip(Request $request)
    {
        $id = $request->input('check');
        $alls = $request->input('alls');
        dump($id, $alls, $request);

        die();

        global $month;
        global $year;
        $day = date('j');
        $month = '04';
        $year = '2021';
        $data_presences = DB::table('master_presences')
        ->where('presence_date', 'LIKE', $year.'-'.$month.'%')
        ->where('status', 0)->get();

        $data_type_cut = DB::table('master_cut_allowance_types')->where('category','Potongan')->get();
        $data_type_allowance = DB::table('master_cut_allowance_types')->where('category','Tunjangan')->get();

        while (count($data_presences) > 0) {
            $data_presences_by_user_id = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->first();
            global $user_id;
            $user_id = $data_presences_by_user_id->user_id;
            $data_user = DB::table('master_presences')->where('user_id',$user_id)->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
            $total_work_time = [ 0, 0, 0 ];
            $total_late_time = [ 0, 0, 0 ];
            $total_fine = 0;

            foreach ($data_user as $item_user) {
                $work_hour = date('H', strtotime($item_user->inaday_time));
                $work_minute = date('i', strtotime($item_user->inaday_time));
                $work_seconds = date('s', strtotime($item_user->inaday_time));
                $late_hour = date('H', strtotime($item_user->late_time));
                $late_minute = date('i', strtotime($item_user->late_time));
                $late_seconds = date('s', strtotime($item_user->late_time));

                $total_work_time[0] += $work_hour;
                $total_work_time[1] += $work_minute;
                $total_work_time[2] += $work_seconds;
                $total_late_time[0] += $late_hour;
                $total_late_time[1] += $late_minute;
                $total_late_time[2] += $late_seconds;

                $total_fine += $item_user->fine;

                DB::table('master_presences')->where('id',$item_user->id)->update(['status'=>1]);
            }

            if ( $total_work_time[2] >= 60 ) {
                $total_work_time[1] += intval($total_work_time[2]/60);
                $total_work_time[2] = intval($total_work_time[2]%60);
            }
            if ( $total_work_time[1] >= 60 ) {
                $total_work_time[0] += intval($total_work_time[1]/60);
                $total_work_time[1] = intval($total_work_time[1]%60);
            }

            if ( $total_late_time[2] >= 60 ) {
                $total_late_time[1] += intval($total_late_time[2]/60);
                $total_late_time[2] = intval($total_late_time[2]%60);
            }
            if ( $total_late_time[1] >= 60 ) {
                $total_late_time[0] += intval($total_late_time[1]/60);
                $total_late_time[1] = intval($total_late_time[1]%60);
            }

            $default_schedule = DB::table('master_job_schedules')->where('month',switch_month($month))->where('year',$year)->where('user_id',$user_id)->first();
            
            $master_user = DB::table('master_users')
            ->where('master_users.id',$user_id)
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->select(
                'master_users.name as name',
                'master_divisions.name as division',
                'master_positions.name as position',
                'master_users.salary as salary',
            )
            ->first();

            $data_cut = array();
            $data_allowance = array();

            array_push($data_allowance, object_array_salary('Gaji Pokok', $master_user->salary));

            $data_overtime = DB::table('master_overtimes')
            ->where('user_id', $user_id)
            ->where('month', switch_month($month))->where('year', $year)
            ->first();
            if ($data_overtime) {
                array_push($data_allowance, object_array_salary('Lembur', $data_overtime->payment));
                DB::table('master_overtimes')->where('id', $data_overtime->id)->update(['status'=>'Paid']);
            }
            else {
                array_push($data_allowance, object_array_salary('Lembur'));
            }

            array_push($data_cut, object_array_salary('Denda Keterlambatan', $total_fine));

            foreach($data_type_cut as $cut_type) {
                if($cut_type->type == 'Semua') {
                    $get_data_cut = DB::table('master_salary_cuts')->where('information', $cut_type->name)->first();
                    if($get_data_cut) {
                        $value_data = object_array_salary($get_data_cut->information, $get_data_cut->nominal);
                    }
                    else {
                        $value_data = object_array_salary($cut_type->name);
                    }
                }
                else {
                    $get_data_cut = DB::table('master_salary_cuts')
                    ->where('information', $cut_type->name)
                    ->where('user_id', $user_id)
                    ->where('month', switch_month($month))->where('year', $year)
                    ->first();
                    if($get_data_cut) {
                        $value_data = object_array_salary($get_data_cut->information, $get_data_cut->nominal);
                    }
                    else {
                        $value_data = object_array_salary($cut_type->name);
                    }
                }
                array_push($data_cut, $value_data);
            }

            foreach($data_type_allowance as $allowance_type) {
                if($cut_type->type == 'Semua') {
                    $get_data_allowance = DB::table('master_salary_allowances')->where('information', $allowance_type->name)->first();
                    if($get_data_allowance) {
                        $value_data = object_array_salary($get_data_allowance->information, $get_data_cut->nominal);
                    }
                    else {
                        $value_data = object_array_salary($allowance_type->name);
                    }
                }
                else {
                    $get_data_allowance = DB::table('master_salary_allowances')
                    ->where('information', $allowance_type->name)
                    ->where('user_id', $user_id)
                    ->where('month', switch_month($month))->where('year', $year)
                    ->first();
                    if($get_data_allowance) {
                        $value_data = object_array_salary($get_data_allowance->information, $get_data_cut->nominal);
                    }
                    else {
                        $value_data = object_array_salary($allowance_type->name);
                    }
                }
                array_push($data_allowance, $value_data);
            }

            $total_cut_salary = 0;
            $total_allowance_salary = 0;

            foreach($data_cut as $cut) {
                $total_cut_salary += $cut->value;
            }

            foreach($data_allowance as $allowance) {
                $total_allowance_salary += $allowance->value;
            }

            $total_salary = $total_allowance_salary - $total_cut_salary;
            $string_total_salary = terbilang($total_salary);

            $pdf = PDF::loadView('/pdf.salary', [
                'day'=>$day,
                'month'=>switch_month($month),
                'year'=>$year,
                'data_staff'=>$master_user,
                'data_cut'=>$data_cut,
                'data_allowance'=>$data_allowance,
                'total_salary_cut'=>$total_cut_salary,
                'total_salary_allowance'=>$total_allowance_salary,
                'total_salary'=>$total_salary,
                'string_salary'=>$string_total_salary
            ]);
            return $pdf->stream();

            die();


            $data_presences = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
        }

        return redirect('/admin/salary');
    }

    public function reset_salary()
    {
        DB::table('master_presences')->update(['status'=>0]);
        return redirect('/admin/salary');
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
