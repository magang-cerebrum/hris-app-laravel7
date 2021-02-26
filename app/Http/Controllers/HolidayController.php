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
        $start_date = date_create($request->start);
        $end_date = date_create($request->end);
        $interval = date_diff($start_date,$end_date);
        $total_day = $interval->format('%a') + 1;
        
        $date = date('Y/m/d', strtotime('-1 days', strtotime($request->start)));

        for ($i=0; $i < $total_day; $i++) {
            $check_days = date('Y/m/d', strtotime('+1 days', strtotime($date)));
            $check_month = switch_month(date('m', strtotime($check_days)));
            $check_year = date('Y', strtotime($check_days));
            $check_day = date('j', strtotime($check_days));

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

            MasterHoliday::create([
                'information' => $request->information,
                'date' => $check_days,
                'total_day' => $total_day
            ]); 

            $date =$check_days;
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
