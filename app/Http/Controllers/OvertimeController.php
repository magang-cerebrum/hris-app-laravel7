<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterOvertime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $overtime = MasterOvertime::paginate(10);
        return view('masterdata.overtime.searchOvertime', [
            'overtime' => $overtime,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function ajaxList(Request $request)
    {
        $data = MasterOvertime::leftJoin('master_users','master_overtimes.user_id','=','master_users.id')
        ->where('month',switch_month(explode('-',$request->periode)[1]))
        ->where('year',explode('-',$request->periode)[0])
        ->select([
            'master_overtimes.*',
            'master_users.name as user_name'
        ])
        ->get();
        return view('masterdata.overtime.list', [
            'data' => $data,
            'month' => explode('-',$request->periode)[1],
            'year' => explode('-',$request->periode)[0]
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $user_overtime = array();
        $data_overtime = MasterOvertime::where('month',switch_month($request->month))
        ->where('year',$request->year)
        ->select(['user_id',])
        ->get();
        $data_user = DB::table('master_users')->select(['id'])->get();
        foreach ($data_overtime as $item) {
            foreach ($data_user as $ids) {
                if($item->user_id == $ids->id){
                    $user_overtime[] = $item->user_id;
                }
            }
        }
        $data =  DB::table('master_users')
        ->leftJoin('master_job_schedules','master_users.id','=','master_job_schedules.id')
        ->where('status','Aktif')
        ->whereNotIn('division_id',[7])
        ->whereNotIn('master_users.id',$user_overtime)
        ->select([
            'master_users.id as user_id',
            'nip as user_nip',
            'name as user_name',
            'salary as user_salary',
            'total_hour as user_hour'
        ])
        ->get();
        // dd($data_overtime,$data_user,$user_overtime,$data);
        return view('masterdata.overtime.create', [
            'data' => $data,
            'month' => $request->month,
            'year' => $request->year,
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
        //
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
    public function destroy($id)
    {
        //
    }
}
