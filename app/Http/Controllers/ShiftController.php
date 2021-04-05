<?php

namespace App\Http\Controllers;

use App\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
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

    public function store(Request $request)
    {   
        $user = Auth::user()->name;
        $request->validate([
            'name' => 'required',
            'start_working_time' => 'required',
            'end_working_time' => 'required',
            'calendar_color' => 'required'
        ]);

        $jumlah_jam = date_diff(date_create($request->start_working_time), date_create($request->end_working_time));
        $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);
        
        MasterShift::create([
            'name' => $request->name,
            'start_working_time' => $request->start_working_time,
            'end_working_time' => $request->end_working_time,
            'calendar_color' => $request->calendar_color,
            'total_hour' => $interval
        ]);

        activity()->log('Data ' .$request->name.' baru telah ditambahkan oleh '.$user);
        Alert::success('Berhasil!', 'Shift baru telah ditambahkan!');
        return redirect('/admin/shift');
    }

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

    public function update(Request $request, MasterShift $shift)
    {
        $user = Auth::user()->name;
        $past = MasterShift::where('id',$shift->id)->get();
        $request->validate([
            'name' => 'required',
            'start_working_time' => 'required',
            'end_working_time' => 'required',
            'calendar_color' => 'required'
        ]);

        $jumlah_jam = date_diff(date_create($request->start_working_time), date_create($request->end_working_time));
        $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);
        
        MasterShift::where('id', $shift->id)
            ->update([
                'name' => $request->name,
                'start_working_time' => $request->start_working_time,
                'end_working_time' => $request->end_working_time,
                'calendar_color' => $request->calendar_color,
                'total_hour' => $interval
            ]);
        activity()->log($user.' telah memperbarui  ' .$past[0]->name .' ('.$past[0]->start_working_time.'-'.$past[0]->end_working_time.') '.' menjadi '.$request->name .' ('.$request->start_working_time.'-'.$request->end_working_time.') ' );    
        Alert::success('Berhasil!', 'Shift '. $shift->name . ' telah diperbaharui!');
        return redirect('/admin/shift');
    }

    public function destroySelected(Request $request){
        foreach ($request->selectid as $item) {
            MasterShift::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Shift yang dipilih berhasil dihapus!');
        return redirect('/admin/shift');
    }

    public function toogle_status(Request $request){
        if ($request->status == 'Aktif') {$change = 'Non-Aktif';}
        else {$change = 'Aktif';}
        MasterShift::where('id', $request->id)->update(['status' => $change]);
        return response()->json(['name'=> $request->name, 'status' => $change]);
    }
}
