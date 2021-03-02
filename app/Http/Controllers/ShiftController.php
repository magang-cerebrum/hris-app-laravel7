<?php

namespace App\Http\Controllers;

use App\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $shift = MasterShift::get();
        return view('masterdata.shift.list',[
            'shift' => $shift,
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
        return view('masterdata.shift.create', [
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
        $user = Auth::user()->name;
        $request->validate([
            'name' => 'required',
            'start_working_time' => 'required',
            'end_working_time' => 'required'
        ]);
        
        $jam_masuk = date_create($request->start_working_time); //diganti masuk kapan
        $jam_keluar = date_create($request->end_working_time); //
        $jumlah_jam = date_diff($jam_masuk, $jam_keluar);
        $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);

        MasterShift::create([
            'name' => $request->name,
            'start_working_time' => $request->start_working_time,
            'end_working_time' => $request->end_working_time,
            'total_hour' => $interval
        ]);
        activity()->log('Data ' .$request->name.' baru telah ditambahkan oleh '.$user);
        Alert::success('Berhasil!', 'Shift baru telah ditambahkan!');
        return redirect('/admin/shift');
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
    public function edit(MasterShift $shift)
    {
        $user = Auth::user();
        return view('masterdata.shift.edit',[
            'shift' => $shift,
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
    public function update(Request $request, MasterShift $shift)
    {
        $user = Auth::user()->name;
        $past = MasterShift::where('id',$shift->id)->get();
        $request->validate([
            'name' => 'required',
            'start_working_time' => 'required',
            'end_working_time' => 'required'
        ]);

        $jam_masuk = date_create($request->start_working_time); //diganti masuk kapan
        $jam_keluar = date_create($request->end_working_time); //
        $jumlah_jam = date_diff($jam_masuk, $jam_keluar);
        $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);
        
        MasterShift::where('id', $shift->id)
            ->update([
                'name' => $request->name,
                'start_working_time' => $request->start_working_time,
                'end_working_time' => $request->end_working_time,
                'total_hour' => $interval
            ]);
        activity()->log($user.' telah memperbarui  ' .$past[0]->name .' ('.$past[0]->start_working_time.'-'.$past[0]->end_working_time.') '.' menjadi '.$request->name .' ('.$request->start_working_time.'-'.$request->end_working_time.') ' );    
        Alert::success('Berhasil!', 'Shift '. $shift->name . ' telah diperbaharui!');
        return redirect('/admin/shift');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterShift $shift)
    {
        MasterShift::destroy($shift->id);
        return redirect('/admin/shift');
    }
    public function destroyAll(Request $request){
        foreach ($request->selectid as $item) {
            MasterShift::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Shift yang dipilih berhasil dihapus!');
        return redirect('/admin/shift');
    }
}
