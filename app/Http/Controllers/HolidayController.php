<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterHoliday;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
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
        $data = MasterHoliday::All();
        $user = Auth::user();

        return view('masterData.holiday.list', [
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

        return view('masterData.holiday.add', [
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
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
            ->where('date', '=', $check_year.'-'.$month.'-'.$check_day)->get();

            foreach ($accept_paid_leave as $item_accept) {
                DB::statement('UPDATE transaction_paid_leaves SET `days` = `days` - 1 WHERE `id` = '.$item_accept->paid_leave_id);
                DB::statement('UPDATE master_users SET `yearly_leave_remaining` = `yearly_leave_remaining` + 1 WHERE `id` = '.$item_accept->user_id);
                DB::table('accepted_paid_leaves')->where('id', '=', $item_accept->id)->delete();
            }

            $transaction_paid_leave = DB::table('transaction_paid_leaves')
            ->whereIn('status', ['Diajukan', 'Pending'])->get();
            
            foreach ($transaction_paid_leave as $item_transaction) {
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

            $data_schedule = DB::table('master_job_schedules')
            ->where('month','=',$check_month)
            ->where('year','=',$check_year)
            ->get();

            foreach ($data_schedule as $item) {
                $date_shift = 'shift_'.$check_day;
                $total_hour = $item->total_hour;
                $shift = $item->$date_shift;
                $shift_hour = $total_hour - check_hour_shift($shift);
                
                DB::table('master_job_schedules')
                ->where('id', '=', $item->id)
                ->update(['shift_'.$check_day => 'Off', 'total_hour' => $shift_hour]);
            }

            if ($i == 1) {
                // die();
            }

            MasterHoliday::create([
                'information' => $request->information,
                'date' => $check_days,
                'total_day' => $total_day
            ]); 

            $date = $check_days;
        }

        // die();
        
        Alert::success('Berhasil!', 'Hari libur baru telah ditambahkan!');
        return redirect('/admin/holiday');
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
    public function edit(MasterHoliday $holiday)
    {
        $user = Auth::user();
        return view('masterdata.holiday.edit',[
            'holiday' => $holiday,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
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
        return redirect('/admin/holiday');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach ($request->selectid as $item) {
            MasterHoliday::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Hari libur yang dipilih berhasil dihapus!');
        return redirect('/admin/holiday');
    }
}
