<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = DB::table('activity_log')->orderByDesc('created_at')->paginate(10);
        $user = Auth::user();
        return view('system.logs',[
            'data'=>$log,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterLog  $masterLog
     * @return \Illuminate\Http\Response
     */
    
    public function destroyselected(Request $request)
    {
        foreach ($request->selectid as $item) {
            DB::table('activity_log')->where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Log yang dipilih berhasil dihapus!');
        return redirect('/admin/log');

    }
}
