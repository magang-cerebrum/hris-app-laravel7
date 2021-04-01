<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\MasterCutAllowanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CutAllowanceTypeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $cutallowancetype = MasterCutAllowanceType::paginate(10);
        return view('masterdata.cutallowancetype.list',[
            'cutallowancetype' => $cutallowancetype,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create(){
        $user = Auth::user();
        return view('masterdata.cutallowancetype.create',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category' => 'required'
        ]);
        MasterCutAllowanceType::create($request->all());
        Alert::success('Berhasil!', $request->category . ' gaji baru telah ditambahkan!');
        return redirect('/admin/cuts-allowances');
    }

    public function edit(MasterCutAllowanceType $type)
    {
        $user = Auth::user();
        return view('masterdata.cutallowancetype.edit',[
            'cutallowancetype' => $type,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function update(Request $request, MasterCutAllowanceType $type)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category' => 'required'
        ]);
        MasterCutAllowanceType::where('id',$type->id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category
        ]);
        Alert::success('Berhasil!', $type->category . ' gaji ' . $type->name .' berhasil diperbaharui!');
        return redirect('/admin/cuts-allowances');
    }

    public function destroy(Request $request){
        foreach ($request->selectid as $item) {
            MasterCutAllowanceType::where('id',$item)->delete();
        }
        Alert::success('Berhasil!', 'Tipe Potongan/Tunjangan gaji terpilih berhasil dihapus!');
        return redirect('/admin/cuts-allowances');
    }

    public function search(Request $request){
        if ($request->get('query') == null) {return redirect('/admin/cuts-allowances');}
        $user = Auth::user();
        $result = MasterCutAllowanceType::where(function ($query) use ($request){
            $query->whereRaw("name LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("type LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("category LIKE '%" . $request->get('query') . "%'");
        })
        ->paginate(10);
        
        return view('masterdata.cutallowancetype.result',[
            'cutallowancetype' => $result,
            'search' => $request->get('query'),
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
        
    }
}
