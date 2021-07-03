<?php

namespace App\Http\Controllers;

use App\MasterDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
class DivisionController extends Controller
{
    public function index()
    {   
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $division = MasterDivision::get();
            return view('masterData.division.list',[
                'menu'=>['m-master','s-master-divisi'],
                'division' => $division,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
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
            return view('masterData.division.create', [
                'menu'=>['m-master','s-master-divisi'],
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $request->validate(['name' => 'required']);
            MasterDivision::create($request->all());
            $user = Auth::user()->name;
            activity()->log('Divisi '. $request->name .' telah ditambahkan oleh Admin '. $user);
            Alert::success('Berhasil!', 'Divisi baru telah ditambahkan!');
            return redirect('/admin/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterDivision $division)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.division.edit',[
                'menu'=>['m-master','s-master-divisi'],
                'division' => $division,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update(Request $request, MasterDivision $division)
    {
        if(Auth::check()){
            $request->validate(['name' => 'required']);
            $past = MasterDivision::where('id',$division->id)->get();
            $user = Auth::user()->name;
            MasterDivision::where('id', $division->id)->update(['name' => $request->name]);
            activity()->log($user.' telah memperbarui Divisi ' .$past[0]->name .' menjadi '.$request->name );
            Alert::success('Berhasil!', 'Divisi '. $division->name . ' telah diganti menjadi Divisi '. $request->name . '!');
            return redirect('/admin/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroySelected(Request $request){
        if(Auth::check()){
            $i = 0;
            $user = Auth::user()->name;
            foreach ($request->selectid as $item) {
                $namadiv = MasterDivision::where('id','=',$item)->get();
                activity()->log('Divisi '. $namadiv[$i]->name .' telah di-hapus oleh Admin '. $user);
                MasterDivision::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Divisi yang dipilih berhasil dihapus!');
            return redirect('/admin/division');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function toogle_status(Request $request){
        if(Auth::check()){
            if ($request->status == 'Aktif') {$change = 'Non-Aktif';}
            else {$change = 'Aktif';}
            MasterDivision::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
