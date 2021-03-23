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
            $splitter = explode('/',$request->get('query'));
            $data = MasterAchievement::where(['month'=>switch_month($splitter[0]),
        'year'=>$splitter[1]])
        ->leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
        ->orderBy('score','desc')
        ->get();
        $is_champ = MasterAchievement::where(['month'=>switch_month($splitter[0]),
        'year'=>$splitter[1]])->max('score');
        // dd($is_champ);
        $count = count($data);
        return view('masterData.achievement.result',['data'=>$data,
        'count'=>$count,
        'employee_of_the_month' =>$is_champ
        ]);
        }
        
    }

    
    public function scoring(){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            $data = DB::table('master_users')
            ->where('status','=','Aktif')
            ->where('division_id','!=',7)
            ->where('position_id','!=',[11,3])
            ->get();
            
            
            // dd(DB::table('master_achievements')->whereNotNull('score')->get());
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
                $split = explode('/',$datas->get('query'));

                $check = DB::table('master_achievements')
                ->where('year','=',$split[1])
                ->where('month','=',switch_month($split[0]))
                ->where('achievement_user_id',$data_id)
                ->get();

                if ($data == 0) {continue;}
                if(count($check) > 0){
                    foreach($check as $items){
                    MasterAchievement::where('id','=',$items->id)->update([
                        'score' => $data
                    ]); }
                }
                else {MasterAchievement::create([
                    'score' => $data,
                    'month'  =>switch_month($split[0]),
                    'year' =>$split[1] ,
                    'achievement_user_id'=>$data_id
                ]);
                }
            }
            Alert::success('Berhasil!', 'Nilai untuk penghargaan periode bulan ' . switch_month($split[0]) . ' tahun ' . $split[1] . ' berhasil ditambahkan!');
            return redirect('/admin/achievement');
        }
        
    }

    public function chiefScoring(){
            $user = Auth::user();
            // dd($user->division_id);
            $data = DB::table('master_users')
            ->where('status','=','Aktif')
            ->whereIn('division_id',division_members($user->position_id))
            ->where('position_id','=',11)
            ->get();
            return view('masterData.achievement.Chiefscoring',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'data'=>$data
        ]);
    }
    public function chiefScored(Request $request){
            global $datas;
            $datas=$request;
            for($i = 1; $i <=$request->count; $i++){
                global $datas;
                $user_id = 'user_id_'.$i;
                $data_id = $datas->$user_id;
                $score = 'score_'.$i;
                $data = $datas->$score;
                $split = explode('/',$datas->get('query'));

                $check = DB::table('master_achievements')
                ->where('year','=',$split[1])
                ->where('month','=',switch_month($split[0]))
                ->where('achievement_user_id',$data_id)
                ->get();
                if ($data == 0) {continue;}
                if(count($check) > 0){
                    foreach($check as $items){
                    MasterAchievement::where('id','=',$items->id)->update([
                        'score' => $data
                    ]); }
                }
                else {MasterAchievement::create([
                    'score' => $data,
                    'month'  =>switch_month($split[0]),
                    'year' =>$split[1] ,
                    'achievement_user_id'=>$data_id
                ]);
                }
            }
            Alert::success('Berhasil!', 'Nilai untuk penghargaan periode bulan ' . switch_month($split[0]) . ' tahun ' . $split[1] . ' berhasil ditambahkan!');
            return redirect('/staff/achievement/scoring');
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

        $user = Auth::user();

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
                //insert score matches month
                for ($j=0; $j < count($data_month); $j++) {                    
                    $usernya = $data_month[$j]->achievement_user_id;
                    $data_user = MasterAchievement::
                    where('month','=',switch_month($i / 10 < 1 ? '0'. $i : $i))
                    ->where('year','=',date('Y'))
                    ->where('achievement_user_id','=',$usernya)
                    ->get();
                    foreach ($data_user as $item) {
                        $score[$i-1][$item->achievement_user_id] = $item->score;
                    }
                }
            }
            $average[$i-1] = $avg_month;
            $max[$i-1] = $max_month;
            $min[$i-1] = $min_month;
        }
        $staff = DB::table('master_users')->where('status','Aktif')
        ->whereNotIn('position_id',[1,2,3])
        ->select(['id','name'])->paginate(10);
        return view('masterdata.achievement.listchart',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'staff' => $staff,
            'score' => $score,
            'average' => $average,
            'max' => $max,
            'min' => $min
        ]);
    }

    public function searchlist(Request $request){
        if ($request->get('query') == null) {return redirect('/admin/achievement/charts');}
        
        $check_user = DB::table('master_users')->select(['id','name'])
        ->whereRaw("name LIKE '%" . $request->get('query') . "%'")
        ->where('status','Aktif')
        ->whereNotIn('position_id',[1,2,3])
        ->get();
        foreach ($check_user as $item){$ids[] = $item->id;}

        $score = array();
        $average = array();
        $max = array();
        $min = array();

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
                //insert score matches month
                for ($j=0; $j < count($data_month); $j++) {
                    for ($k=0; $k < count($ids); $k++) { 
                        $data_user = MasterAchievement::
                        where('month','=',switch_month($i / 10 < 1 ? '0'. $i : $i))
                        ->where('year','=',date('Y'))
                        ->where('achievement_user_id','=',$ids[$k])
                        ->get();
                        foreach ($data_user as $item) {
                            $score[$i-1][$item->achievement_user_id] = $item->score;
                        }
                    } 
                }
            }
            $average[$i-1] = $avg_month;
            $max[$i-1] = $max_month;
            $min[$i-1] = $min_month;
        }
        $user = Auth::user();
        $staff = DB::table('master_users')->where('status','Aktif')
        ->whereIn('id',$ids)
        ->whereNotIn('position_id',[1,2,3])
        ->select(['id','name'])->paginate(10);
        return view('masterdata.achievement.resultlist',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'staff' => $staff,
            'score' => $score,
            'average' => $average,
            'max' => $max,
            'min' => $min
        ]);
    }
}
