<?php

namespace App\Http\Controllers;

use App\MasterAchievement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use App\MasterPerformance;
use App\MasterUser;

class MasterAchievementController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')){
            
            $user = Auth::user();
            $dataCurrent_Month = DB::table('master_achievements')->where('month',date('m'))->where('month',date('m'))->get();
            
            return view('masterData.achievement.leaderboard',[
                'menu'=>['m-pencapaian','s-pencapaian-leaderboard'],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'dataCM'=>$dataCurrent_Month,
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        } 
    }

   

    public function search(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                return abort(403,'Access Denied, Only Admin Can Access');
            }
            elseif(Gate::allows('is_admin')){
                $splitter = explode('/',$request->get('query'));
                $data = MasterAchievement::where(['month'=>$splitter[0], 'year'=>$splitter[1]])
                ->leftjoin('master_users','master_achievements.achievement_user_id','=','master_users.id')
                ->orderBy('score','desc')
                ->get();
                $is_champ = MasterAchievement::where(['month'=>$splitter[0], 'year'=>$splitter[1]])
                ->max('score');
                $count = count($data);
                return view('masterData.achievement.result',[
                    'menu'=>['',''],
                    'data'=>$data,
                    'count'=>$count,
                    'employee_of_the_month' =>$is_champ
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function scoring(){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')){
                $user = Auth::user();
                $data = DB::table('master_users')
                ->where('status','=','Aktif')
                ->where('division_id','!=',7)
                ->where('position_id','!=',[3])
                ->get();
                $dataCurrent_Month = DB::table('master_achievements')->where('month',date('m'))->where('month',date('m'))->get();
                return view('masterData.achievement.scoring',[
                    'menu'=>['m-pencapaian','s-pencapaian-penilaian'],
                    'name'=>$user->name,
                    'profile_photo'=>$user->profile_photo,
                    'email'=>$user->email,
                    'id'=>$user->id,
                    'data'=>$data,
                    'dataCM'=>$dataCurrent_Month,
                    // 'countDataCM'=>count($dataCurrent_Month)
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function scored (Request $request){
        if(Auth::check()){
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
                    ->where('month','=',$split[0])
                    ->where('achievement_user_id',$data_id)
                    ->get();
    
                    if ($data == 0) {continue;}
                    if(count($check) > 0){
                        foreach($check as $items){
                            MasterAchievement::where('id','=',$items->id)->update([
                                'score' => $data
                            ]);
                        }
                    } else {MasterAchievement::create([
                        'score' => $data,
                        'month'  =>$split[0],
                        'year' =>$split[1] ,
                        'achievement_user_id'=>$data_id
                    ]);
                    }
                }
                Alert::success('Berhasil!', 'Nilai untuk penghargaan periode bulan ' . switch_month($split[0]) . ' tahun ' . $split[1] . ' berhasil ditambahkan!');
                return redirect('/admin/achievement');
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

   

    public function admin_chart_index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
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
                        where('month','=',$i / 10 < 1 ? '0'. $i : $i)
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
            return view('masterData.achievement.listchart',[
                'menu'=>['m-pencapaian','s-pencapaian-grafik'],
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function searchlist(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            
            if ($request->get('query') == null) {return redirect('/admin/achievement/charts');}
            
            $check_user = DB::table('master_users')->select(['id','name'])
            ->whereRaw("name LIKE '%" . $request->get('query') . "%'")
            ->where('status','Aktif')
            ->whereNotIn('position_id',[1,2,3])
            ->get();
            foreach ($check_user as $item){$ids[] = $item->id;}
            if($check_user->isEmpty()){
                Alert::error('Data grafik tidak ditemukan!', 'Mohon maaf, pencarian data grafik "' . $request->get('query') . '" tidak ditemukan!');
                return redirect('admin/achievement/charts');
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
                $data_month = MasterAchievement::
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
                            where('month','=',$i / 10 < 1 ? '0'. $i : $i)
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
            return view('masterData.achievement.resultlist',[
                'menu'=>['m-pencapaian','s-pencapaian-grafik'],
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

   public function eom(){
       if(Auth::check()){
            if(Gate::denies('is_admin')){
                return abort(403,'Access Denied, Only Admin Can Access');
            }
                // $dataDate = date('m/Y');
                $user = Auth::user();
                $divisions = DB::table('master_divisions')
                ->whereNotIn('id',[7])
                ->get();
                $data = DB::table('master_users')
                ->whereNotIn('master_users.division_id',[7])
                ->leftjoin('master_achievements','master_users.id','=','master_achievements.achievement_user_id')
                ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->leftJoin('master_performances','master_users.id','=','master_performances.user_id')
                ->where('master_users.status','Aktif')
                ->where('master_divisions.status','Aktif')
                ->where('position_id','!=',[3])
                ->select('master_users.name as staff_name','master_users.id as staff_id','master_performances.performance_score','master_achievements.score as achievement_score','master_divisions.name as division_name','master_divisions.id as division_id')
                ->get();
                return view('masterData.achievement.eom',[
                    'menu'=>['m-pencapaian','s-pencapaian-eom'],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'data'=>$data,
                'divisions'=>$divisions
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function eom_search(Request $request){
        if(Auth::check()){
            $periodeRequest = explode('/',$request->periode) ;
            $divisions = DB::table('master_divisions')
            ->whereNotIn('id',[7])
            ->get();
            $data = DB::table('master_users')
            ->whereNotIn('master_users.division_id',[7])
            ->leftjoin('master_achievements','master_users.id','=','master_achievements.achievement_user_id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_performances','master_users.id','=','master_performances.user_id')
            ->where('master_users.status','Aktif')
            ->where('master_divisions.status','Aktif')
            ->where('position_id','!=',[3])
            // ->where('master_users.division_id','master_divisions.id')
            ->where('master_performances.month',$periodeRequest[0])
            ->where('master_achievements.month',$periodeRequest[0])
            ->where('master_performances.year',$periodeRequest[1])
            ->where('master_achievements.year',$periodeRequest[1])
            ->select('master_users.name as staff_name','master_users.id as staff_id','master_performances.performance_score','master_achievements.score as achievement_score','master_divisions.name as division_name','master_divisions.id as division_id')
           ->get();
    
           $month =$periodeRequest[0];
           $year = $periodeRequest[1];
           $checkEOM = DB::table('master_eoms')
           ->leftJoin('master_users','master_eoms.user_id','=','master_users.id')
           ->where('month',$month)
           ->where('year',$year)
           ->select('name as eom_holder','month','year')
           ->first();
        //    dd($checkEOM);
            return view('masterData.achievement.listedeom',[
                'menu'=>['',''],
                'data'=>$data,
                'divisions'=>$divisions,
                'month'=>$periodeRequest[0],
                'year'=>$periodeRequest[1],
                'countcheckEOM'=>($checkEOM ? true : false),
                'checkEOM'=>$checkEOM
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function chosedEom(Request $request){
        if(Auth::check()){
            $user_id = $request->radio_input_eom;
            $month = $request->month;
            $year = $request->year;
            $check = DB::table('master_eoms')
            ->where('month',$month)
            ->where('year',$year)->first();
            if($check){
                    DB::table('master_eoms')->where('id',$check->id)->update(['user_id'=>$user_id]);
                    Alert::success('Berhasil','Employee of the month berhasil diupdate!');
                
            }
            else{
                DB::table('master_eoms')->insert([
                    'user_id'=>$user_id,
                    'month'=>$month,
                    'year'=>$year
                ]);
                
                Alert::success('Berhasil','Employee of the month berhasil terpilih!');
            }
            return redirect('/admin/achievement/eom');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }


    public function pickDateResult(Request $request){
        if(Auth::check()){
            $userAvailable = array();
            $data = DB::table('master_users')
                ->where('master_users.status','=','Aktif')
                ->where('division_id','!=',7)
                ->where('position_id','!=',[3])
                ->select('master_users.id')
                ->get();

            $month = $request->periode;
            $explodeMonth = explode('/',$month);
            $dataAchMonth = MasterAchievement::where('month',$explodeMonth[0])
            ->where('year',$explodeMonth[1])
            ->select('achievement_user_id')
            ->get();
    
            foreach($dataAchMonth as $items){
                foreach($data as $datausers){
                    if($items->achievement_user_id == $datausers->id){
                        $userAvailable[]=$items->achievement_user_id;
                    }
                }
            }

            $datas = MasterUser::whereNotIn('master_users.id',$userAvailable)
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->where('master_users.status','=','Aktif')
            ->where('division_id','!=',7)
            ->where('position_id','!=',[3])
            ->select([
                'master_users.name as staff_name','master_users.id','division_id','master_divisions.name as division_name'
            ])
            ->orderBy('division_name','asc')
            ->get();
            
            return response()->json([
                'data'=>$datas,
                'countData'=>count($datas)
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
