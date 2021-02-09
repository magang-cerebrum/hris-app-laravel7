<?php

namespace App\Http\Controllers;

use App\MasterDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $division = MasterDivision::paginate(5);
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
        return redirect('/admin/division')->with('status','Divisi Berhasil Ditambahkan');
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
        MasterDivision::where('id', $division->id)
            ->update(['name' => $request->name]);
        return redirect('/admin/division')->with('status','Divisi Berhasil Dirubah');
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
        return redirect('/admin/division')->with('status','Divisi Berhasil Dihapus');
    }

    public function destroyAll(Request $request){
        foreach ($request->selectid as $item) {
            DB::table('master_divisions')->where('id','=',$item)->delete();
        }
        return redirect('/admin/division')->with('status','Data Divisi Terpilih Berhasil Dihapus');
    }

    // public function search(Request $request){

    //     if($request->ajax()){
    //         $output = '';
    //         $query = $request->get('query');

    //         if($query != ''){
    //             $data = DB::table('master_divisions')
    //                 ->where('name','like','%'.'$query'.'%')
    //                 ->orderBy('id','asc')
    //                 ->get();
    //         }
    //         else{
    //             $data = DB::table('master_divisions')
    //             ->orderBy('id','asc')
    //             ->get();
    //         }

    //         $total_row = $data->count();

    //         if($total_row > 0){
    //             foreach ($data as $row){
    //                 $output .= '
    //                 <tr>
    //                     <td>'.$row->id.'</td>
    //                     <td>'.$row->name.'</td>
    //                 </tr>
    //                 ';
    //             }
    //         }
    //         else{
    //             $output = '
    //             <tr>
    //                 <td class="text-center" colspan="3">Tidak Ada Data Ditemukan</td>
    //             </tr>
    //             ';
    //         }

    //         $data = array(
    //             'table_data' => $output,
    //         );
    //         echo json_encode($data);
    //     }
    // }
}
