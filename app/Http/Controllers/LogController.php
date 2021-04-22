<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class LogController extends Controller
{    
    public function index()
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }

        $log = DB::table('activity_log')->orderByDesc('created_at')->paginate(10);
        $user = Auth::user();
        return view('system.logs.list',[
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
    
    public function search(Request $request){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        if ($request->get('query') == null) {return redirect('/admin/log');}
        if (strpos($request->get('query'),'/')) {
            $split = explode('/',$request->get('query'));
            $data = DB::table('activity_log')
            ->whereRaw("created_at LIKE '".$split[1]."-".$split[0]."%'")
            ->orderByDesc('created_at')
            ->paginate(10);
        } else {
            $data = DB::table('activity_log')
            ->whereRaw("description LIKE '%" . $request->get('query') . "%'")
            ->orderByDesc('created_at')
            ->paginate(10);
        }
        $user =  Auth::user();

        return view('system.logs.result', [
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->idate
        ]);
    }
}
