<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.salary.search',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function list_data(Request $request)
    {
        if(Auth::check()){
            $month = explode('-',$request->periode)[1];
            $year = explode('-',$request->periode)[0];
    
            $data = DB::table('master_salaries')
            ->leftJoin('master_users','master_salaries.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('month',$month)
            ->where('year',$year)
            ->select([
                'master_salaries.*',
                'master_users.name as user_name',
                'master_users.nip as nip',
                'master_divisions.name as division',
                'master_positions.name as position'
            ])
            ->get();
                
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN , $month, $year);
            $date = date($year.'-'.$month.'-'.$jumlah_hari);
            $next_day = date('Y-m-d', strtotime('+1 days', strtotime($date)));
    
            $bool_check_day = $next_day <= date('Y-m-d');
    
            return view('masterData.salary.list', [
                'data' => $data,
                'month' => $month,
                'year' => $year,
                'bool_check_day' => $bool_check_day,
                'next_date' => explode('-',$next_day)[2].'-'.explode('-',$next_day)[1].'-'.explode('-',$next_day)[0]
            ]);
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function index_staff()
    {
        if(Auth::check()){
            $user = Auth::user();
            $data = DB::table('master_salaries')
            ->leftJoin('master_users','master_salaries.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->where('user_id',$user->id)
            ->select([
                'master_salaries.*',
                'master_users.name as user_name',
                'master_users.nip as nip',
                'master_divisions.name as division',
                'master_positions.name as position'
            ])
            ->get();
    
            return view('staff.salary.list', [
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id,
                'data' => $data
            ]);
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function get_salary(Request $request)
    {
        if(Auth::check()){
            global $month;
            global $year;
            $day = date('j');
            $month = $request->month;
            $year = $request->year;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    
            $data_check_presence = DB::table('master_presences')
            ->leftJoin('master_users','master_presences.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->where('master_presences.check_chief', 0)
            ->where('presence_date', 'LIKE', $year.'-'.$month.'%')
            ->groupBy('master_divisions.name')
            ->select(['master_divisions.name as name'])->get();
    
            if(count($data_check_presence) != 0) {
                $error_division = array();
                for ($i=0; $i < count($data_check_presence); $i++) { 
                    $error_division[$i] = $data_check_presence[$i]->name;
                }
                Alert::error('Error!', "Masih terdapat presensi yang belum di cek oleh Chief di Divisi : " . implode(', ',$error_division) . "!")->width(600);
                return back();
            }
            else {
                $data_presences = DB::table('master_presences')
                ->where('presence_date', 'LIKE', $year.'-'.$month.'%')
                ->where('status', 0)->get();
        
                while (count($data_presences) > 0) {
                    $data_presences_by_user_id = DB::table('master_presences')
                    ->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->first();
    
                    global $user_id;
                    $user_id = $data_presences_by_user_id->user_id;
    
                    $default_schedule = DB::table('master_job_schedules')->where('month',switch_month($month))->where('year',$year)->where('user_id',$user_id)->first();
                   
                    $total_work_time = [ 0, 0, 0 ];
                    $total_late_time = [ 0, 0, 0 ];
                    $total_fine = 0;
                    $absen = 0;
                    $sick = 0;
                    $paid_leave = 0;
    
                    for ($x = 1; $x <= $days_in_month; $x++) {
                        $data_user = DB::table('master_presences')
                        ->where('user_id',$user_id)->where('presence_date', $year.'-'.$month.'-'.($x / 10 < 1 ? '0'.$x : $x))
                        ->where('status', 0)->first();
    
                        if ($data_user) {
                            $work_hour = date('H', strtotime($data_user->inaday_time));
                            $work_minute = date('i', strtotime($data_user->inaday_time));
                            $work_seconds = date('s', strtotime($data_user->inaday_time));
                            $late_hour = date('H', strtotime($data_user->late_time));
                            $late_minute = date('i', strtotime($data_user->late_time));
                            $late_seconds = date('s', strtotime($data_user->late_time));
            
                            $total_work_time[0] += $work_hour;
                            $total_work_time[1] += $work_minute;
                            $total_work_time[2] += $work_seconds;
                            $total_late_time[0] += $late_hour;
                            $total_late_time[1] += $late_minute;
                            $total_late_time[2] += $late_seconds;
            
                            $total_fine += $data_user->fine;
                            DB::table('master_presences')->where('id',$data_user->id)->update(['status'=>1]);
                        }
                        else {
                            $temp_shift = 'shift_'.$x;
                            $shift_user = $default_schedule->$temp_shift;
    
                            if ($shift_user != 'Off' && $shift_user != 'Cuti' && $shift_user != 'Sakit') {
                                $absen++;
                            }
                            else if ($shift_user == 'Sakit') {
                                $sick++;
                            }
                            else if ($shift_user == 'Cuti') {
                                $paid_leave++;
                            }
                        }
                    }
        
                    if ( $total_work_time[2] >= 60 ) {
                        $total_work_time[1] += intval($total_work_time[2]/60);
                        $total_work_time[2] = intval($total_work_time[2]%60);
                    }
                    if ( $total_work_time[1] >= 60 ) {
                        $total_work_time[0] += intval($total_work_time[1]/60);
                        $total_work_time[1] = intval($total_work_time[1]%60);
                    }
        
                    if ( $total_late_time[2] >= 60 ) {
                        $total_late_time[1] += intval($total_late_time[2]/60);
                        $total_late_time[2] = intval($total_late_time[2]%60);
                    }
                    if ( $total_late_time[1] >= 60 ) {
                        $total_late_time[0] += intval($total_late_time[1]/60);
                        $total_late_time[1] = intval($total_late_time[1]%60);
                    }
                    
                    $master_user = DB::table('master_users')->where('id',$user_id)->first();
        
                    $cut_salary = DB::table('master_salary_cuts')
                    ->where('type','Semua')
                    ->orWhere(function($query) {
                        global $user_id;
                        global $month;
                        global $year;
                        $query->where('user_id',$user_id)
                              ->where('month',$month)
                              ->where('year',$year);
                    })
                    ->get();
                    $total_cut_salary = 0;
        
                    foreach($cut_salary as $item_cut) {
                        $total_cut_salary += $item_cut->nominal;
                    }
        
                    $allowance_salary = DB::table('master_salary_allowances')
                    ->where('type','Semua')
                    ->orWhere(function($query) {
                        global $user_id;
                        global $month;
                        global $year;
                        $query->where('user_id',$user_id)
                              ->where('month',$month)
                              ->where('year',$year);
                    })
                    ->get();
                    $total_allowance_salary = 0;
        
                    foreach($allowance_salary as $item_allowance) {
                        $total_allowance_salary += $item_allowance->nominal;
                    }
        
                    $total_salary = $master_user->salary - $total_cut_salary + $total_allowance_salary - $total_fine;
        
                    DB::table('master_salaries')->insert([
                        'user_id'=>$user_id,
                        'month'=>$month,
                        'year'=>$year,
                        'total_default_hour'=>$default_schedule->total_hour,
                        'total_work_time'=>$total_work_time[0].":".$total_work_time[1].":".$total_work_time[2],
                        'total_late_time'=>$total_late_time[0].":".$total_late_time[1].":".$total_late_time[2],
                        'total_absen'=>$absen,
                        'total_sick'=>$sick,
                        'total_paid_leave'=>$paid_leave,
                        'total_fine'=>$total_fine,
                        'default_salary'=>$master_user->salary,
                        'total_salary_cut'=>$total_cut_salary,
                        'total_salary_allowance'=>$total_allowance_salary,
                        'total_salary'=>$total_salary,
                        'file_salary'=>null,
                        'status'=>"Pending"
                    ]);
        
                    $data_presences = DB::table('master_presences')->where('presence_date', 'LIKE', $year.'-'.$month.'%')->where('status', 0)->get();
                }
                Alert::success('Berhasil!','Data gaji periode '. switch_month($month) . ' - ' . $year . ' berhasil di ambil!')->width(600);
                return redirect('/admin/salary');
            }
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function create_slip(Request $request)
    {
        if(Auth::check()){
            $ids = $request->input('check');
            $data_type_cut = DB::table('master_cut_allowance_types')->where('category','Potongan')->get();
            $data_type_allowance = DB::table('master_cut_allowance_types')->where('category','Tunjangan')->get();
            $day = date('j');
            $month = date('m');
            $year = date('Y');
    
            foreach( $ids as $id ) {
                $data = DB::table('master_salaries')->where('id',$id)->first();
    
                $master_user = DB::table('master_users')
                ->where('master_users.id',$data->user_id)
                ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
                ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
                ->select(
                    'master_users.name as name',
                    'master_divisions.name as division',
                    'master_positions.name as position',
                )
                ->first();
    
                $data_cut = array();
                $data_allowance = array();
    
                array_push($data_allowance, object_array_salary('Gaji Pokok', $data->default_salary));
    
                $data_overtime = DB::table('master_overtimes')
                ->where('user_id', $data->user_id)
                ->where('month', $data->month)->where('year', $data->year)
                ->first();
                if ($data_overtime) {
                    array_push($data_allowance, object_array_salary('Lembur', $data_overtime->payment));
                    DB::table('master_overtimes')->where('id', $data_overtime->id)->update(['status'=>'Paid']);
                }
                else {
                    array_push($data_allowance, object_array_salary('Lembur'));
                }
    
                array_push($data_cut, object_array_salary('Denda Keterlambatan', $data->total_fine));
    
                foreach($data_type_cut as $cut_type) {
                    if($cut_type->type == 'Semua') {
                        $get_data_cut = DB::table('master_salary_cuts')->where('information', $cut_type->name)->first();
                        if($get_data_cut) {
                            $value_data = object_array_salary($get_data_cut->information, $get_data_cut->nominal);
                        }
                        else {
                            $value_data = object_array_salary($cut_type->name);
                        }
                    }
                    else {
                        $get_data_cut = DB::table('master_salary_cuts')
                        ->where('information', $cut_type->name)
                        ->where('user_id', $data->user_id)
                        ->where('month', switch_month($month))->where('year', $year)
                        ->first();
                        if($get_data_cut) {
                            $value_data = object_array_salary($get_data_cut->information, $get_data_cut->nominal);
                        }
                        else {
                            $value_data = object_array_salary($cut_type->name);
                        }
                    }
                    array_push($data_cut, $value_data);
                }
    
                foreach($data_type_allowance as $allowance_type) {
                    if($cut_type->type == 'Semua') {
                        $get_data_allowance = DB::table('master_salary_allowances')->where('information', $allowance_type->name)->first();
                        if($get_data_allowance) {
                            $value_data = object_array_salary($get_data_allowance->information, $get_data_allowance->nominal);
                        }
                        else {
                            $value_data = object_array_salary($allowance_type->name);
                        }
                    }
                    else {
                        $get_data_allowance = DB::table('master_salary_allowances')
                        ->where('information', $allowance_type->name)
                        ->where('user_id', $data->user_id)
                        ->where('month', switch_month($month))->where('year', $year)
                        ->first();
                        if($get_data_allowance) {
                            $value_data = object_array_salary($get_data_allowance->information, $get_data_allowance->nominal);
                        }
                        else {
                            $value_data = object_array_salary($allowance_type->name);
                        }
                    }
                    array_push($data_allowance, $value_data);
                }
    
                $total_cut_salary = 0;
                $total_allowance_salary = 0;
    
                foreach($data_cut as $cut) {
                    $total_cut_salary += $cut->value;
                }
    
                foreach($data_allowance as $allowance) {
                    $total_allowance_salary += $allowance->value;
                }
    
                $total_salary = $total_allowance_salary - $total_cut_salary;
                $string_total_salary = terbilang($total_salary);
    
                $pdf = PDF::loadView('/pdf.salary', [
                    'day'=>$day,
                    'month'=>switch_month($month),
                    'year'=>$year,
                    'data_staff'=>$master_user,
                    'data_cut'=>$data_cut,
                    'data_allowance'=>$data_allowance,
                    'total_salary_cut'=>$total_cut_salary,
                    'total_salary_allowance'=>$total_allowance_salary,
                    'total_salary'=>$total_salary,
                    'string_salary'=>$string_total_salary
                ]);
                $file_output = $pdf->output();
                $file_name = $year.'_'.$month.'_'.$master_user->name.'.pdf';
                $file_patch = 'file_slip/'.$file_name;
                file_put_contents($file_patch, $file_output);
                DB::table('master_salaries')->where('id',$id)->update(['status'=>'Accepted', 'file_salary'=>$file_name]);
            }
            Alert::success('Berhasil!','Slip gaji staff terpilih berhasil di cetak!');
            return redirect('/admin/salary');
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function reset_salary()
    {
        if(Auth::check()){
            DB::table('master_presences')->update(['status'=>0]);
            return redirect('/admin/salary');
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit($id)
    {
        if(Auth::check()){
            $user = Auth::user();
            $data = DB::table('master_salaries')->where('master_salaries.id',$id)
            ->leftJoin('master_users','master_salaries.user_id','=','master_users.id')
            ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
            ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
            ->select([
                'master_salaries.*',
                'master_users.name as name',
                'master_divisions.name as division',
                'master_positions.name as position'
            ])->first();
    
            return view('masterData.salary.edit',[
                'data'=>$data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::check()){
            DB::table('master_salaries')->where('id', $id)->update([
                'total_fine'=>$request->total_fine,
                'total_salary'=>$request->total_salary
            ]);
    
            return redirect('/admin/salary');
        }
        else {
            Alert::info('Sesi berakhir!'.'Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
