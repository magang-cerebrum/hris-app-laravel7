<?php

namespace App\Http\Controllers;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Jenssegers\Agent\Agent;

class StaffAuthDashboardController extends Controller
{
    public function index(Request $request){
        
        if(Gate::denies('is_staff')){
            abort(403,'Staff must Login First');
        }
        else if(Gate::allows('is_staff')){
            $scorePerformance = array();
            $scoreAchievement = array();
            $sum_of_eom= 0;
            $user = Auth::user();
            $month_of_eom = array();
            $year = date('Y');
            $current_month = switch_month(date('m'));
            $before_current_month =switch_month(date('m',strtotime('-1 month')));
            $this_year = date('Y');
            $user = Auth::user(); 
            $device = new Agent();
            $browser = $device->platform();
            $actualEOM =DB::table('master_eoms')->where('user_id',Auth::user()->id)->get(); 
            //Achievement Data

            $sum_all_score = DB::table('master_achievements')
            ->leftjoin('master_users',
            'master_achievements.achievement_user_id','=','master_users.id')
            ->where('year',$year)
            ->where('name',Auth::user()->name)
            ->sum('score');

        $current_month_achievement =DB::table('master_achievements')
        ->leftjoin('master_users',
        'master_achievements.achievement_user_id','=','master_users.id')
        ->where('month',$current_month)
        ->where('year',$this_year)
        ->leftJoin('master_divisions',
        'master_users.division_id','=','master_divisions.id')
        ->select([
            'master_achievements.score',
            'master_achievements.month',
            'master_achievements.year',
            'master_users.name',
            'master_users.profile_photo',
            'master_divisions.name as division_name'

        ])
        ->where('master_divisions.id',Auth::user()->division_id)
        ->orderBy('score','desc')
        ->take(3)->get();
        
        $before_current_month_achievement =DB::table('master_achievements')
        ->leftjoin('master_users',
        'master_achievements.achievement_user_id','=','master_users.id')
        ->leftJoin('master_divisions',
        'master_users.division_id','=','master_divisions.id')
        ->select([
            'master_achievements.score',
            'master_achievements.month',
            'master_achievements.year',
            'master_users.name',
            'master_users.profile_photo',
            'master_divisions.name as division_name'

        ])
        ->where('month',$before_current_month)
        ->where('year',$this_year)
        ->orderBy('score','desc')
        ->take(3)->get();

        
        $positionLastMonth =DB::table('master_achievements')
        ->leftjoin('master_users',
        'master_achievements.achievement_user_id','=','master_users.id')
        ->where('month',$before_current_month)
        ->where('year',$this_year)
        ->orderBy('score','desc')
        ->get();
        
        $datrankLastMonth = $positionLastMonth->where('achievement_user_id','=',Auth::user()->id);
        $rankLastMonth = $datrankLastMonth->keys()->first()+1;
        
        $positionCurrentMonth= DB::table('master_achievements')
        ->leftjoin('master_users',
        'master_achievements.achievement_user_id','=','master_users.id')
        ->where('month',$current_month)
        ->where('year',$this_year)
        ->orderBy('score','desc')
        ->get();
        
        $datrankCurrentMonth = $positionCurrentMonth->where('achievement_user_id','=',Auth::user()->id);
        $rankCurrentMonth = $datrankCurrentMonth->keys()->first()+1;
        
        $count_current_month_achievement = count($current_month_achievement);
        $count_before_current_month_achievement = count($before_current_month_achievement);
        
        for ($i = 1 ; $i<=12;$i++){
            $max_score=0;
            $data_month =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)->get();
            $data_month_user =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)
            ->where('achievement_user_id','=',$user->id)->get();
            
            if(count($data_month) == 0){
                $max_score=0;
                $temp[$i] = 0;
            } else {
                // insert score matches month
                foreach($data_month_user as $dmu){
                    $temp[$i] = $dmu->score;
                }
                
                
                //search max
                for($j=0;$j<count($data_month);$j++){
                    $temp_max = $data_month[$j]->score;
                    if($temp_max>$max_score){
                        $max_score =$temp_max;
                    }
                }
                // if max score matches user score on that month
                foreach($data_month_user as $dmu){
                    if($max_score == $dmu->score){
                        $month_of_eom[] = $dmu->month;
                        $sum_of_eom++;
                    }  

                }
            }
            // if score on a month exists, insert too score array
            if (array_key_exists($i,$temp)) {
                $scoreAchievement[$i-1] = $temp[$i];
            } else {
                $scoreAchievement[$i-1] = 0;
            }
            // dd($scoreAchievement);
        }
        $data_poster = DB::table('sliders')->get();
        $year_list_achievement = DB::table('master_achievements')->select('year')->distinct()->get();

            //Performace Data
            $sum_all_score_performance = DB::table('master_performances')
                ->leftjoin('master_users',
                    'master_performances.user_id','=','master_users.id')
                ->where('year',$year)
                ->where('name',Auth::user()->name)
                ->sum('performance_score');

            $current_month_performance =DB::table('master_performances')
            ->leftjoin('master_users',
            'master_performances.user_id','=','master_users.id')
            ->where('month',$current_month)
            ->where('year',$this_year)
            ->leftJoin('master_divisions',
            'master_users.division_id','=','master_divisions.id')
            ->select([
                'master_performances.performance_score',
                'master_performances.month',
                'master_performances.year',
                'master_users.name',
                'master_users.profile_photo',
                'master_divisions.name as division_name'

            ])
            ->where('master_divisions.id',Auth::user()->division_id)
            ->orderBy('performance_score','desc')
            ->take(3)->get();

            $before_current_month_performance =DB::table('master_performances')
            ->leftjoin('master_users',
            'master_performances.user_id','=','master_users.id')
            ->leftJoin('master_divisions',
            'master_users.division_id','=','master_divisions.id')
            ->select([
                'master_performances.performance_score',
                'master_performances.month',
                'master_performances.year',
                'master_users.name',
                'master_users.profile_photo',
                'master_divisions.name as division_name'

            ])
            ->where('month',$before_current_month)
            ->where('year',$this_year)
            ->orderBy('performance_score','desc')
            ->take(3)->get();
            
            $positionLastMonthPerformances =DB::table('master_performances')
            ->leftjoin('master_users',
            'master_performances.user_id','=','master_users.id')
            ->where('month',$before_current_month)
            ->where('year',$this_year)
            ->orderBy('performance_score','desc')
            ->get();
            
            $datrankLastMonthPerformances = $positionLastMonthPerformances->where('user_id','=',Auth::user()->id);
            $rankLastMonthPerformances = $datrankLastMonthPerformances->keys()->first()+1;
            
            $positionCurrentMonthPerformance= DB::table('master_performances')
            ->leftjoin('master_users',
            'master_performances.user_id','=','master_users.id')
            ->where('month',$current_month)
            ->where('year',$this_year)
            ->orderBy('performance_score','desc')
            ->get();
            
            $datrankCurrentMonthPerformance = $positionCurrentMonthPerformance->where('user_id','=',Auth::user()->id);
            $rankCurrentMonthPerformance = $datrankCurrentMonthPerformance->keys()->first()+1;
            
            $count_current_month_performance = count($current_month_performance);
            $count_before_current_month_performance = count($before_current_month_performance);
            
            for ($k = 1 ; $k<=12;$k++){
                $max_score_performance=0;
                $data_month_Performance =DB::table('master_performances')
                ->where('month','=',switch_month($k/10 < 1 ? "0".$k : $k))->where('year',$year)->get();
                $data_month_user_Performance =DB::table('master_performances')
                ->where('month','=',switch_month($k/10 < 1 ? "0".$k : $k))->where('year',$year)
                ->where('user_id','=',$user->id)->get();
                
                if(count($data_month_Performance) == 0){
                    $max_score_performance=0;
                    $temp_performance[$k] = 0;
                } else {
                    // //insert score matches month
                    foreach($data_month_user_Performance as $dmup){
                        $temp_performance[$k] = $dmup->performance_score;
                    }
                    
                    
                    //search max
                    for($l=0;$l<count($data_month_Performance);$l++){
                        $temp_max_performance = $data_month_Performance[$l]->performance_score;
                        if($temp_max_performance>$max_score_performance){
                            $max_score_performance =$temp_max_performance;
                        }
                    }
                    // if max score matches user score on that month
                    foreach($data_month_user_Performance as $dmup){
                        if($max_score == $dmup->performance_score){
                            $month_of_eom[] = $dmup->month;
                            $sum_of_eom++;
                        }  

                    }
                }
                // if score on a month exists, insert too score array
                if (array_key_exists($k,$temp_performance)) {
                    $scorePerformance[$k-1] = $temp_performance[$k];
                } else {
                    $scorePerformance[$k-1] = 0;
                }
            }
            $data_poster = DB::table('sliders')->get();
            $year_list_performance = DB::table('master_performances')->select('year')->distinct()->get();
            
            return view('dashboard.staff',[
                'data_poster'=>$data_poster,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'scorePerformance'=>$scorePerformance,
                'scoreAchievement'=>$scoreAchievement,
                'current_year'=>$this_year,
                'year_list_performance'=>$year_list_performance,
                'year_list_achievement'=>$year_list_achievement,
                'sum_of_eom'=>$sum_of_eom,
                'month_of_eom'=>$month_of_eom,
                'last_month_name'=>$before_current_month,
                'current_month_name'=>$current_month,
                'last_month_performance'=>$before_current_month_performance,
                'current_month_performance'=>$current_month_performance,
                'count_last_month_perf'=>$count_before_current_month_performance,
                'count_current_month_perf'=>$count_current_month_performance,
                'count_current_month_ach'=>$count_current_month_achievement,
                'rankCMPerformance'=>$rankCurrentMonth,
                'rankLMPerformance'=>$rankLastMonthPerformances,
                'all_score_performance'=>$sum_all_score_performance,
                'all_score_achievements'=>$sum_all_score,
                // 'user_lmPerformance'=>$userLMPerf,
                // 'user_cmPerformance'=>$userCMPerf,
                'actualEomCount'=>count($actualEOM),
                'actualEom'=>$actualEOM,
                'current_month_achievement'=>$current_month_achievement,
                'before_current_month_achievement'=>$before_current_month_achievement
            ]);
        }
    }
    public function ajxperf(Request $request){
        //Performance
        $month_of_eom = array();
        $year = $request->input('year');
        $user =Auth::user()->name;
        $id = Auth::user()->id;
        $sum_all_score_performance = DB::table('master_performances')
        ->leftjoin('master_users',
                    'master_performances.user_id','=','master_users.id')
        ->where('year',$year)
        ->where('name',$user)
        ->sum('performance_score');
        for ($i = 1 ; $i<=12;$i++){
            $max_score_performance=0;
            $data_month_performance =DB::table('master_performances')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)->get();
            $data_month_user_performance =DB::table('master_performances')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)
            ->where('user_id','=',$id)->get();
            
            if(count($data_month_performance) == 0){
                $max_score_performance=0;
                $temp[$i] = 0;
            } else {
                // //insert score matches month
                $temp[$i] = $data_month_user_performance[0]->performance_score;
                
                //search max
                for($j=0;$j<count($data_month_performance);$j++){
                    $temp_max = $data_month_performance[$j]->performance_score;
                    if($temp_max>$max_score_performance){
                        $max_score =$temp_max;
                    }
                }
                // if max score matches user score on that month
                if($max_score_performance == $data_month_user_performance[0]->performance_score){
                    $month_of_eom[] = $data_month_user_performance[0]->month;
                    // $sum_of_eom++;
                }                
            }
            // if score on a month exists, insert too score array
            if (array_key_exists($i,$temp)) {
                $score[$i-1] = $temp[$i];
            } else {
                $score[$i-1] = 0;
            }
        }

        return response()
        ->json([
            'year'=>$year,
            // 'sum_of_eom'=>$sum_of_eom,
            'month_of_eom'=>$month_of_eom,
            'performance_score' => $score,
            'all_score'=>$sum_all_score_performance
        ]);
        }

    public function ajxAch(Request $request){
        $user =Auth::user()->name;
        $id = Auth::user()->id;
        $yearach = $request->input('yearach');
        // dd($yearach);
        $month_of_eom = array();
        $sum_all_score = DB::table('master_achievements')
        ->leftjoin('master_users',
            'master_achievements.achievement_user_id','=','master_users.id')
        ->where('year',$yearach)
        ->where('name',$user)
        ->sum('score');
        for ($k = 1 ; $k<=12;$k++){
            $max_score=0;
            $data_month =DB::table('master_achievements')
            ->where('month','=',switch_month($k/10 < 1 ? "0".$k : $k))->where('year',$yearach)->get();
            $data_month_user =DB::table('master_achievements')
            ->where('month','=',switch_month($k/10 < 1 ? "0".$k : $k))->where('year',$yearach)
            ->where('achievement_user_id','=',$id)->get();
            
            if(count($data_month) == 0){
                $max_score=0;
                $temp[$k] = 0;
            } else {
                // //insert score matches month
                $temp[$k] = $data_month_user[0]->score;
                
                //search max
                for($l=0;$l<count($data_month);$l++){
                    $temp_max = $data_month[$l]->score;
                    if($temp_max>$max_score){
                        $max_score =$temp_max;
                    }
                }
                // if max score matches user score on that month
                if($max_score == $data_month_user[0]->score){
                    $month_of_eom[] = $data_month_user[0]->month;
                    // $sum_of_eom++;
                }                
            }
            // if score on a month exists, insert too score array
            if (array_key_exists($k,$temp)) {
                $scoreAch[$k-1] = $temp[$k];
            } else {
                $scoreAch[$k-1] = 0;
            }
        }

        return response()
        ->json([
            'year'=>$yearach,
            // 'sum_of_eom'=>$sum_of_eom,
            // 'month_of_eom'=>$month_of_eom,
            'scoreAch' => $scoreAch,
            'all_score'=>$sum_all_score
        ]);
    }
  
        
    
    
    public function profile()
    {
        if(Gate::denies('is_staff')){
            return redirect('/admin/profile');
        };
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->where('id', '=', $data->division_id)->get();
        $positions = DB::table('master_positions')->where('id', '=', $data->position_id)->get();
        $roles = DB::table('master_roles')->where('id', '=', $data->role_id)->get();

        return view('dashboard.profile',[
            'id' =>$data->id,
            'name'=> $data->name,
            'email'=> $data->email,
            'profile_photo'=> $data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles
            ]);
    }
    public function editprofile()
    {
        if(Gate::denies('is_staff')){
            return redirect('/admin/profile/edit');
        };
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();

        return view('dashboard.editprofile',[
            'id' =>$data->id,
            'name'=> $data->name,
            'email'=> $data->email,
            'profile_photo'=> $data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles
        ]);
    }
    public function updateprofile(Request $request, MasterUser $user)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'address' => 'required|max:200',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
        ]);
        MasterUser::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'dob' => $request->dob,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
                'credit_card_number' => $request->credit_card_number
            ]);
        Alert::success('Berhasil!', 'Info profil anda berhasil di rubah!');
        return redirect('/staff/profile');
    }
    
}
