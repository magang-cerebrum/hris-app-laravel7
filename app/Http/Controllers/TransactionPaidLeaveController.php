<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionPaidLeave;
use App\MasterLeaveType;
use App\MasterUser;
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
            'id'=>$user->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'paid_leave_type_id'=>'required',
            'paid_leave_date_start'=>'required',
            'paid_leave_date_end'=>'required',
            'needs'=>'required'
        ]);
        
        $info = "-";
        $status = "Diajukan";

        $datetime1 = new DateTime($request->paid_leave_date_start);
        $datetime2 = new DateTime($request->paid_leave_date_end);
        $interval = $datetime1->diff($datetime2);
        $paid_leave = ($interval->format('%a')) + 1;

        $start = date('Y/m/d', strtotime('-1 days', strtotime($request->paid_leave_date_start)));
        $days_paid_leave = 0;
        for ($i = 0; $i < $paid_leave; $i++) {
            $check_days = date('Y/m/d', strtotime('+1 days', strtotime($start)));
            $check_name_days = date('l', strtotime($check_days));

            $check_holiday = DB::table('master_holidays')
            ->where('date','=',$check_days)->get();

            if ($check_name_days != "Saturday" && $check_name_days != "Sunday" && (count($check_holiday) == 0)) {
                $days_paid_leave++;
            }

            $start = $check_days;
        }

        TransactionPaidLeave::create([
            'user_id'=>$request->user_id,
            'paid_leave_date_start'=>$request->paid_leave_date_start,
            'paid_leave_date_end'=>$request->paid_leave_date_end,
            'days'=>$days_paid_leave,
            'status'=>$status,
            'paid_leave_type_id'=>$request->paid_leave_type_id,
            'needs'=>$request->needs,
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $remaining_days_off = $data_user->yearly_leave_remaining - $data->days;
            $data->update(['status' => 'Diterima']);
            $data_user->update(['yearly_leave_remaining' => $remaining_days_off]);
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
}
