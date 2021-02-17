<?php

namespace App\Http\Controllers;

use App\MasterAchievement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterAchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('masterData.achievement.list',[
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
     * @param  \App\MasterAchievement  $masterAchievement
     * @return \Illuminate\Http\Response
     */
    public function show(MasterAchievement $masterAchievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterAchievement  $masterAchievement
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterAchievement $masterAchievement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterAchievement  $masterAchievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterAchievement $masterAchievement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterAchievement  $masterAchievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterAchievement $masterAchievement)
    {
        //
    }
    public function scoring(Request $request , MasterAchievement $masterAchievement){
        $user = Auth::user();
        $data = DB::table('master_users')->get();
        return view('masterData.achievement.scoring',[
        'name'=>$user->name,
        'profile_photo'=>$user->profile_photo,
        'email'=>$user->email,
        'id'=>$user->id,
        'data'=>$data
        ]);
    }
    public function scored (Request $request){
        global $datas;
        $datas=$request;
        for($i = 1; $i <=$request->count; $i++){
            global $datas;
            $user_id = 'user_id_'.$i;
            $data_id = $datas->$user_id;
            $score = 'score_'.$i;
            $data = $datas->$score;
            MasterAchievement::create([
                'score' => $data,
                'month'  =>$datas->month,
                'year' =>$datas->year ,
                'achievement_user_id'=>$data_id
            ]);
        }
        return redirect('/admin/achievement/scoring');
    }
}
