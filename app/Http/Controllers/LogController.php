<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\MasterLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use \Spatie\Activitylog\Models\Activity;
class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $log = DB::table('activity_log')->paginate(10);
         $user = Auth::user();
        return view('system.logs',['data'=>$log,
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
        //
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
     * @param  \App\MasterLog  $masterLog
     * @return \Illuminate\Http\Response
     */
    public function show(MasterLog $masterLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterLog  $masterLog
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterLog $masterLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterLog  $masterLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterLog $masterLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterLog  $masterLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Activity::destroy($masterLog->id);
        DB::table('activity_log')->where('id','=',$request->id)->delete();
        return redirect('/admin/log');
    }
    public function destroyselected(Request $request)
    {
        // Activity::destroy($masterLog->id);
        // DB::table('activity_log')->where('id','=',$request->id)->delete();
        // return redirect('/admin/log');
        foreach ($request->selectid as $item) {
            DB::table('activity_log')->where('id','=',$item)->delete();
        }
        return redirect('/admin/log');

    }
}
