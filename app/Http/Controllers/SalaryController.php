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
        return view('masterData.salary.list',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function get_salary()
    {
        global $month;
        global $year;
        $month = '03';
        $year = '2021';
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


            // Contoh pembuatan objek
            // $data = array();
            // $value_data = new stdClass();
            // $value_data->name = 'nama_data';
            // $value_data->value = 1000;

            // array_push($data, $value_data);
            // $value_data = new stdClass();
            // $value_data->name = 'data';
            // $value_data->value = 500;

            // array_push($data, $value_data);
            // dd($data);

            // $pdf = PDF::loadView('/pdf.salary');
            // return $pdf->stream();

            DB::table('master_salaries')->insert([
                'user_id'=>$user_id,
                'month'=>$month,
                'year'=>$year,
                'total_default_hour'=>$default_schedule->total_hour,
                'total_work_time'=>$total_work_time[0].":".$total_work_time[1].":".$total_work_time[2],
                'total_late_time'=>$total_late_time[0].":".$total_late_time[1].":".$total_late_time[2],
                'total_fine'=>$total_fine,
                'default_salary'=>$master_user->salary,
                'total_salary_cut'=>$total_cut_salary,
                'total_salary_allowance'=>$total_allowance_salary,
                'total_salary'=>$total_salary,
                'file_salary'=>"check.pdf",
                'status'=>"Pending"
            ]);

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
