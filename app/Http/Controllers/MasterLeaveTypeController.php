<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\MasterLeaveType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class MasterLeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            $leavetype = MasterLeaveType::paginate(5);

            return view('masterdata.leavetype.list',['leavetype'=>$leavetype,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            return view('masterdata.leavetype.create',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
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
            'name'=>'required',
            'default_day'=>'required|numeric'
        ]);
        MasterLeaveType::create($request->all());
        Alert::success('Berhasil!', 'Tipe Cuti baru telah ditambahkan!');
        return redirect('/admin/paid-leave-type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterLeaveType $leavetype)
    {
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            return view('masterdata.leavetype.edit',['cuti' => $leavetype,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterLeaveType $leavetype)
    {
        $request->validate([
            'name'=>'required',
            'default_day'=>'required|numeric'
        ]);
        MasterLeaveType::where('id',$leavetype->id)->update([
            'name'=>$request->name,
            'default_day'=>$request->default_day
        ]);
        Alert::success('Berhasil!', 'Tipe Cuti '. $leavetype->name . ' berhasil diperbaharui');
        return redirect('admin/paid-leave-type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterLeaveType $leavetype)
    {
        MasterLeaveType::destroy($leavetype->id);
        return redirect('/admin/paid-leave-type');
    }

    public function destroyAll(Request $request){
        foreach ($request->selectid as $item) {
            MasterLeaveType::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Tipe Cuti yang dipilih berhasil dihapus!');
        return redirect('/admin/paid-leave-type');
    }
}
