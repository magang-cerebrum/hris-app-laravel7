<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterPerformance;
use App\MasterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PerformanceController extends Controller
{
    //
    public function indexChief(){
        $user = Auth::user();
        // dd(MasterPerformance::get());
        return view('staff.performance-chief.chiefLeaderboard',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
 
            ]);
    }

    public function ChiefSearch(Request $request){
        $user = Auth::user();
         // dd(MasterPerformance::where('division_id',Auth::user()->division_id)->get());
         $splitter = explode('/',$request->get('query'));
         $data = MasterPerformance::where(['month'=>$splitter[0],
         'year'=>$splitter[1]])
         ->leftjoin('master_users',
         'master_performances.user_id','=','master_users.id')
         ->where('master_performances.division_id',$user->division_id)
         ->orderBy('performance_score','desc')
         // ->where('position_id','=',11)
         ->get();
         // dd($data->avg('performance_score'));
         $is_champ = MasterPerformance::where(['month'=>$splitter[0],
         'year'=>$splitter[1]])->max('performance_score');
         // dd(count($is_champ));
         $count = count($data);
         // dd($data);
         return view('staff.performance-chief.ChiefSearchResult',['data'=>$data,
         'count'=>$count,
         'employee_of_the_month' =>$is_champ
         ]);
         
         
     }
     public function pickDateResult(Request $request){
        $user = Auth::user();
        $userAvailable = array();
        $data = DB::table('master_users')
            ->where('status','=','Aktif')
            ->where('division_id',$user->division_id)
            ->where('position_id','=',11)
            ->select('id')
            ->get();

        $month = $request->periode;
        $explodeMonth = explode('/',$month);
        $dataPerfMonth = MasterPerformance::where('month',$explodeMonth[0])
        ->where('year',$explodeMonth[1])
        ->select('user_id')
        ->get();

        foreach($dataPerfMonth as $items){
            foreach($data as $datausers){
                if($items->user_id == $datausers->id){
                    $userAvailable[]=$items->user_id;
                }
            }
        }
            $datas = MasterUser::whereNotIn('id',$userAvailable)
            ->where('status','=','Aktif')
                ->where('division_id',$user->division_id)
                ->where('position_id','=',11)
            ->select([
                'name','id','division_id'
            ])->get();
        
            return response()->json([
                'data'=>$datas,
                'countData'=>count($datas)
            ]);


     }
public function chiefScoring(){
                $user = Auth::user();
                $datas = DB::table('master_users')
                ->where('status','=','Aktif')
                ->where('division_id',$user->division_id)
                ->where('position_id','=',11)
                // ->select('id')
                ->get();
                return view('staff.performance-chief.Chiefscoring',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'data'=>$datas,
                // 'countData'=>$countData
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
            $divId = 'division_id_'.$i;
            $dataDivId = $datas->$divId;
            $data = $datas->$score;
            $split = explode('/',$datas->get('date'));
                if ($data == 0) {continue;}
                    MasterPerformance::create([
                        'performance_score' => $data,
                        'month'  =>$split[0],
                        'year' =>$split[1] ,
                        'division_id'=>$dataDivId,
                        'user_id'=>$data_id
                        ]);
                        
                
            
        }
        $average = MasterPerformance::where('division_id',Auth::user()->division_id)
        ->where('month',$split[0])
        ->where('year',$split[1])
        ->avg('performance_score');
        $chief_user_id = MasterUser::where('division_id',Auth::user()->division_id)
        ->where('position_id','!=',11)
        ->select('id')->get();
        // dd($chief_user_id);
        if(count($chief_user_id)>1){
            foreach($chief_user_id as $chief_id){
                MasterPerformance::create([
                    'performance_score'=>round($average,1),
                    'month'  =>$split[0],
                    'year' =>$split[1],
                    'division_id'=>Auth::user()->division_id,
                    'user_id'=>$chief_id->id
                ]);
            }
            
        }
        else{
            MasterPerformance::create([
                'performance_score'=>round($average,1),
                'month'  =>$split[0],
                'year' =>$split[1],
                'division_id'=>Auth::user()->division_id,
                'user_id'=>$chief_user_id[0]->id
            ]);
        }
        // dd($average);
        Alert::success('Berhasil!', 'Nilai untuk penghargaan periode bulan ' . switch_month($split[0]) . ' tahun ' . $split[1] . ' berhasil ditambahkan!');
        return redirect('/staff/performance/scoring');
}

public function chief_chart_index(){
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
        $x=($i / 10 < 1 ? '0'. $i : $i);
        $data_month = MasterPerformance::
        leftJoin('master_users','master_performances.user_id','=','master_users.id')
        ->where('month', $x)
        ->where('year',date('Y'))
        ->select([
            'master_performances.*'
        ])
        ->where('master_performances.division_id',Auth::user()->division_id)
        ->where('master_users.position_id',11)
        ->get();
        if (count($data_month) == 0) {
            $sum_month = 0;
            $avg_month = 0;
            $max_month = 0;
            $min_month = 0;
        } else {
            //find average
            for ($j=0; $j < count($data_month); $j++) { 
                $sum_month += $data_month[$j]->performance_score;
            }
            $avg_month = $sum_month / count($data_month);
            //find max
            for ($j=0; $j < count($data_month); $j++) { 
                $temp_score = $data_month[$j]->performance_score;
                if ($temp_score > $max_month) {
                    $max_month = $temp_score;
                }
            }
            //find min
            for ($j=0; $j < count($data_month); $j++) { 
                $temp_score = $data_month[$j]->performance_score;
                if ($temp_score < $min_month) {
                    $min_month = $temp_score;
                }
            }
            //insert score matches month
            for ($j=0; $j < count($data_month); $j++) {                    
                $usernya = $data_month[$j]->user_id;
                $data_user = MasterPerformance::
                where('month','=',$i / 10 < 1 ? '0'. $i : $i)
                ->where('year','=',date('Y'))
                ->where('user_id','=',$usernya)
                ->get();
                foreach ($data_user as $item) {
                    $score[$i-1][$item->user_id] = $item->performance_score;
                }
            }
        }
        $average[$i-1] = $avg_month;
        $max[$i-1] = $max_month;
        $min[$i-1] = $min_month;
    }
    
    // dd($average);
    $staff = DB::table('master_users')->where('status','Aktif')
    ->where('division_id',$user->division_id)
    ->whereNotIn('position_id',[1,2,3])
    ->select(['id','name'])->paginate(10);
    return view('staff.performance-chief.Chieflistchart',[
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


public function Chiefsearchlist (Request $request){
    if ($request->get('query') == null) {return redirect('/staff/performance/charts');}
    $user = Auth::user();
    $check_user = DB::table('master_users')->select(['id','name'])
    ->whereRaw("name LIKE '%" . $request->get('query') . "%'")
    ->where('status','Aktif')
    ->where('division_id',$user->division_id)
    ->get();
    foreach ($check_user as $item){
        $ids[] = $item->id;
    }

    $score = array();
    $average = array();
    $max = array();
    $min = array();

    for ($i=1; $i <= 12; $i++) {
        $sum_month = 0;
        $avg_month = 0;
        $max_month = 0;
        $min_month = 100;
        $data_month = MasterPerformance::
        where('month','=', $i / 10 < 1 ? '0'. $i : $i)
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
                $sum_month += $data_month[$j]->performance_score;
            }
            $avg_month = $sum_month / count($data_month);
            //find max
            for ($j=0; $j < count($data_month); $j++) { 
                $temp_score = $data_month[$j]->performance_score;
                if ($temp_score > $max_month) {
                    $max_month = $temp_score;
                }
            }
            //find min
            for ($j=0; $j < count($data_month); $j++) { 
                $temp_score = $data_month[$j]->performance_score;
                if ($temp_score < $min_month) {
                    $min_month = $temp_score;
                }
            }
            //insert score matches month
            for ($j=0; $j < count($data_month); $j++) {
                for ($k=0; $k < count($ids); $k++) { 
                    $data_user = MasterPerformance::
                    where('month','=',$i / 10 < 1 ? '0'. $i : $i)
                    ->where('year','=',date('Y'))
                    ->where('user_id','=',$ids[$k])
                    ->get();
                    foreach ($data_user as $item) {
                        $score[$i-1][$item->user_id] = $item->performance_score;
                    }
                } 
            }
        }
        $average[$i-1] = $avg_month;
        $max[$i-1] = $max_month;
        $min[$i-1] = $min_month;
    }
    
    $staff = DB::table('master_users')->where('status','Aktif')
    ->whereIn('id',$ids)
    ->whereNotIn('position_id',[1,2,3])
    ->select(['id','name'])->paginate(10);
    return view('staff.performance-chief.ChiefResultList',[
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
