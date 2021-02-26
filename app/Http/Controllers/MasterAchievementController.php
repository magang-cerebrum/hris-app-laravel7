<?php

namespace App\Http\Controllers;

use App\MasterAchievement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        // $name = DB::table('master_achievements')->
        // leftjoin('master_users',
        // 'master_achievements.achievement_user_id','=','master_users.id')
        // ->select('master_users.name')->get();
        // // dd($name);
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

   
    public function scoring(Request $request , MasterAchievement $masterAchievement){
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
    public function scored (Request $request){
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
    public function admin_charts (){
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
    public function admin_chart_index()
    {
        $average = array();
        $max = array();
        $min = array();

        $user = Auth::user();
        $currentyear = date('Y');
        $data = DB::table('master_users')
        ->join('master_achievements','master_users.id','=','master_achievements.achievement_user_id')
        ->where('master_achievements.year','=',$currentyear)
        ->select([
            'master_users.name',
            'master_achievements.achievement_user_id',
            'master_achievements.score',
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
            ->where('year','=',$currentyear)
            ->get();
            // dd($data_month);
            if (count($data_month) == 0) {
                $sum_month = 0;
                $avg_month = 0;
                $max_month = 0;
                $min_month = 0;
            } else {
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
            $average[] = $avg_month;
            $max[] = $max_month;
            $min[] = $min_month;
        }
        $staff = DB::table('master_users')->select(['id','name'])->get();
        return view('masterdata.achievement.listchart',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data,
            'staff' => $staff,
            'average' => $average,
            'max' => $max,
            'min' => $min
        ]);
    }
}
