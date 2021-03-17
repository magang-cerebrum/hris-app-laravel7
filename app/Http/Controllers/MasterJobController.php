<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJobRecruitment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MasterJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterJobRecruitment::all();
        // return view('recruitment.recruitment', ['data' => $data]);
        return response()->json($data, 200);
    }

    public function indexJob()
    {
        $dataJob = MasterJobRecruitment::paginate(5);
        $user = Auth::user();

        return view('masterData.job.job', [
            'dataJob' => $dataJob,
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
        $user = Auth::user();
        return view('masterData.job.jobAdd', [
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
            'name'=>'required|alpha',
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
}
