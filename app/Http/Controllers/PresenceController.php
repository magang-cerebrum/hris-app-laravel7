<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterPresence;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
class PresenceController extends Controller
{
    public function staff_view(){
        $user = Auth::user();
        $presence = MasterPresence::where(['presence_date'=> date('Y-m-d'),'user_id'=> $user->id,])
        ->select('in_time','out_time','late_time','late_time_rounded')
        ->first();
        // dd($presence);
        return view('staff.presence.history',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'presence' => $presence
        ]);
    }
    public function test_presence(){
        $user = Auth::user(); // diganti siapa yg absen
        $waktu_masuk = date_create('08:11:52'); //diganti masuk kapan
        $waktu_keluar = date_create('17:05:33'); //
        $waktu_sehari = date_diff($waktu_masuk, $waktu_keluar);
        $dibuletin = null;
        if($waktu_masuk > date_create('08:00:00')){
            $interval = date_diff($waktu_masuk,date_create('08:00:00'));
            $telat = $interval->format('%h:%i:%s');
            $menit_telat = $interval->format('%i') / 5;
            $menit_telat_dibuletin = intval($menit_telat);
            if( substr($menit_telat,-1,1) > 5){
                $dibuletin = ($menit_telat_dibuletin + 1 )* 5;
            } else{
                $dibuletin = $menit_telat_dibuletin* 5;
            }
        } else{
            $telat = null;
            $dibuletin = null;
        }
        MasterPresence::updateOrCreate([
            'user_id' => $user->id,
            'in_time' => $waktu_masuk,
            'out_time' => $waktu_keluar,
            'inaday_time' => $waktu_sehari->format('%h:%i:%s'),
            'late_time' => $telat,
            'late_time_rounded' => $dibuletin,
            'presence_date' => date('Y/m/d')
        ]);
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
        return view('masterdata.presence.views');
    }
    public function viewProcessedPresence(){
        $count =   count( DB::table('log_presences')->where('status','=',0)->get());
        while($count>0){
            
            $checkFirstData = DB::table('log_presences')->where('status','=',0)->first();
            $data = DB::table('log_presences')->where('user_id',$checkFirstData->user_id)->where('date',$checkFirstData->date)->get();
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
            $inTimeLateHour = $intervalLate->format('%h');
            $inTimeLateMinute = $intervalLate->format('%i');
            $late = ($inTimeLateHour * 60) + $inTimeLateMinute; 
            $invertedLate = $intervalLate->invert;
            if($invertedLate == 1 ){
                $late = 0;
            }
            $fine = (intval($late/9))*20000;
            // dd($fine,$defaultInTime,$entryTime,$intervalLate,$inTimeLateHour,$inTimeLateMinute,$late,$invertedLate);
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
        
        
    }
    public function resetStats(){
        DB::table('log_presences')
        ->whereIn('id',range(1,16))
        ->update(['status'=>0]);
        return redirect()->back();
    }
}
