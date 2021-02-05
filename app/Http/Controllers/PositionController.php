<?php

namespace App\Http\Controllers;

use App\MasterPosition;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = MasterPosition::paginate(5);
        return view('masterdata.position.list',['position' => $position]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masterdata.position.create');
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
        MasterPosition::create($request->all());
        return redirect('/admin/position')->with('status','Jabatan Berhasil Ditambahkan');
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
        return view('masterdata.position.edit',['position' => $position]);
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
        MasterPosition::where('id', $position->id)
            ->update(['name' => $request->name]);
        return redirect('/admin/position')->with('status','Jabatan Berhasil Dirubah');
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
        return redirect('/admin/position')->with('status','Jabatan Berhasil Dihapus');
    }
}
