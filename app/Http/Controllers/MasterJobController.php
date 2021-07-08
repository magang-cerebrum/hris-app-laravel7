<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJobRecruitment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MasterJobController extends Controller
{
    public function index()
    {
        $data = MasterJobRecruitment::all();
        return response()->json($data, 200);
    }

    public function indexJob()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $dataJob = MasterJobRecruitment::paginate(5);
            $user = Auth::user();
            
            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.job.list', [
                'menu'=>['m-rekruitasi','s-rekruitasi-lowongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'dataJob' => $dataJob,
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

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.job.create', [
                'menu'=>['m-rekruitasi','s-rekruitasi-lowongan'],
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

    public function store(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'name'=>'required',
                'descript'=>'required',
                'required'=>'required'
            ]);
            
            MasterJobRecruitment::create($request->all());
            $user = Auth::user()->name;
            activity()->log('Admin ' .$user.' Telah menambahkan Lowongan ' . $request->name . " bagian " . $request->descript);
            Alert::success('Berhasil!', 'Lowongan baru telah ditambahkan!');
            return redirect('/admin/job');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterJobRecruitment $job)
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
            
            return view('masterData.job.edit',[
                'menu'=>['m-rekruitasi','s-rekruitasi-lowongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'job' => $job,
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

    public function update(Request $request, MasterJobRecruitment $job)
    {
        if(Auth::check()){
            $request->validate([
                'name'=>'required',
                'descript'=>'required',
                'required'=>'required'
            ]);
            MasterJobRecruitment::where('id', $job->id)->update([
                'name' => $request->name,
                'descript' => $request->descript,
                'required' => $request->required
            ]);
            Alert::success('Berhasil!', 'Lowongan Kerja '. $job->name . ' telah diupdate!');
            return redirect('/admin/job');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroy(Request $request)
    {
        if(Auth::check()){
            $ids = $request->input('check');
            foreach($ids as $deletes) {
                $data= MasterJobRecruitment::where("id",$deletes)->first();
                $data->delete();
            }
            $user = Auth::user()->name;
            activity()->log('Admin ' .$user.' Telah menghapus Lowongan ' . $data->name  . " bagian " . $data->descript);
            Alert::success('Berhasil!', 'Lowongan yang dipilih berhasil dihapus!');
            return redirect('/admin/job');
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
            MasterJobRecruitment::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change]);
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
            if ($request->get('query') == null) {return redirect('/admin/job');}
            $user = Auth::user();
            $data = MasterJobRecruitment::whereRaw("name LIKE '%" . $request->get('query') . "%'")
            ->orWhereRaw("descript LIKE '%" . $request->get('query') . "%'")
            ->orWhereRaw("required LIKE '%" . $request->get('query') . "%'")
            ->paginate(5);

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.job.result',[
                'searched' => $request->get('query'),
                'menu'=>['m-rekruitasi','s-rekruitasi-lowongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'dataJob' => $data,
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
}
