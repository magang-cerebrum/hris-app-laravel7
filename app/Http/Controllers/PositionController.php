<?php

namespace App\Http\Controllers;

use App\MasterPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $position = MasterPosition::get();
            return view('masterData.position.list',[
                'position' => $position,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function create()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.position.create', [
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $request->validate(['name' => 'required']);
            $user = Auth::user()->name;
            MasterPosition::create($request->all());
            activity()->log('Jabatan '.$request->name.' telah ditambahkan oleh admin ' . $user);
            Alert::success('Berhasil!', 'Jabatan baru telah ditambahkan!');
            return redirect('/admin/position');
        }
        else {
            return redirect('/login');
        }
    }

    public function edit(MasterPosition $position)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.position.edit',[
                'position' => $position,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function update(Request $request, MasterPosition $position)
    {
        if(Auth::check()){
            $request->validate(['name' => 'required']);
            $user = Auth::user()->name;
            $past = MasterPosition::where('id',$position->id)->get();
            MasterPosition::where('id', $position->id)->update(['name' => $request->name]);
            activity()->log($user.' telah memperbarui posisi ' .$past[0]->name .' menjadi '.$request->name );
            Alert::success('Berhasil!', 'Jabatan '. $position->name . ' telah diganti menjadi Jabatan '. $request->name . '!');
            return redirect('/admin/position');
        }
        else {
            return redirect('/login');
        }
    }

    public function destroySelected(Request $request){
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterPosition::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Jabatan yang dipilih berhasil dihapus!');
            return redirect('/admin/position');
        }
        else {
            return redirect('/login');
        }
    }

    public function toogle_status(Request $request){
        if(Auth::check()){
            if ($request->status == 'Aktif') {$change = 'Non-Aktif';}
            else {$change = 'Aktif';}
            MasterPosition::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change]);
        }
        else {
            return redirect('/login');
        }
    }
}
