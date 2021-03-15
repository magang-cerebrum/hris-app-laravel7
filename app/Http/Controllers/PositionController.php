<?php

namespace App\Http\Controllers;

use App\MasterPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $position = MasterPosition::get();
        return view('masterdata.position.list',[
            'position' => $position,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('masterdata.position.create', [
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $user = Auth::user()->name;
        MasterPosition::create($request->all());
        activity()->log('Jabatan '.$request->name.' telah ditambahkan oleh admin ' . $user);
        Alert::success('Berhasil!', 'Jabatan baru telah ditambahkan!');
        return redirect('/admin/position');
    }

    public function edit(MasterPosition $position)
    {
        $user = Auth::user();
        return view('masterdata.position.edit',[
            'position' => $position,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function update(Request $request, MasterPosition $position)
    {
        $request->validate(['name' => 'required']);
        $user = Auth::user()->name;
        $past = MasterPosition::where('id',$position->id)->get();
        MasterPosition::where('id', $position->id)->update(['name' => $request->name]);
        activity()->log($user.' telah memperbarui posisi ' .$past[0]->name .' menjadi '.$request->name );
        Alert::success('Berhasil!', 'Jabatan '. $position->name . ' telah diganti menjadi Jabatan '. $request->name . '!');
        return redirect('/admin/position');
    }

    public function destroySelected(Request $request){
        foreach ($request->selectid as $item) {
            MasterPosition::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Jabatan yang dipilih berhasil dihapus!');
        return redirect('/admin/position');
    }
}
