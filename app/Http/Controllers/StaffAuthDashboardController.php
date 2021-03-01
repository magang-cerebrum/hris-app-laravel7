<?php

namespace App\Http\Controllers;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class StaffAuthDashboardController extends Controller
{
    public function index(){
        // $lava = new Lavacharts;
        if(Gate::denies('is_staff')){
            return abort(403,'Staff must Login First');
        }
        else if(Gate::allows('is_staff')){
            // return 'Staff';
            $this_year = date('Y');
            $user = Auth::user(); 
            $data = DB::table('master_achievements')
            ->leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
            ->where('name','=',$user->name)->where('year','=',$this_year)
            ->get();
            $year_list = DB::table('master_achievements')->select('year')->distinct()->get();
            // dd($year_list[0]);
            
            return view('dashboard.staff',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'data'=>$data,
                'current_year'=>$this_year,
                'year_list'=>$year_list
            ]);
        }
    }
    public function ajx(Request $request){
        $sum_of_eom= 0;
        $month_of_eom = array();
        $year = $request->input('year');
        $user =Auth::user()->name;
        $id = Auth::user()->id;
//  dd($request->all());
        $charts_data = DB::table('master_achievements')
        ->leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
        ->where('year','=',$year)->where('name','=',$user)->get();
        
        for ($i = 1 ; $i<=12;$i++){
            $max_score=0;
            $data_month =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)->get();
            $data_month_user =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)
            ->where('achievement_user_id','=',$id)->get();
            // dd($data_month_user[0]->score);
            if(count($data_month) != 0 ){
                for($j=0;$j<count($data_month);$j++){
                    $temp = $data_month[$j]->score;
                    if($temp>$max_score){
                        $max_score =$temp;
                    }
                }
                if($max_score == $data_month_user[0]->score){
                    $month_of_eom[] = $data_month_user[0]->month;
                    $sum_of_eom++;
                }
                
            }
            
        }

        return response()->json(['data'=>$charts_data,
        'year'=>$year,
        'sum_of_eom'=>$sum_of_eom,
        'month_of_eom'=>$month_of_eom
        // 'data_month_user'=>$data_month_user,
        ]);
    }
    public function test(){
        $sum_of_eom= 0;
        $month_of_eom = array();
        
        $user = Auth::user()->id;
        $year = date('Y');
        for ($i = 1 ; $i<=12;$i++){
            $max_score=0;
            $data_month =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)->get();
            $data_month_user =DB::table('master_achievements')
            ->where('month','=',switch_month($i/10 < 1 ? "0".$i : $i))->where('year',$year)
            ->where('achievement_user_id','=',$user)->get();
            // dd($data_month_user[0]->score);
            if(count($data_month) != 0 ){
                for($j=0;$j<count($data_month);$j++){
                    $temp = $data_month[$j]->score;
                    if($temp>$max_score){
                        $max_score =$temp;
                    }
                }
                if($max_score == $data_month_user[0]->score){
                    $month_of_eom[] = $data_month_user[0]->month;
                    $sum_of_eom++;
                }
                
            }
            
        }
        dd($month_of_eom);
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
    
}
