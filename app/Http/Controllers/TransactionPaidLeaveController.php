<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionPaidLeave;
use App\MasterLeaveType;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        
        // $start = date($data[0]->paid_leave_date_start);
        // $end = date($data[0]->paid_leave_date_end);
        // $paid_leave = date_diff($end, $start) + 1;

        $start = strtotime($data[0]->paid_leave_date_start);
        $end = strtotime($data[0]->paid_leave_date_end);
        $paid_leave = (($end - $start) / 86400) + 1 ;
        dd($paid_leave);
        
        return view('masterData.transactionleave.list', [
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id,
            'day'=>$paid_leave
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
            'paid_leave_date_end'=>'required'
        ]);
        
        $status = "Diajukan";

        TransactionPaidLeave::create([
            'user_id'=>$request->user_id,
            'paid_leave_date_start'=>$request->paid_leave_date_start,
            'paid_leave_date_end'=>$request->paid_leave_date_end,
            'status'=>$status,
            'paid_leave_type_id'=>$request->paid_leave_type_id

        ]);
        return redirect('/staff/paid-leave');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
}
