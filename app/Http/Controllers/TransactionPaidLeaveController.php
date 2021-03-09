<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionPaidLeave;
use App\MasterLeaveType;
use App\MasterUser;
use App\AcceptedPaidLeave;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionPaidLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('transaction_paid_leaves')
        ->where('transaction_paid_leaves.status', '=', 'Diajukan')
        ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
        ->leftJoin('master_leave_types','transaction_paid_leaves.paid_leave_type_id','=','master_leave_types.id')
        ->select(
            'transaction_paid_leaves.*',
            'master_users.name as user_name',
            'master_users.nip as user_nip',
            'master_users.yearly_leave_remaining as user_laeve_remaining',
            'master_leave_types.name as type_name'
            )
        ->paginate(5);
        $user = Auth::user();
        
        return view('masterData.transactionleave.list', [
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function history()
    {
        $data = DB::table('transaction_paid_leaves')
        ->where('transaction_paid_leaves.status', '!=', 'Diajukan')
        ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
        ->leftJoin('master_leave_types','transaction_paid_leaves.paid_leave_type_id','=','master_leave_types.id')
        ->select(
            'transaction_paid_leaves.*',
            
            'master_users.name as user_name',
            'master_users.nip as user_nip',
            'master_users.yearly_leave_remaining as user_laeve_remaining',
            'master_leave_types.name as type_name'
            )
        ->paginate(5);
        $user = Auth::user();

        return view('masterData.transactionleave.history', [
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = MasterLeaveType::all();
        $user = Auth::user();
        return view('staff.transactionleave.create', [
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'left'=>$user->yearly_leave_remaining
        ]);
    }

    
    public function store(Request $request)
    {
        if ($request->paid_leave_type_id == 1) {
            $request->validate([
                'user_id'=>'required',
                'paid_leave_type_id'=>'required',
                'paid_leave_date_start'=>'required',
                'paid_leave_date_end'=>'required',
                'needs'=>'required'
            ]);
        } else {
            $request->validate([
                'user_id'=>'required',
                'paid_leave_type_id'=>'required',
                'paid_leave_date_start_defaulted'=>'required',
            ]);
        };

        $info = "-";
        $status = "Diajukan";
        $user = Auth::user();

        if($request->paid_leave_type_id == 1){
            $date_start = date('Y/m/d',strtotime($request->paid_leave_date_start));
            $date_end = date('Y/m/d',strtotime($request->paid_leave_date_end));
            $needs = $request->needs;
            $interval = (new DateTime($request->paid_leave_date_start))->diff(new DateTime($request->paid_leave_date_end));
        } else {
            $date_start = date('Y/m/d',strtotime($request->paid_leave_date_start_defaulted));
            if ($request->paid_leave_type_id == 2) {
                $date_end = date('Y/m/d',strtotime('+59 days',strtotime($date_start)));
            } elseif ($request->paid_leave_type_id == 3) {
                $date_end = date('Y/m/d',strtotime('+2 days',strtotime($date_start)));
            }
            $needs = "-";
            $interval = (new DateTime($date_start))->diff(new DateTime($date_end));
        }
        $paid_leave = ($interval->format('%a')) + 1;
        
        $start = date('Y/m/d', strtotime('-1 days', strtotime($date_start)));
        $days_paid_leave = 0;
        for ($i = 0; $i < $paid_leave; $i++) {
            $check_days = date('Y/m/d', strtotime('+1 days', strtotime($start)));
            $check_name_days = date('l', strtotime($check_days));

            $table_schedule = DB::table('master_job_schedules')
            ->where('user_id', '=', $request->user_id)
            ->where('month', '=', switch_month(date('m', strtotime($check_days))))
            ->where('year', '=', date('Y', strtotime($check_days)))->get();

            if (count($table_schedule) == 0) {
                if ($user->division_id == 5) {
                    $days_paid_leave++;
                }
                else {
                    $check_holiday = DB::table('master_holidays')
                    ->where('date','=',$check_days)->get();

                    if ($check_name_days != "Saturday" && $check_name_days != "Sunday" && (count($check_holiday) == 0)) {
                        $days_paid_leave++;
                    }
                }
            }
            else {
                $name_for_get_shift = 'shift_' .date('j', strtotime($check_days));
                $shift = $table_schedule[0]->$name_for_get_shift;
                if ($shift != 'Cuti' || $shift != 'Off') {
                    $days_paid_leave++;
                }
            }

            $start = $check_days;
        }

        TransactionPaidLeave::create([
            'user_id'=>$request->user_id,
            'paid_leave_date_start'=>$date_start,
            'paid_leave_date_end'=>$date_end,
            'days'=>$days_paid_leave,
            'status'=>$status,
            'paid_leave_type_id'=>$request->paid_leave_type_id,
            'needs'=>$needs,
            'informations'=>$info

        ]);
        Alert::success('Berhasil!', 'Pengajuan cuti berhasil terkirim!');
        return redirect('/staff/paid-leave/history');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();

        $data = DB::table('transaction_paid_leaves')
        ->where('user_id', '=', $user->id)
        ->leftJoin('master_users','transaction_paid_leaves.user_id','=','master_users.id')
        ->leftJoin('master_leave_types','transaction_paid_leaves.paid_leave_type_id','=','master_leave_types.id')
        ->select(
            'transaction_paid_leaves.*',
            'master_users.yearly_leave_remaining as user_laeve_remaining',
            'master_leave_types.name as type_name'
            )
        ->paginate(5);
        
        return view('staff.transactionleave.history',[
            'data'=>$data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_approve(Request $request)
    {
        $ids = $request->input('check');
        foreach($ids as $check_id) {
            $data = TransactionPaidLeave::where("id",$check_id)->first();
            $data_user = MasterUser::where("id",$data->user_id)->first();
            $data->update(['status' => 'Diterima']);

            $interval = (new DateTime($data->paid_leave_date_start))->diff(new DateTime($data->paid_leave_date_end));
            $paid_leave = ($interval->format('%a')) + 1;

            $start = date('Y-m-d', strtotime('-1 days', strtotime($data->paid_leave_date_start)));
            for ($i = 0; $i < $paid_leave; $i++) {
                $check_days = date('Y-m-d', strtotime('+1 days', strtotime($start)));
                $check_name_days = date('l', strtotime($check_days));
                $check_month = switch_month(date('m', strtotime($check_days)));
                $check_year = date('Y', strtotime($check_days));

                $check_holiday = DB::table('master_holidays')
                ->where('date','=',$check_days)->get();

                $data_schedule = DB::table('master_job_schedules')
                ->where('user_id', '=', $data->user_id)
                ->where('month','=',$check_month)
                ->where('year','=',$check_year)
                ->get();

                if (count($data_schedule) == 0) {
                    if ($data_user->division_id == 5) {
                        $temp_accept_leave = DB::table('accepted_paid_leaves')
                        ->where('date', '=', $check_days)
                        ->where('user_id', '=', $data->user_id)
                        ->get();
                        if(count($temp_accept_leave) == 0 ) {
                            AcceptedPaidLeave::create([
                                'paid_leave_id'=>$data->id,
                                'user_id'=>$data->user_id,
                                'date'=>$check_days
                            ]);
                            $remaining_days_off = $data_user->yearly_leave_remaining - 1;
                            $data_user->update(['yearly_leave_remaining' => $remaining_days_off]);
                        }
                    }
                    else {
                        if ($check_name_days != "Saturday" && $check_name_days != "Sunday" && (count($check_holiday) == 0)) {
                            $temp_accept_leave = DB::table('accepted_paid_leaves')
                            ->where('date', '=', $check_days)
                            ->where('user_id', '=', $data->user_id)
                            ->get();
                            if(count($temp_accept_leave) == 0 ) {
                                AcceptedPaidLeave::create([
                                    'paid_leave_id'=>$data->id,
                                    'user_id'=>$data->user_id,
                                    'date'=>$check_days
                                ]);
                                $remaining_days_off = $data_user->yearly_leave_remaining - 1;
                                $data_user->update(['yearly_leave_remaining' => $remaining_days_off]);
                            }
                        }
                    }
                }
                else {
                    $day = date('j', strtotime($check_days));
                    $temp = 'shift_'.$day;
                    $shift_day = $data_schedule[0]->$temp;

                    if($shift_day != 'Cuti' || $shift_day != 'Off') {
                        $total_hour = $data_schedule[0]->total_hour - check_hour_shift($shift_day);
                        DB::table('master_job_schedules')
                        ->where('id', '=', $data_schedule[0]->id)
                        ->update([$temp => 'Cuti', 'total_hour' => $total_hour]);

                        $temp_accept_leave = DB::table('accepted_paid_leaves')
                        ->where('date', '=', $check_days)
                        ->where('user_id', '=', $data->user_id)
                        ->get();
                        if(count($temp_accept_leave) == 0 ) {
                            AcceptedPaidLeave::create([
                                'paid_leave_id'=>$data->id,
                                'user_id'=>$data->user_id,
                                'date'=>$check_days
                            ]);
                            $remaining_days_off = $data_user->yearly_leave_remaining - 1;
                            $data_user->update(['yearly_leave_remaining' => $remaining_days_off]);
                        }
                    }
                }

                $start = $check_days;
            }
        }
        return redirect('/admin/paid-leave');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('check');
        foreach($ids as $deletes) {
            $data = TransactionPaidLeave::where("id",$deletes)->first();
            $data->delete();
        }
        return redirect('/admin/paid-leave');
    }

    public function destroy_staff(Request $request)
    {
        $ids = $request->input('check');
        foreach($ids as $deletes) {
            $data = TransactionPaidLeave::where("id",$deletes)->first();
            $data->delete();
        }
        return redirect('/staff/paid-leave/history');
    }

    public function cancel_staff(TransactionPaidLeave $id){
        TransactionPaidLeave::where('id','=', $id->id)->update(['status' => 'Cancel']);
        Alert::info('Berhasil!', 'Pengajuan cuti telah di cancel!');
        return redirect('/staff/paid-leave/history');
    }

    public function calculate(Request $request){
        if ($request->type == 1) {
            $interval = (new DateTime($request->yearly_start))->diff(new DateTime($request->yearly_end));
            $paid_leave_days = ($interval->format('%a')) + 1;
            if($request->yearly_start == '') $paid_leave_days = 0;
            
            return response()->json([
                'type' => $request->type,
                'yearly_days'=>$paid_leave_days
            ]);

        } else {
            $date_start = date('Y/m/d',strtotime($request->defaulted_start));
            if ($request->type == 2) {
                $date_end = date('Y/m/d',strtotime('+59 days',strtotime($date_start)));
            } elseif ($request->type == 3) {
                $date_end = date('Y/m/d',strtotime('+2 days',strtotime($date_start)));
            }
            $split = explode('/',$date_end);
            $end_info = 'Cuti akan berakhir pada tanggal '. $split[2] . ' ' . switch_month($split[1]) . ' ' .$split[0];

            return response()->json([
                'type' => $request->type,
                'info' => $end_info
            ]);
        }
    }
}
