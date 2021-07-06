<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;

class SettingController extends Controller
{
    public function index(){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $get = Setting::get();
            foreach ($get as $item) {
                $data[$item->name] = $item->value;
            }
            return view('masterData.setting.index',[
                'data' => $data,
                'menu'=>['m-sistem','s-setting'],
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

    public function save(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            if ($request->has('company_name')) {
                Setting::where('name','Nama Perusahaan')->update(['value' => $request->company_name]);
            }
            dd($request);
            if ($request->has('company_logo')) {
                $logo = $request->company_logo;
                $logo_name = "logo-cerebrum.PNG";
                $tujuan_upload = 'img/';
                $logo->move($tujuan_upload, $logo_name);
            }
            
            if ($request->has('payroll_date')) {
                Setting::where('name','Tanggal Gajian')->update(['value' => $request->payroll_date]);
            }

            if ($request->has('office_latitude')) {
                Setting::where('name','Latitude Kantor')->update(['value' => $request->office_latitude]);
            }

            if ($request->has('office_longitude')) {
                Setting::where('name','Longitude Kantor')->update(['value' => $request->office_longitude]);
            }

            Alert::success('Berhasil','Pengaturan baru berhasil tersimpan!');
            return redirect('/admin/setting');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
