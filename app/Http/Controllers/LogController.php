<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
class LogController extends Controller
{    
    public function index()
    {
        $log = DB::table('activity_log')->orderByDesc('created_at')->paginate(100);
        $user = Auth::user();
        
        return view('system.logs',[
            'data'=>$log,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function destroyselected(Request $request)
    {
        foreach ($request->selectid as $item) {
            DB::table('activity_log')->where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Log yang dipilih berhasil dihapus!');
        return redirect('/admin/log');

    }
    public function AutoDeleteLogs(){
        $limitDate = Carbon::now()->subDay(45)->isoFormat('YYYY-MM-DD');
        $logse = DB::table('activity_log')
        ->orderBy('created_at','asc')
        ->where('created_at','<=',$limitDate)
        ->delete();
        
    }
}
