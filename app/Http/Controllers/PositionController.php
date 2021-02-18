<?php

namespace App\Http\Controllers;

use App\MasterPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $position = MasterPosition::paginate(5);
        return view('masterdata.position.list',[
            'position' => $position,
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
        return view('masterdata.position.create', [
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
        $request->validate(['name' => 'required']);
        $user = Auth::user()->name;
        MasterPosition::create($request->all());
        activity()->log('Jabatan '.$request->name.' telah ditambahkan oleh admin ' . $user);
        Alert::success('Berhasil!', 'Jabatan baru telah ditambahkan!');
        return redirect('/admin/position');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPosition $position)
    {
        $request->validate(['name' => 'required']);
        $user = Auth::user()->name;
        $past = MasterPosition::where('id',$position->id)->get();
        // dd($past);
        MasterPosition::where('id', $position->id)
            ->update(['name' => $request->name]);
        activity()->log($user.' telah memperbarui posisi ' .$past[0]->name .' menjadi '.$request->name );
        Alert::success('Berhasil!', 'Jabatan '. $position->name . ' telah diganti menjadi Jabatan '. $request->name . '!');
        return redirect('/admin/position');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterPosition $position)
    {
        MasterPosition::destroy($position->id);
        return redirect('/admin/position');
    }
    public function destroyAll(Request $request){
        foreach ($request->selectid as $item) {
            MasterPosition::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Jabatan yang dipilih berhasil dihapus!');
        return redirect('/admin/position');
    }
}
