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
        if(Auth::check()){
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
                $current_month = date('m');
                $before_current_month =date('m',strtotime('-1 month'));
                $this_year = date('Y');
                $user = Auth::user(); 
                // $device = new Agent();
                $actualEOM =DB::table('master_eoms')->where('user_id',Auth::user()->id)->get(); 
                //Achievement Data
    
                $sum_all_score = DB::table('master_achievements')
                ->leftjoin('master_users',
                'master_achievements.achievement_user_id','=','master_users.id')
                ->where('year',$year)
                ->where('name',Auth::user()->name)
                ->sum('score');
    
            
            for ($i = 1 ; $i<=12;$i++){
                $max_score=0;
                $data_month =DB::table('master_achievements')
                ->where('month','=',$i/10 < 1 ? "0".$i : $i)->where('year',$year)->get();
                $data_month_user =DB::table('master_achievements')
                ->where('month','=',$i/10 < 1 ? "0".$i : $i)->where('year',$year)
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
    
                
                $latestPeriodPerformances = DB::table('master_performances')
                ->select('month','year')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->first();
                // dd($latestPeriodPerformances);
                $monthDecidePerformance = null;
                if($latestPeriodPerformances){
                    $monthDecidePerformance = DB::table('master_performances')
                    ->leftjoin('master_users',
                    'master_performances.user_id','=','master_users.id')
                    ->where('month',$latestPeriodPerformances->month)
                    ->where('year',$latestPeriodPerformances->year)
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
                    ->get();
                    
                    
                }
                
                $latestPeriodAchievement = DB::table('master_achievements')
                ->select('month','year')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->first();
                // dd($latestPe);
                $monthDecideAchievement = null;
    
                if($latestPeriodAchievement){
                    $monthDecideAchievement = DB::table('master_achievements')
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
                    ->where('month',$latestPeriodAchievement->month)
                    ->where('year',$latestPeriodAchievement->year)
                    ->orderBy('score','desc')
                    ->get();
                }
    
                // dd($monthDecideAchievement->take(3));
                
                for ($k = 1 ; $k<=12;$k++){
                    $max_score_performance=0;
                    $data_month_Performance =DB::table('master_performances')
                    ->where('month','=',$k/10 < 1 ? "0".$k : $k)->where('year',$year)->get();
                    $data_month_user_Performance =DB::table('master_performances')
                    ->where('month','=',$k/10 < 1 ? "0".$k : $k)->where('year',$year)
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
                            if($max_score_performance == $dmup->performance_score){
                                $month_of_eom[] = $dmup->month;
                                // $sum_of_eom++;
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
                
    
                $staff_late = DB::table('master_salaries')
                ->leftjoin('master_users','master_salaries.user_id','=','master_users.id')
                ->leftjoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->orderBy('year', 'desc')->orderBy('month', 'desc')
                ->orderBy('total_late_time', 'asc')
                ->select([
                    'master_users.name as name',
                    'master_divisions.name as division',
                    'master_users.profile_photo as photo',
                    'master_salaries.total_late_time as late',
                    'master_salaries.month as month',
                    'master_salaries.year as year',
                ])->first();
    
                $staff_min_late = DB::table('master_salaries')
                ->leftjoin('master_users','master_salaries.user_id','=','master_users.id')
                ->leftjoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->orderBy('year', 'desc')->orderBy('month', 'desc')
                ->orderBy('total_late_time', 'desc')
                ->select([
                    'master_users.name as name',
                    'master_divisions.name as division',
                    'master_users.profile_photo as photo',
                    'master_salaries.total_late_time as late',
                    'master_salaries.month as month',
                    'master_salaries.year as year',
                ])->first();
    
                $eom = DB::table('master_eoms')
                ->leftjoin('master_users','master_eoms.user_id','=','master_users.id')
                ->leftjoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->orderBy('year', 'desc')->orderBy('month', 'desc')
                ->select([
                    'master_users.name as name',
                    'master_users.profile_photo as photo',
                    'master_divisions.name as division',
                    'master_eoms.month as month',
                    'master_eoms.year as year',
                ])->first();
    
                $data_presence = DB::table('master_presences')
                ->leftJoin('master_users','master_presences.user_id','=','master_users.id')
                ->where('master_users.division_id', $user->division_id)
                ->where('check_chief', 0)->get();
    
                $data_paid = DB::table('transaction_paid_leaves')
                ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
                ->whereIn('transaction_paid_leaves.status', ['Diajukan','Pending-Chief'])
                ->where('master_users.division_id', $user->division_id)
                ->select('transaction_paid_leaves.id')
                ->get();
    
                $data_wfh = DB::table('work_from_homes')
                ->leftJoin('master_users','work_from_homes.user_id','=','master_users.id')
                ->whereIn('work_from_homes.status', ['Diajukan','Pending-Chief'])
                ->where('master_users.division_id', $user->division_id)
                ->select('work_from_homes.id')
                ->get();
                    // dd($monthDecideAchievement);
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
                    'all_score_performance'=>$sum_all_score_performance,
                    'all_score_achievements'=>$sum_all_score,
                    'actualEomCount'=>count($actualEOM),
                    'actualEom'=>$actualEOM,
                    'monthDecidePerformance'=>$monthDecidePerformance,
                    'monthDecideAchievement'=>$monthDecideAchievement,
                    'staff_late'=>$staff_late,
                    'staff_min_late'=>$staff_min_late,
                    'eom'=>$eom,
                    'data_presence'=>$data_presence,
                    'data_paid_leave'=>$data_paid,
                    'data_wfh'=>$data_wfh,
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }    
    }

    public function ajxperf(Request $request){
        if(Auth::check()){
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
            for ($k = 1 ; $k<=12;$k++){
                $max_score=0;
                $data_month =DB::table('master_performances')
                ->where('month','=',$k/10 < 1 ? "0".$k : $k)->where('year',$year)->get();
                $data_month_user =DB::table('master_performances')
                ->where('month','=',$k/10 < 1 ? "0".$k : $k)->where('year',$year)
                ->where('user_id','=',$id)->get();
                // dd($data_month);
                if(count($data_month) == 0){
                    $max_score=0;
                    $temp[$k] = 0;
                } else {
                    // //insert score matches month
                    $temp[$k] = $data_month_user[0]->performance_score;
                    
                    //search max
                    for($l=0;$l<count($data_month);$l++){
                        $temp_max = $data_month[$l]->performance_score;
                        if($temp_max>$max_score){
                            $max_score =$temp_max;
                        }
                    }
                    // if max score matches user score on that month
                    if($max_score == $data_month_user[0]->performance_score){
                        $month_of_eom[] = $data_month_user[0]->month;
                        // $sum_of_eom++;
                    }                
                }
                // if score on a month exists, insert too score array
                if (array_key_exists($k,$temp)) {
                    $scorePerf[$k-1] = $temp[$k];
                } else {
                    $scorePerf[$k-1] = 0;
                }
            }
            return response()
            ->json([
                'year'=>$year,
                'count'=>count($data_month),
                // 'sum_of_eom'=>$sum_of_eom,
                'month_of_eom'=>$month_of_eom,
                'performance_score' => $scorePerf,
                'all_score'=>$sum_all_score_performance
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }    
    }

    public function ajxAch(Request $request){
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
    
    public function profile()
    {
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function editprofile()
    {
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function updateprofile(Request $request, MasterUser $user)
    {
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
    
}
