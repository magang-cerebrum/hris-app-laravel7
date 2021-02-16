<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterPresence;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
        $user=Auth::user();
        $data = MasterPresence::whereBetween('presence_date',[date($request->start),date($request->end)])->where('user_id','=',$user->id)->paginate(5);
        return view('staff.presence.result',['data' => $data]);
    }
}
