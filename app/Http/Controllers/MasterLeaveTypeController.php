<?php

namespace App\Http\Controllers;
use App\MasterLeaveType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MasterLeaveTypeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }elseif(Gate::allows('is_admin')){
                $user = Auth::user();
                $leavetype = MasterLeaveType::paginate(5);

                $company = DB::table('settings')->get();
                foreach ($company as $item) {
                    $company_data[$item->name] = $item->value;
                }
                
                return view('masterData.leavetype.list',[
                    'menu'=>['m-master','s-master-cuti'],
                    'company_name'=>$company_data['Nama Perusahaan'],
                    'company_logo'=>$company_data['Logo Perusahaan'],
                    'leavetype'=>$leavetype,
                    'name'=>$user->name,
                    'profile_photo'=>$user->profile_photo,
                    'email'=>$user->email,
                    'id'=>$user->id
                ]);
            }
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
            }elseif(Gate::allows('is_admin')){
                $user = Auth::user();

                $company = DB::table('settings')->get();
                foreach ($company as $item) {
                    $company_data[$item->name] = $item->value;
                }
                
                return view('masterData.leavetype.create',[
                    'menu'=>['m-master','s-master-cuti'],
                    'company_name'=>$company_data['Nama Perusahaan'],
                    'company_logo'=>$company_data['Logo Perusahaan'],
                    'name'=>$user->name,
                    'profile_photo'=>$user->profile_photo,
                    'email'=>$user->email,
                    'id'=>$user->id
                ]);
            }
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
                'default_day'=>'required|numeric'
            ]);
            MasterLeaveType::create($request->all());
            $user = Auth::user()->name;
            activity()->log($user.' telah menambahkan tipe cuti baru' .'('. $request->name.')');
            Alert::success('Berhasil!', 'Tipe Cuti baru telah ditambahkan!');
            return redirect('/admin/paid-leave-type');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterLeaveType $leavetype)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }elseif(Gate::allows('is_admin')){
                $user = Auth::user();

                $company = DB::table('settings')->get();
                foreach ($company as $item) {
                    $company_data[$item->name] = $item->value;
                }
                
                return view('masterData.leavetype.edit',[
                    'menu'=>['m-master','s-master-cuti'],
                    'company_name'=>$company_data['Nama Perusahaan'],
                    'company_logo'=>$company_data['Logo Perusahaan'],
                    'cuti' => $leavetype,
                    'name'=>$user->name,
                    'profile_photo'=>$user->profile_photo,
                    'email'=>$user->email,
                    'id'=>$user->id
                ]);
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function update(Request $request, MasterLeaveType $leavetype)
    {
        if(Auth::check()){
            $request->validate([
                'name'=>'required',
                'default_day'=>'required|numeric'
            ]);
            $past = MasterLeaveType::where('id',$leavetype->id)->get();
            MasterLeaveType::where('id',$leavetype->id)->update([
                'name'=>$request->name,
                'default_day'=>$request->default_day
            ]);
            $user = Auth::user()->name;
            activity()->log($user.' telah memperbarui tipe cuti '.'(' .$past[0]->name .')'.' ('.$past[0]->default_day.' hari)'. ' menjadi '.$request->name . ' ('.$request->default_day.' hari)');
            Alert::success('Berhasil!', 'Tipe Cuti '. $leavetype->name . ' berhasil diperbaharui');
            return redirect('admin/paid-leave-type');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroyAll(Request $request){
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterLeaveType::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Tipe Cuti yang dipilih berhasil dihapus!');
            return redirect('/admin/paid-leave-type');
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
            MasterLeaveType::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
