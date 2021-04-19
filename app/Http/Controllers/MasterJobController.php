<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJobRecruitment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class MasterJobController extends Controller
{
    public function index()
    {
        $data = MasterJobRecruitment::all();
        return response()->json($data, 200);
    }

    public function indexJob()
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $dataJob = MasterJobRecruitment::paginate(5);
        $user = Auth::user();

        return view('masterData.job.list', [
            'dataJob' => $dataJob,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create()
    {
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        $user = Auth::user();
        return view('masterData.job.create', [
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'descript'=>'required',
            'required'=>'required'
        ]);
        
        MasterJobRecruitment::create($request->all());
        $user = Auth::user()->name;
        activity()->log('Admin ' .$user.' Telah menambahkan Lowongan ' . $request->name . " bagian " . $request->descript);
        Alert::success('Berhasil!', 'Lowongan baru telah ditambahkan!');
        return redirect('/admin/job');
    }

    
    public function destroy(Request $request)
    {
        $ids = $request->input('check');
        foreach($ids as $deletes) {
            $data= MasterJobRecruitment::where("id",$deletes)->first();
            $data->delete();
        }
        $user = Auth::user()->name;
        activity()->log('Admin ' .$user.' Telah menghapus Lowongan ' . $data->name  . " bagian " . $data->descript);
        Alert::success('Berhasil!', 'Lowongan yang dipilih berhasil dihapus!');
        return redirect('/admin/job');
    }

    public function search(Request $request){
        if(Gate::denies('is_admin')){
            Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
            return back();
        }
        if ($request->get('query') == null) {return redirect('/admin/job');}
        $user = Auth::user();
        $data = MasterJobRecruitment::whereRaw("name LIKE '%" . $request->get('query') . "%'")
        ->orWhereRaw("descript LIKE '%" . $request->get('query') . "%'")
        ->orWhereRaw("required LIKE '%" . $request->get('query') . "%'")
        ->paginate(5);
        return view('masterdata.job.result',[
            'dataJob' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }
}
