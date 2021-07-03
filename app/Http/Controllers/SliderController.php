<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use App\slider;

class SliderController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $data = DB::table('sliders')->get();
            return view('poster.list',[
                'menu'=>['m-sistem','s-sistem-poster'],
                'data'=>$data,
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
            return view('poster.add',[
                'menu'=>['m-sistem','s-sistem-poster'],
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
            $request->validate([
                'name'=>'required|string',
                'file'=>'file|required'
            ]);
    
            $poster = $request->file('file');
            $poster_name = "poster_" . $request->name . "." . $poster->getClientOriginalExtension();
            $tujuan_upload = 'img/poster';
            $poster->move($tujuan_upload, $poster_name);
    
            DB::table('sliders')
            ->insert(
                [
                    'name'=>$request->name,
                    'file'=>$poster_name
                ]
            );
    
            Alert::success('Berhasil!', 'Poster baru telah ditambahkan!');
            return redirect('/admin/poster');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroySelected(Request $request){
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                slider::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Poster yang dipilih berhasil dihapus!');
            return redirect('/admin/poster');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(slider $poster)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('poster.edit',[
                'menu'=>['m-sistem','s-sistem-poster'],
                'poster' => $poster,
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

    public function update(Request $request, slider $poster)
    {
        if(Auth::check()){
            $request->validate([
                'name'=>'required|string',
                'file'=>'file|required'
            ]);
    
            $past = slider::where('id',$poster->id)->get();
            
            $path_poster = 'img/poster/'.$past[0]->file;
            $file_path_poster = public_path($path_poster);
            unlink($file_path_poster);
    
            $poster = $request->file('file');
            $poster_name = "poster_" . $request->name . "." . $poster->getClientOriginalExtension();
            $tujuan_upload = 'img/poster';
            $poster->move($tujuan_upload, $poster_name);
    
            DB::table('sliders')->where('id',$past[0]->id)->update(['file'=>$poster_name]);
    
            Alert::success('Berhasil!', 'Poster '. $past[0]->name . ' telah diganti !');
            return redirect('/admin/poster');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
