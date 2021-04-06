<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Jenssegers\Agent\Agent;
use Asset\img\profile_photos;
// use Illuminate\Contracts\Auth\Guard;
class StaffAuthDashboardController extends Controller
{
    public function index(Request $request){
        
        if(Gate::denies('is_staff')){
            abort(403,'Staff must Login First');
        }
        else if(Gate::allows('is_staff')){
            $score = array();
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
            // dd($browser);
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
                'master_achievements.month',
                'master_users.profile_photo',
                'master_divisions.name as division_name'

            ])
            ->orderBy('score','desc')
            ->take(3)->get();
            // dd(count($current_month_achievement));
            
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
                'master_achievements.month',
                'master_users.profile_photo',
                'master_divisions.name as division_name'

            ])
            ->where('month',$before_current_month)
            ->where('year',$this_year)
            ->orderBy('score','desc')
            ->take(3)->get();

            $userCMAch = DB::table('master_achievements')
            ->leftjoin('master_users',
            'master_achievements.achievement_user_id','=','master_users.id')
            ->leftJoin('master_divisions',
            'master_users.division_id','=','master_divisions.id')
            ->select([
                'master_achievements.score',
                'master_achievements.month',
                'master_achievements.year',
                'master_users.name',
                'master_achievements.month',
                'master_users.profile_photo',
                'master_divisions.name as division_name'
            ])
            ->where('master_users.name',$user->name)
            ->where('year',$this_year)
            ->where('month',$current_month)->get();
            
            $userLMAch = DB::table('master_achievements')
            ->leftjoin('master_users',
            'master_achievements.achievement_user_id','=','master_users.id')
            ->leftJoin('master_divisions',
            'master_users.division_id','=','master_divisions.id')
            ->select([
                'master_achievements.score',
                'master_achievements.month',
                'master_achievements.year',
                'master_users.name',
                'master_achievements.month',
                'master_users.profile_photo',
                'master_divisions.name as division_name'

            ])
            ->where('master_users.name',$user->name)
            ->where('year',$this_year)
            ->where('month',$before_current_month)->get();


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
                    // //insert score matches month
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
                    $score[$i-1] = $temp[$i];
                } else {
                    $score[$i-1] = 0;
                }
            }
            $data_poster = DB::table('sliders')->get();
            $year_list = DB::table('master_achievements')->select('year')->distinct()->get();

            return view('dashboard.staff',[
                'data_poster'=>$data_poster,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'score'=>$score,
                'current_year'=>$this_year,
                'year_list'=>$year_list,
                'sum_of_eom'=>$sum_of_eom,
                'month_of_eom'=>$month_of_eom,
                'last_month_name'=>$before_current_month,
                'current_month_name'=>$current_month,
                'last_month'=>$before_current_month_achievement,
                'current_month'=>$current_month_achievement,
                'count_last_month_ach'=>$count_before_current_month_achievement,
                'count_current_month_ach'=>$count_current_month_achievement,
                'rankCM'=>$rankCurrentMonth,
                'rankLM'=>$rankLastMonth,
                'all_score'=>$sum_all_score,
                'user_lm'=>$userLMAch,
                'user_cm'=>$userCMAch
            ]);
        }
    }
    public function ajx(Request $request){
        $score = array();
        $sum_of_eom= 0;
        $month_of_eom = array();
        $year = $request->input('year');
        $user =Auth::user()->name;
        $id = Auth::user()->id;
        $sum_all_score = DB::table('master_achievements')
        ->leftjoin('master_users',
            'master_achievements.achievement_user_id','=','master_users.id')
        ->where('year',$year)
        ->where('name',$user)
        ->sum('score');
        for ($i = 1 ; $i<=12;$i++){
            $max_score=0;
            $data_month =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)->get();
            $data_month_user =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)
            ->where('achievement_user_id','=',$id)->get();
            
            if(count($data_month) == 0){
                $max_score=0;
                $temp[$i] = 0;
            } else {
                // //insert score matches month
                $temp[$i] = $data_month_user[0]->score;
                
                //search max
                for($j=0;$j<count($data_month);$j++){
                    $temp_max = $data_month[$j]->score;
                    if($temp_max>$max_score){
                        $max_score =$temp_max;
                    }
                }
                // if max score matches user score on that month
                if($max_score == $data_month_user[0]->score){
                    $month_of_eom[] = $data_month_user[0]->month;
                    $sum_of_eom++;
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
            'sum_of_eom'=>$sum_of_eom,
            'month_of_eom'=>$month_of_eom,
            'score' => $score,
            'all_score'=>$sum_all_score
        ]);
        }
    public function summarize_score(){
        
    }
    
    public function profile()
    {
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->where('id', '=', $data->division_id)->get();
        $positions = DB::table('master_positions')->where('id', '=', $data->position_id)->get();
        $roles = DB::table('master_roles')->where('id', '=', $data->role_id)->get();
        $shifts = DB::table('master_shifts')->where('id', '=', $data->shift_id)->get();

        return view('dashboard.profile',[
            'id' =>$data->id,
            'name'=> $data->name,
            'email'=> $data->email,
            'profile_photo'=> $data->profile_photo,
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts
            ]);
    }
    public function editprofile()
    {
        $data = Auth::user();
        $divisions = DB::table('master_divisions')->select('name as divisions_name','id as divisions_id')->get();
        $positions = DB::table('master_positions')->select('name as positions_name','id as positions_id')->get();
        $roles = DB::table('master_roles')->select('name as roles_name','id as roles_id')->get();
        $shifts = DB::table('master_shifts')->select('name as shifts_name','id as shifts_id')->get();

        return view('dashboard.editprofile',[
            'data' => $data,
            'divisions'=>$divisions,
            'positions'=>$positions,
            'roles'=>$roles,
            'shifts'=>$shifts
            ]);
    }
    public function updateprofile(Request $request, MasterUser $user)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'dob' => 'required',
            'phone_number' => 'numeric',
            'gender' => 'required',
            'email' => 'email',
            'password' => 'required'
        ]);
        MasterUser::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'dob' => $request->dob,
                'live_at' => $request->live_at,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'email' => $request->email,
                'profile_photo' => $request->profile_photo,
            ]);
            Alert::success('Berhasil!', 'Info profil anda berhasil di rubah!');
        return redirect('/staff/profile');
    }
    public function foto(Request $request)
    {
        $image = $request->image;

        $image_default = Auth::user()->profile_photo;
        if ($image_default != 'defaultL.jpg' || $image_default != 'defaultP.png') {
            $path_profile = 'img/profile-photos/'.$image_default;
            $file_path_profile = public_path($path_profile);
            DB::table('master_users')
            ->where('id', '=', Auth::user()->id)
            ->update(['profile_photo' => Auth::user()->name .'.png']);
        }

        $image_array_1 = explode(";", $image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $image_name = 'img/profile-photos/' . Auth::user()->name . '.png';
        file_put_contents($image_name, $data);

        $src = 'asset ' . $image_name;
    }
    
}
