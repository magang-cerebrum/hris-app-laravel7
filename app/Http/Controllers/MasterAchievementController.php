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
        return view('masterData.achievement.leaderboard',[
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
    public function admin_chart_index()
    {
        $score = array();
        $average = array();
        $max = array();
        $min = array();
        $temp = array();

        $user = Auth::user();
        $data = DB::table('master_users')
        ->join('master_achievements','master_users.id','=','master_achievements.achievement_user_id')
        ->where('master_achievements.year','=',date('Y'))
        ->select([
            'master_users.name',
            'master_achievements.achievement_user_id',
            'master_achievements.month',
            'master_achievements.year'
        ])->get();

        for ($i=1; $i <= 12; $i++) {
            $sum_month = 0;
            $avg_month = 0;
            $max_month = 0;
            $min_month = 100;
            $data_month = MasterAchievement::
            where('month','=', switch_month($i / 10 < 1 ? '0'. $i : $i))
            ->where('year','=',date('Y'))
            ->get();
            if (count($data_month) == 0) {
                $sum_month = 0;
                $avg_month = 0;
                $max_month = 0;
                $min_month = 0;
            } else {
                //insert score matches month
                for ($j=0; $j < count($data_month); $j++) {
                    $temp[$i][$j] = $data_month[$j]->score;
                }
                //find average
                for ($j=0; $j < count($data_month); $j++) { 
                    $sum_month += $data_month[$j]->score;
                }
                $avg_month = $sum_month / count($data_month);
                //find max
                for ($j=0; $j < count($data_month); $j++) { 
                    $temp_score = $data_month[$j]->score;
                    if ($temp_score > $max_month) {
                        $max_month = $temp_score;
                    }
                }
                //find min
                for ($j=0; $j < count($data_month); $j++) { 
                    $temp_score = $data_month[$j]->score;
                    if ($temp_score < $min_month) {
                        $min_month = $temp_score;
                    }
                }
            }
            // dd($temp[$i-1]);
            if (array_key_exists($i,$temp)) {
                $score[$i-1] = $temp[$i];
            } else {
                $score[$i-1] = 0;
            }
            $average[$i-1] = $avg_month;
            $max[$i-1] = $max_month;
            $min[$i-1] = $min_month;
        }
        // dd($score,$average,$max,$min);
        $staff = DB::table('master_users')->select(['id','name'])->get();
        return view('masterdata.achievement.listchart',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data,
            'staff' => $staff,
            'score' => $score,
            'average' => $average,
            'max' => $max,
            'min' => $min
        ]);
    }
    
}
