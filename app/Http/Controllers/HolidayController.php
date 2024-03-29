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
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')) {
                $data = MasterHoliday::paginate(10);
                $user = Auth::user();

                $company = DB::table('settings')->get();
                foreach ($company as $item) {
                    $company_data[$item->name] = $item->value;
                }
                
                return view('masterData.holiday.list', [
                    'menu'=>['m-master','s-master-libur'],
                    'company_name'=>$company_data['Nama Perusahaan'],
                    'company_logo'=>$company_data['Logo Perusahaan'],
                    'data' => $data,
                    'name'=>$user->name,
                    'profile_photo'=>$user->profile_photo,
                    'email'=>$user->email,
                    'id'=>$user->id
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function create()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')) {
            $user = Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.holiday.add', [
                'menu'=>['m-master','s-master-libur'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);}
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {   
        if(Auth::check()){
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
                ->whereIn('transaction_paid_leaves.status', ['Diajukan', 'Pending'])
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
                            ->update(['shift_'.$check_day => 'Off', 'total_hour' => $shift_hour]);
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterHoliday $holiday)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')) {
            $user = Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.holiday.edit',[
                'menu'=>['m-master','s-master-libur'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'holiday' => $holiday,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);}
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update(MasterHoliday $holiday, Request $request)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                return abort(403,'Access Denied, Only Admin Can Access');
            }
            elseif(Gate::allows('is_admin')) {
            $request->validate([
                'information' => 'required',
                'date' => 'required|unique:master_holidays,date',
            ]);
            $holiday_data = DB::table('master_holidays')->where('id', $holiday->id)->select(['date'])->first();
            if(date('Y-m-d') < $holiday_data->date) {
                $data_schedule = DB::table('master_job_schedules')
                ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
                ->where('month', switch_month(explode('-', $holiday_data->date)[1]))
                ->where('year', explode('-', $holiday_data->date)[0])
                ->whereNotIn('division_id', [5])
                ->select(['master_job_schedules.*'])->get();
    
                if($data_schedule) {
                    $hour = DB::table('master_shifts')->where('name','Pagi')->select(['total_hour'])->first();
                    $temp = 'shift_'.explode('-', $holiday_data->date)[2];
                    foreach($data_schedule as $update) {
                        $total_hour = $update->total_hour + $hour->total_hour;
                        DB::table('master_job_schedules')->where('id', $update->id)->update([$temp=>'Pagi', 'total_hour'=>$total_hour]);
                    }
                }
            }
            if(date('Y-m-d') < $request->date) {
                $data_schedule = DB::table('master_job_schedules')
                ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
                ->where('month', switch_month(explode('/', $request->date)[1]))
                ->where('year', explode('/', $request->date)[0])
                ->whereNotIn('division_id', [5])
                ->select(['master_job_schedules.*'])->get();
    
                if($data_schedule) {
                    $temp = 'shift_'.explode('/', $request->date)[2];
                    foreach($data_schedule as $update) {
                        $total_hour = $update->total_hour - check_hour_shift($update->$temp);
                        DB::table('master_job_schedules')->where('id', $update->id)->update([$temp=>'Off', 'total_hour'=>$total_hour]);
                    }
                }
            }
            MasterHoliday::where('id', $holiday->id)
                ->update([
                    'information' => $request->information,
                    'date' => $request->date
                ]);
            Alert::success('Berhasil!', 'Hari Libur ' . $holiday->information . ' berhasil diperbaharui!');
            return redirect('/admin/holiday');}
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroy(Request $request)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                return abort(403,'Access Denied, Only Admin Can Access');
            }
            elseif(Gate::allows('is_admin')) {
            foreach ($request->selectid as $item) {
                $holiday = DB::table('master_holidays')->where('id', $item)->select(['date'])->first();
                if(date('Y-m-d') < $holiday->date) {
                    $data_schedule = DB::table('master_job_schedules')
                    ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
                    ->where('month', switch_month(explode('-', $holiday->date)[1]))
                    ->where('year', explode('-', $holiday->date)[0])
                    ->whereNotIn('division_id', [5])
                    ->select(['master_job_schedules.*'])->get();
    
                    if($data_schedule) {
                        $hour = DB::table('master_shifts')->where('name','Pagi')->select(['total_hour'])->first();
                        $temp = 'shift_'.explode('-', $holiday->date)[2];
                        foreach($data_schedule as $update) {
                            $total_hour = $update->total_hour + $hour->total_hour;
                            DB::table('master_job_schedules')->where('id', $update->id)->update([$temp=>'Pagi', 'total_hour'=>$total_hour]);
                        }
                    }
                }
                MasterHoliday::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Hari libur yang dipilih berhasil dihapus!');
            return redirect('/admin/holiday');}
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function search(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            if ($request->get('query') == null) {return redirect('/admin/holiday');}
            if (strpos($request->get('query'),'/')) {
                $split = explode('/',$request->get('query'));
                $data = MasterHoliday::whereRaw("date LIKE '".$split[1]."-".$split[0]."%'")
                ->paginate(10);
            } else {
                $data = MasterHoliday::whereRaw("information LIKE '%" . $request->get('query') . "%'")
                ->paginate(10);
            }
            $user =  Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.holiday.result', [
                'menu'=>['m-master','s-master-libur'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'data' => $data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->idate
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
