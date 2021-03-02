<?php

namespace App\Http\Controllers;

use App\MasterDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();
        $division = MasterDivision::get();
        return view('masterdata.division.list',[
            'division' => $division,
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
        return view('masterdata.division.create', [
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
        MasterDivision::create($request->all());
        $user = Auth::user()->name;
        activity()->log('Divisi '. $request->name .' telah ditambahkan oleh Admin '. $user);
        Alert::success('Berhasil!', 'Divisi baru telah ditambahkan!');
        return redirect('/admin/division');
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
    public function edit(MasterDivision $division)
    {
        $user = Auth::user();
        return view('masterdata.division.edit',[
            'division' => $division,
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
    public function update(Request $request, MasterDivision $division)
    {
        $request->validate(['name' => 'required']);
        $past = MasterDivision::where('id',$division->id)->get();
        MasterDivision::where('id', $division->id)
            ->update(['name' => $request->name]);
            $user = Auth::user()->name;
        // activity()->log('Divisi '. $request->name .' telah di-update oleh Admin '. $user);
        activity()->log($user.' telah memperbarui Divisi ' .$past[0]->name .' menjadi '.$request->name );
            Alert::success('Berhasil!', 'Divisi '. $division->name . ' telah diganti menjadi Divisi '. $request->name . '!');
        return redirect('/admin/division');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterDivision $division)
    {
        MasterDivision::destroy($division->id);
        return redirect('/admin/division');
    }

    public function destroyAll(Request $request){
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

}
