<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\MasterCutAllowanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CutAllowanceTypeController extends Controller
{
    public function index(){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $cutallowancetype = MasterCutAllowanceType::paginate(10);

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.cutAllowanceType.list',[
                'menu'=>['m-master','s-master-ptgaji'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'cutallowancetype' => $cutallowancetype,
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

    public function create(){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.cutAllowanceType.create',[
                'menu'=>['m-master','s-master-ptgaji'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
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

    public function store(Request $request){
        if(Auth::check()){
            $request->validate([
                'name' => 'required',
                'type' => 'required',
                'category' => 'required'
            ]);
            MasterCutAllowanceType::create($request->all());
            Alert::success('Berhasil!', $request->category . ' gaji baru telah ditambahkan!');
            return redirect('/admin/cuts-allowances');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterCutAllowanceType $type)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.cutAllowanceType.edit',[
                'menu'=>['m-master','s-master-ptgaji'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'cutallowancetype' => $type,
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

    public function update(Request $request, MasterCutAllowanceType $type)
    {
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroy(Request $request){
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterCutAllowanceType::where('id',$item)->delete();
            }
            Alert::success('Berhasil!', 'Tipe Potongan/Tunjangan gaji terpilih berhasil dihapus!');
            return redirect('/admin/cuts-allowances');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function search(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            if ($request->get('query') == null) {return redirect('/admin/cuts-allowances');}
            $user = Auth::user();
            $result = MasterCutAllowanceType::where(function ($query) use ($request){
                $query->whereRaw("name LIKE '%" . $request->get('query') . "%'")
                    ->orWhereRaw("type LIKE '%" . $request->get('query') . "%'")
                    ->orWhereRaw("category LIKE '%" . $request->get('query') . "%'");
            })
            ->paginate(10);

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.cutAllowanceType.result',[
                'menu'=>['m-master','s-master-ptgaji'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'cutallowancetype' => $result,
                'search' => $request->get('query'),
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

    public function toogle_status(Request $request){
        if(Auth::check()){
            if ($request->status == 'Aktif') {$change = 'Non-Aktif';}
            else {$change = 'Aktif';}
            MasterCutAllowanceType::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change, 'category' => $request->category]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
