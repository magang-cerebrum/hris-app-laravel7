<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\MasterSalaryCut;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SalaryCutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $salarycut = MasterSalaryCut::leftjoin('master_users','master_salary_cuts.user_id','=','master_users.id')
        ->select([
            'master_users.id as user_id',
            'master_users.name as user_name',
            'master_salary_cuts.*'
        ])
        ->get();
        return view('masterdata.salarycut.list',[
            'salarycut' => $salarycut,
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
        $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
        return view('masterdata.salarycut.create', [
            'staff'=>$staff,
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
        if ($request->type == 'Semua') {
            $request->validate([
                'information' => 'required',
                'nominal' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            MasterSalaryCut::create([
                'information' => $request->information,
                'type' => $request->type,
                'nominal' => $nominal
            ]);
        } else {
            $request->validate([
                'information' => 'required',
                'range_month' => 'required',
                's_nominal' => 'required',
                'user_id' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->s_nominal);
            $month = date('m');
            $year = date('Y');
            for ($i=0; $i < $request->range_month; $i++) {
                MasterSalaryCut::create([
                    'information' => $request->information,
                    'type' => $request->type,
                    'nominal' => $nominal,
                    'month' => switch_month($month),
                    'year' => $year,
                    'user_id' => $request->user_id
                ]);
                if ($month == 12) { 
                    $month = 01;
                    $year++;
                } else $month++;
            }
        }
        Alert::success('Berhasil!', 'Potongan gaji baru telah ditambahkan!');
        return redirect('/admin/salary-cut');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSalaryCut $cut)
    {
        $user = Auth::user();
        $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
        return view('masterdata.salarycut.edit',[
            'cut' => $cut,
            'staff' => $staff,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterSalaryCut $cut)
    {
        if ($cut->type == 'Semua') {
            $request->validate([
                'information' => 'required',
                'nominal' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            MasterSalaryCut::where('id','=',$cut->id)
            ->update([
                'information' => $request->information,
                'nominal' => $nominal
            ]);
        } else {
            $request->validate([
                'information' => 'required',
                'month' => 'required',
                'nominal' => 'required',
                'user_id' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            $split = explode('-',$request->month);
            MasterSalaryCut::where('id','=',$cut->id)
            ->update([
                'information' => $request->information,
                'nominal' => $nominal,
                'month' => switch_month($split[0]),
                'year' => $split[1],
                'user_id' => $request->user_id
            ]);
        }
        Alert::success('Berhasil!', 'Potongan gaji '.$cut->information.' berhasil diperbaharui!');
        return redirect('/admin/salary-cut');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        foreach ($request->selectid as $item) {
            MasterSalaryCut::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Potongan gaji yang dipilih berhasil dihapus!');
        return redirect('/admin/salary-cut');
    }
}
