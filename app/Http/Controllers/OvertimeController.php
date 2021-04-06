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

    public function create()
    {
        $user = Auth::user();
        $division = division_members($user->position_id);
        $data = DB::table('master_users')
        ->leftJoin('master_divisions','master_users.division_id','=','master_divisions.id')
        ->leftJoin('master_positions','master_users.position_id','=','master_positions.id')
        ->where('master_users.status','=','Aktif')
        ->whereIn('master_users.division_id',$division)
        ->whereNotIn('master_users.division_id',[7])
        ->select(
            'master_users.id as user_id',
            'master_users.nip as user_nip',
            'master_users.name as user_name',
            'master_users.division_id',
            'master_users.position_id',
            'master_divisions.name as division_name',
            'master_positions.name as position_name'
            )
        ->get();
        $data_division = DB::table('master_divisions')->select('name')->where('status','Aktif')->get();
        return view('masterdata.overtime.create', [
            'data'=>$data,
                'data_division'=>$data_division,
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
