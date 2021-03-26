<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Asset\img\poster;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = DB::table('sliders')->get();
        return view('poster.list',[
            'data'=>$data,
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
        return view('poster.add',[
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

    public function destroySelected(Request $request){
        foreach ($request->selectid as $item) {
            slider::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Poster yang dipilih berhasil dihapus!');
        return redirect('/admin/poster');
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
    public function edit(slider $poster)
    {
        $user = Auth::user();
        return view('poster.edit',[
            'poster' => $poster,
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
    public function update(Request $request, slider $poster)
    {
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

        Alert::success('Berhasil!', 'Poster '. $past[0]->name . ' telah diganti !');
        return redirect('/admin/poster');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
