<?php

namespace App\Http\Controllers;

use App\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $shift = MasterShift::get();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.shift.list',[
                'menu'=>['m-master','s-master-shift'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'shift' => $shift,
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
            
            return view('masterData.shift.create', [
                'menu'=>['m-master','s-master-shift'],
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
            $user = Auth::user()->name;
            $request->validate([
                'name' => 'required',
                'start_working_time' => 'required',
                'end_working_time' => 'required',
                'calendar_color' => 'required'
            ]);
    
            $jumlah_jam = date_diff(date_create($request->start_working_time), date_create($request->end_working_time));
            $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);
            
            MasterShift::create([
                'name' => $request->name,
                'start_working_time' => $request->start_working_time,
                'end_working_time' => $request->end_working_time,
                'calendar_color' => $request->calendar_color,
                'total_hour' => $interval
            ]);
    
            activity()->log('Data ' .$request->name.' baru telah ditambahkan oleh '.$user);
            Alert::success('Berhasil!', 'Shift baru telah ditambahkan!');
            return redirect('/admin/shift');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterShift $shift)
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
            
            return view('masterData.shift.edit',[
                'menu'=>['m-master','s-master-shift'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'shift' => $shift,
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

    public function update(Request $request, MasterShift $shift)
    {
        if(Auth::check()){
            $user = Auth::user()->name;
            $past = MasterShift::where('id',$shift->id)->get();
            $request->validate([
                'name' => 'required',
                'start_working_time' => 'required',
                'end_working_time' => 'required',
                'calendar_color' => 'required'
            ]);
    
            $jumlah_jam = date_diff(date_create($request->start_working_time), date_create($request->end_working_time));
            $interval = $jumlah_jam->format('%h') + ($jumlah_jam->format('%i') / 60);
            
            MasterShift::where('id', $shift->id)
                ->update([
                    'name' => $request->name,
                    'start_working_time' => $request->start_working_time,
                    'end_working_time' => $request->end_working_time,
                    'calendar_color' => $request->calendar_color,
                    'total_hour' => $interval
                ]);
            activity()->log($user.' telah memperbarui  ' .$past[0]->name .' ('.$past[0]->start_working_time.'-'.$past[0]->end_working_time.') '.' menjadi '.$request->name .' ('.$request->start_working_time.'-'.$request->end_working_time.') ' );    
            Alert::success('Berhasil!', 'Shift '. $shift->name . ' telah diperbaharui!');
            return redirect('/admin/shift');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroySelected(Request $request){
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterShift::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Shift yang dipilih berhasil dihapus!');
            return redirect('/admin/shift');
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
            MasterShift::where('id', $request->id)->update(['status' => $change]);
            return response()->json(['name'=> $request->name, 'status' => $change]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
