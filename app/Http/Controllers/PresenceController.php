<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterPresence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
class PresenceController extends Controller
{
    public function staff_view(){
        $user = Auth::user();
        $date = date('Y-m-d');
        $count_presence_in_day = DB::table('master_presences')->where('user_id', $user->id)->where('presence_date', $date)->get();
        if (count($count_presence_in_day) == 0) {
            $bool_presence = 0;
        }
        else {
            if ($count_presence_in_day[0]->out_time == null) {
                $bool_presence = 1;
            }
            else {
                $bool_presence = 2;
            }
        }
        $shift = 'shift_'.date('j');
        $bool_schedule = DB::table('master_job_schedules')
        ->where('month', switch_month(date('m')))
        ->where('year', date('Y'))
        ->where('user_id', $user->id)->first();

        $bool_schedule = $bool_schedule->$shift;

        return view('staff.presence.history',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'bool_presence'=>$bool_presence,
            'bool_schedule' => $bool_schedule
        ]);
    }

    public function chief_view(){
        $user = Auth::user();
        $data = DB::table('master_presences')
        ->leftJoin('master_users','master_presences.user_id','=','master_users.id')
        ->where('master_users.division_id',$user->division_id)
        ->whereNotNull('file_in')->where('check_chief',0)
        ->select([
            'master_presences.*',
            'master_users.name as name'
        ])
        ->get();

        return view('staff.presence.division',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data
        ]);
    }

    public function chief_approve(Request $request){
        foreach ($request->selectid as $item) {

            $data = DB::table('master_presences')->where('id',$item)->first();
            
            $path_file = 'img-presensi/masuk/'.$data->file_in;
            $file_path_file = public_path($path_file);
            unlink($file_path_file);

            DB::table('master_presences')->where('id',$item)->update(['file_in'=>null,  'check_chief'=>1]);
        }

        return redirect('/staff/presence/division');
    }

    public function take_presence(){
        $user = Auth::user();
        $division = DB::table('master_divisions')->where('id', $user->division_id)->select(['name'])->first();
        $date = date('Y-m-d');
        $count_presence_in_day = DB::table('master_presences')->where('user_id', $user->id)->where('presence_date', $date)->get();
        if (count($count_presence_in_day) == 0) {
            $bool_presence = 0;
        }
        else {
            if ($count_presence_in_day[0]->out_time == null) {
                $bool_presence = 1;
            }
            else {
                $bool_presence = 2;
            }
        }
        $shift = 'shift_'.date('j');
        $bool_schedule = DB::table('master_job_schedules')
        ->where('month', switch_month(date('m')))
        ->where('year', date('Y'))
        ->where('user_id', $user->id)->first();

        return view('staff.presence.take',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'division'=>$division->name,
            'bool_presence'=>$bool_presence,
            'shift'=>$bool_schedule->$shift
        ]);
    }

    public function add_presence(Request $request) {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        $master_shift = DB::table('master_shifts')->get();

        if ($request->bool_presence == 0) {
            $last_presence = DB::table('master_presences')
            ->where('user_id', $request->user_id)
            ->orderBy('presence_date', 'desc')->first();
            if ($last_presence) {
                if (!$last_presence->out_time) {
                    DB::table('master_presences')
                    ->where('id', $last_presence->id)
                    ->update([
                        'out_time'=> "00:00:00",
                        'inaday_time'=> "00:00:00",
                        'late_time'=> "00:00:00",
                        'fine'=> 0
                    ]);
                }
            }

            $data_shift = DB::table('master_job_schedules')
            ->where('month', switch_month(date('m', strtotime($date))))
            ->where('year', date('Y', strtotime($date)))
            ->where('user_id',$request->user_id)->first();
            
            $image = $request->image;
            $image_array_1 = explode(";", $image);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $image_name = $date.'_'. Auth::user()->name . '.jpeg';

            $temp_name = 'shift_'.date('j', strtotime($date));
            $shift = $data_shift->$temp_name;

            $hour_shift = 0;
            foreach($master_shift as $item_shift) {
                if ($item_shift->name == $shift) {
                    $hour_shift = $item_shift->total_hour;
                }
            }

            $image_path = 'img-presensi/masuk/' . $image_name;
            file_put_contents($image_path, $data);

            DB::table('master_presences')->insert([
                'user_id' => $request->user_id,
                'presence_date' => $date,
                'in_time' => $time,
                'shift_name' => $shift,
                'shift_default_hour' => $hour_shift,
                'file_in' => $image_name
            ]);

            DB::table('master_check_presences')->where('user_id',$request->user_id)->delete();
        }
        else if ($request->bool_presence == 1) {
            $data_presence = DB::table('master_presences')
            ->where('user_id', $request->user_id)
            ->where('presence_date', $date)->first();

            $normaly_in_time = 0;
            foreach($master_shift as $item_shift) {
                if ($item_shift->name == $data_presence->shift_name) {
                    $normaly_in_time = $item_shift->start_working_time;
                }
            }

            $interval = date_diff(date_create($data_presence->in_time),date_create($time));
            $inadayTime = $interval->format('%h:%i:%s');
            $intervalLate = date_diff(date_create($normaly_in_time),date_create($data_presence->in_time));
            $late = $intervalLate->format('%h:%i:%s');
            $inTimeLateHour = $intervalLate->format('%h');
            $inTimeLateMinute = $intervalLate->format('%i');
            $lateInMinute = ($inTimeLateHour * 60) + $inTimeLateMinute; 
            $invertedLate = $intervalLate->invert;
            if($invertedLate == 1 ){
                $lateInMinute = 0;
                $late = '0:0:0';
            }
            $fine = (intval($lateInMinute/5))*20000;

            DB::table('master_presences')
            ->where('id', $data_presence->id)
            ->update([
                'out_time'=>$time,
                'inaday_time'=> $inadayTime,
                'late_time'=> $late,
                'fine'=> $fine
            ]);
        }
        return redirect('/staff/presence');
    }

    public function search(Request $request){
        $request->validate([
            'start' => 'required',
            'end' => 'required'
        ]);
        $start = date_format(date_create($request->start),'Y-m-d');
        $end = date_format(date_create($request->end),'Y-m-d');
        $user=Auth::user();
        $data = MasterPresence::whereBetween('presence_date',[date($request->start),date($request->end)])->where('user_id','=',$user->id)->paginate(5);
        return view('staff.presence.result',[
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function getProcessedPresenceView(){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        $cal = CAL_GREGORIAN;
        $days_in_month = cal_days_in_month($cal, date('m'), date('Y'));
        $data = array();
        $data_schedule = DB::table('master_job_schedules')
        ->leftJoin('master_users','master_job_schedules.user_id','=','master_users.id')
        ->where('master_users.status','Aktif')
        ->select([
            'master_job_schedules.*',
            'master_users.name as user_name'
        ])
        ->get();
        foreach ($data_schedule as $user_schedule) {
            $shifts = array();
            for ($i=1; $i <= $days_in_month; $i++) { 
                $temp = 'shift_' . $i;
                $getShift = $user_schedule->$temp;
                if ($getShift != 'Off' && $getShift != 'Cuti') {                    
                    $data_presence = DB::table('master_presences')
                    ->where('presence_date',date('Y') . '-' . date('m') . '-' . ($i / 10 < 1 ? '0'. $i : $i))
                    ->where('user_id',$user_schedule->user_id)
                    ->first();
                    if ($data_presence == null) {
                        $getShift = 'Kosong';
                    } else {
                        if ($data_presence->late_time == '00:00:00') {
                            $getShift = 'Hadir';
                        } else {
                            $getShift = 'Telat';
                        }
                    }
                }
                array_push($shifts,$getShift);
            }
            array_push($data,pushData($shifts,$user_schedule->user_id,$user_schedule->user_name));
        }
        return view('masterdata.presence.list',[
            'data'=>$data,
            'day'=>$days_in_month,
            'month'=>date('m'),
            'year'=>date('Y'),
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function viewProcessedPresence(){
        $count =   count( DB::table('log_presences')->where('status','=',0)->get());
        while($count>0){
            
            $checkFirstData = DB::table('log_presences')->where('status','=',0)->first();
            $data = DB::table('log_presences')->where('user_id',$checkFirstData->user_id)->where('date',$checkFirstData->date)->where('status','=',0)->get();
            $entryTime = $data->first()->time;
            $exitTime = $data->last()->time;
            $interval = date_diff(date_create($entryTime),date_create($exitTime));
            $inadayTime = $interval->format('%h:%i:%s');
            $month = switch_month(date('m', strtotime($checkFirstData->date)));
            $year = date('Y',strtotime($checkFirstData->date));
            $day = date('j',strtotime($checkFirstData->date));
            $schedules =DB::table('master_job_schedules')->where('user_id','=',$checkFirstData->user_id)->where('year',$year)->where('month',$month)->get();
            $nameShift = "shift_".$day;
            $shiftTake = $schedules[0]->$nameShift;
            $masterShifts=  DB::table('master_shifts')->get();
            $shiftDefaultHour = 0;
            $defaultInTime= 0;
            foreach ($masterShifts as $itemShifts){
                if($itemShifts->name == $shiftTake){
                    $shiftDefaultHour = $itemShifts->total_hour;
                    $defaultInTime = $itemShifts->start_working_time;
                }
            }
            // dd($defaultInTime);
            $intervalLate = date_diff(date_create($defaultInTime),date_create($entryTime));
            $late = $intervalLate->format('%h:%i:%s');
            $inTimeLateHour = $intervalLate->format('%h');
            $inTimeLateMinute = $intervalLate->format('%i');
            $lateInMinute = ($inTimeLateHour * 60) + $inTimeLateMinute; 
            $invertedLate = $intervalLate->invert;
            if($invertedLate == 1 ){
                $lateInMinute = 0;
                $late = '0:0:0';
            }
            $fine = (intval($lateInMinute/5))*20000;
            DB::table('master_presences')
            ->insert(
                [
                    'user_id'=>$checkFirstData->user_id,
                    'presence_date'=>$checkFirstData->date,
                    'in_time'=>$entryTime,
                    'out_time'=>$exitTime,
                    'inaday_time'=>$inadayTime,
                    'late_time'=>$late,
                    'fine'=>$fine,
                    'shift_name'=>$shiftTake,
                    'shift_default_hour'=>$shiftDefaultHour
                    
                ]
            );
                // dump($nameShift);
                // die;
            foreach($data as $itemsData){
                 DB::table('log_presences')->where('id','=',$itemsData->id)->update(['status'=>1]);
            }
            
            $count = count( DB::table('log_presences')->where('status','=',0)->get());
            
        }
        return redirect()->back(); 
        
    }

    public function resetStats(){
        DB::table('log_presences')
        ->whereIn('id',range(1,16))
        ->update(['status'=>0]);
        return redirect()->back();
    }
    
}
