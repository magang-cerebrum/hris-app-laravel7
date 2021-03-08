<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterHoliday;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        $data = MasterHoliday::All();
        $user = Auth::user();

        return view('masterData.holiday.list', [
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        $user = Auth::user();

        return view('masterData.holiday.add', [
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        $request->validate([
            'information' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $interval = date_diff(date_create($request->start),date_create($request->end));
        $total_day = $interval->format('%a') + 1;
        
        $date = date('Y/m/d', strtotime('-1 days', strtotime($request->start)));

        for ($i=0; $i < $total_day; $i++) {
            $check_days = date('Y/m/d', strtotime('+1 days', strtotime($date)));
            $month = date('m', strtotime($check_days));
            $check_month = switch_month($month);
            $check_year = date('Y', strtotime($check_days));
            $check_day = date('j', strtotime($check_days));

            $accept_paid_leave = DB::table('accepted_paid_leaves')
            ->where('date', '=', $check_year.'-'.$month.'-'.$check_day)
            ->leftJoin('master_users','accepted_paid_leaves.user_id','=','master_users.id')
            ->select(
                'accepted_paid_leaves.*',
                'master_users.division_id as division_id'
                )
            ->get();

            foreach ($accept_paid_leave as $item_accept) {
                if ($item_accept->division_id != 5) {
                    DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$item_accept->paid_leave_id);
                    DB::statement('UPDATE master_users SET `yearly_leave_remaining` = `yearly_leave_remaining` + 1 WHERE `id` = '.$item_accept->user_id);
                    DB::table('accepted_paid_leaves')->where('id', '=', $item_accept->id)->delete();
                }
            }

            $transaction_paid_leave = DB::table('transaction_paid_leaves')
            ->whereIn('status', ['Diajukan', 'Pending'])
            ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
            ->select(
                'transaction_paid_leaves.*',
                'master_users.division_id as division_id'
                )
            ->get();
            
            foreach ($transaction_paid_leave as $item_transaction) {
                if ($item_transaction->division_id != 5) {
                    $transaction_interval = date_diff(date_create($item_transaction->paid_leave_date_start),date_create($item_transaction->paid_leave_date_end));
                    $transaction_total_day = $transaction_interval->format('%a') + 1;

                    $transaction_date_start = date('Y-m-d', strtotime('-1 days', strtotime($item_transaction->paid_leave_date_start)));
                    for ($x = 0; $x <$transaction_total_day; $x++) {
                        $check_transaction_days = date('Y-m-d', strtotime('+1 days', strtotime($transaction_date_start)));
                        if ($check_transaction_days == $check_year.'-'.$month.'-'.$check_day) {
                            DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$item_transaction->id);
                        }
                        $transaction_date_start = $check_transaction_days;
                    }
                }
            }

            $data_schedule = DB::table('master_job_schedules')
            ->where('month','=',$check_month)
            ->where('year','=',$check_year)
            ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
            ->select(
                'master_job_schedules.*',
                'master_users.division_id as division_id'
                )
            ->get();

            foreach ($data_schedule as $item) {
                if ($item->division_id != 5) {
                    $date_shift = 'shift_'.$check_day;
                    $total_hour = $item->total_hour;
                    $shift = $item->$date_shift;

                    if( $shift != 'Off' || $shift != 'Cuti') {
                        $shift_hour = $total_hour - check_hour_shift($shift);
                        DB::table('master_job_schedules')
                        ->where('id', '=', $item->id)
                        ->update(['shift_'.$check_day => 'Cuti', 'total_hour' => $shift_hour]);
                    }
                }
            }

            MasterHoliday::create([
                'information' => $request->information,
                'date' => $check_days,
                'total_day' => $total_day
            ]); 

            $date = $check_days;
        }
        
        Alert::success('Berhasil!', 'Hari libur baru telah ditambahkan!');
        return redirect('/admin/holiday');
        }
    }

    public function edit(MasterHoliday $holiday)
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        $user = Auth::user();
        return view('masterdata.holiday.edit',[
            'holiday' => $holiday,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterHoliday $holiday, Request $request)
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        $request->validate([
            'information' => 'required',
            'date' => 'required|unique:master_holidays,date',
        ]);

        MasterHoliday::where('id', $holiday->id)
            ->update([
                'information' => $request->information,
                'date' => $request->date
            ]);
        Alert::success('Berhasil!', 'Hari Libur ' . $holiday->information . ' berhasil diperbaharui!');
        return redirect('/admin/holiday');}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
        foreach ($request->selectid as $item) {
            MasterHoliday::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Hari libur yang dipilih berhasil dihapus!');
        return redirect('/admin/holiday');}
    }
}
