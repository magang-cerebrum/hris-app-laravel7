<?php

namespace App\Http\Controllers;

use App\MasterAchievement;
use App\Http\Controllers\Controller;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class MasterAchievementController extends Controller
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
        elseif(Gate::allows('is_admin')){
            $user = Auth::user();
        $count = MasterAchievement::count();
        $max = MasterAchievement::max('score');
        $data = DB::table('master_achievements')->
        leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
        ->orderBy('score','desc')->get();
        // dd($data);
        return view('masterData.achievement.list',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,

            'data'=>$data,
            'count'=>$count,
            'max'=>$max
            
            ]);
        }
        
        
    }

    public function search(Request $request){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){

            $data = MasterAchievement::where(['month'=>$request->month,
        'year'=>$request->year])->
        leftjoin('master_users',
        'master_achievements.achievement_user_id','=','master_users.id')
        ->orderBy('score','desc')
        ->get();
        $is_champ = MasterAchievement::where(['month'=>$request->month,
        'year'=>$request->year])->max('score');
        // dd($is_champ);
        $count = count($data);
        return view('masterData.achievement.result',['data'=>$data,
        'count'=>$count,
        'employee_of_the_month' =>$is_champ
        ]);
        }
        
    }

   
    public function scoring(Request $request , MasterAchievement $masterAchievement){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
            $user = Auth::user();
             $data = DB::table('master_users')->get();
            return view('masterData.achievement.scoring',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data
            ]);
        }
        
    }

    public function scored (Request $request){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
            global $datas;
        $datas=$request;
        for($i = 1; $i <=$request->count; $i++){
            global $datas;
            $user_id = 'user_id_'.$i;
            $data_id = $datas->$user_id;
            $score = 'score_'.$i;
            $data = $datas->$score;
            MasterAchievement::create([
                'score' => $data,
                'month'  =>$datas->month,
                'year' =>$datas->year ,
                'achievement_user_id'=>$data_id
            ]);
        }
        Alert::success('Berhasil!', 'Nilai untuk penghargaan periode bulan ' . $request->month . ' tahun ' . $request->year . ' berhasil ditambahkan!');
        return redirect('/admin/achievement');
        }
        
    }
    public function admin_charts (){
        if (Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
            $user = Auth::user();
        $currentyear = date('Y');
        // dd($currentyear);
        $data = DB::table('master_achievements')
        ->leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
        ->where('achievement_user_id','=','2')->where('year','=',$currentyear)
        ->select(['master_achievements.score','master_achievements.achievement_user_id'
        ,'master_users.name','master_achievements.month','master_achievements.year'])->get();
        // $decode = json_decode($data);
        $count = count($data);
        // dd($data);
        // $month = DB::table('master_achievements')->
        // leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')->get();
            return view('masterdata.achievement.charts_admin',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data,
            'count' =>$count
            ]);
        }
        
          
    }
    
}
