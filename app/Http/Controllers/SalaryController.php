<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masterData.salary.list');
    }

    public function get_salary()
    {
        $month = '03';
        $year = '2021';
        $data_presences = DB::table('master_presences')
        ->where('presence_date', 'LIKE', $year.'-'.$month.'%')
        ->where('status', 0)->get();

        while (count($data_presences) > 0) {
            $data_presences_by_user_id = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->first();
            $data_user = DB::table('master_presences')->where('user_id',$data_presences_by_user_id->user_id)->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
            $total_work_time = date('h:i:s', strtotime('00:00:00'));
            $total_late_time = date('h:i:s', strtotime('00:00:00'));
            $total_fine = 0;

            foreach ($data_user as $item_user) {
                $work_hour = date('h', strtotime($item_user->inaday_time));
                $work_minute = date('i', strtotime($item_user->inaday_time));
                $work_seconds = date('s', strtotime($item_user->inaday_time));
                $late_hour = date('h', strtotime($item_user->late_time));
                $late_minute = date('i', strtotime($item_user->late_time));
                $late_seconds = date('s', strtotime($item_user->late_time));

                $total_work_time = date('h:i:s', strtotime('+'.$work_hour.' hour '.$work_minute.' minute '.$work_seconds.' seconds', strtotime($total_work_time)));
                $total_late_time = date('h:i:s', strtotime('+'.$late_hour.' hour '.$late_minute.' minute '.$late_seconds.' seconds', strtotime($total_late_time)));
                $total_fine += $item_user->fine;
            }

            // DB::table('master_salaries')->insert([
            //     'user_id'=>$data_presences_by_user_id->user_id,
            //     'month'=>$month,
            //     'year'=>$year,
            //     'total_default_hour',
            //     'total_work_time'=>$total_work_time,
            //     'total_late_time'=>$total_late_time,
            //     'total_fine'=>$total_fine,
            //     'default_salary',
            //     'total_salary_cut',
            //     'total_salary_allowance',
            //     'total_salary',
            //     'file_salary',
            //     'status'
            // ]);

            $data_presences = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
        }

        die();
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
