<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\MasterSalaryCut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class SalaryCutController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $salarycut = MasterSalaryCut::leftjoin('master_users','master_salary_cuts.user_id','=','master_users.id')
            ->select([
                'master_users.id as user_id',
                'master_users.name as user_name',
                'master_salary_cuts.*'
            ])
            ->paginate(10);

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.salarycut.list',[
                'menu'=>['m-data','s-data-potongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'salarycut' => $salarycut,
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
            $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
            $data_type = DB::table('master_cut_allowance_types')->where('category','Potongan')->where('status','Aktif')->get();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.salarycut.create', [
                'menu'=>['m-data','s-data-potongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'data_type'=>$data_type,
                'staff'=>$staff,
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
                'type' => 'required',
                'information' => 'required',
                'nominal' => 'required_unless:type,Perorangan',
                'user_id' => 'required_if:type,Perorangan',
                'range_month'=> 'required_if:type,Perorangan',
                's_nominal'=> 'required_if:type,Perorangan'
            ]);
            if ($request->type == 'Semua') {
                $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
                MasterSalaryCut::create([
                    'information' => $request->information,
                    'type' => $request->type,
                    'nominal' => $nominal
                ]);
            } else {
                $nominal = preg_replace('/[Rp. ]/','',$request->s_nominal);
                $month = date('m');
                $year = date('Y');
                for ($i=0; $i < $request->range_month; $i++) {
                    MasterSalaryCut::create([
                        'information' => $request->information,
                        'type' => $request->type,
                        'nominal' => $nominal,
                        'month' => switch_month($month),
                        'year' => $year,
                        'user_id' => $request->user_id
                    ]);
                    if ($month == 12) { 
                        $month = 01;
                        $year++;
                    } else $month++;
                }
            }
            Alert::success('Berhasil!', 'Potongan gaji baru telah ditambahkan!');
            return redirect('/admin/salary-cut');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function edit(MasterSalaryCut $cut)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
            $data_type = DB::table('master_cut_allowance_types')->where('category','Potongan')->where('status','Aktif')->get();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.salarycut.edit',[
                'menu'=>['m-data','s-data-potongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'data_type'=>$data_type,
                'cut' => $cut,
                'staff' => $staff,
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

    public function update(Request $request, MasterSalaryCut $cut)
    {
        if(Auth::check()){
            $request->validate([
                'information' => 'required',
                'nominal' => 'required',
                'periode' => 'required_if:type,Perorangan',
                'user_id' => 'required_if:type,Perorangan',
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            if ($cut->type == 'Semua') {
                MasterSalaryCut::where('id','=',$cut->id)
                ->update([
                    'information' => $request->information,
                    'nominal' => $nominal
                ]);
            } else {
                $split = explode('-',$request->periode);
                MasterSalaryCut::where('id','=',$cut->id)
                ->update([
                    'information' => $request->information,
                    'nominal' => $nominal,
                    'month' => switch_month($split[0]),
                    'year' => $split[1],
                    'user_id' => $request->user_id
                ]);
            }
            Alert::success('Berhasil!', 'Potongan gaji '.$cut->information.' berhasil diperbaharui!');
            return redirect('/admin/salary-cut');
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function destroyAll(Request $request)
    {
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterSalaryCut::where('id','=',$item)->delete();
            }
            Alert::success('Berhasil!', 'Potongan gaji yang dipilih berhasil dihapus!');
            return redirect('/admin/salary-cut');
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
            if ($request->get('query') == null) {return redirect('/admin/salary-cut');}
            if (strpos($request->get('query'),'/')) {
                $split = explode('/',$request->get('query'));
                $data = MasterSalaryCut::leftjoin('master_users','master_salary_cuts.user_id','=','master_users.id')
                ->where("month",switch_month($split[0]))
                ->where("year",$split[1])
                ->select([
                    'master_users.id as user_id',
                    'master_users.name as user_name',
                    'master_salary_cuts.*'
                ])
                ->paginate(10);
            } else {
                $check_user = DB::table('master_users')->select(['id','name'])
                ->whereRaw("name LIKE '%" . $request->get('query') . "%'")
                ->get();
                if (count($check_user) != 0) {
                    foreach ($check_user as $item){$ids[] = $item->id;}
                    $data = MasterSalaryCut::leftjoin('master_users','master_salary_cuts.user_id','=','master_users.id')
                    ->whereIn("user_id",$ids)
                    ->select([
                        'master_users.id as user_id',
                        'master_users.name as user_name',
                        'master_salary_cuts.*'
                    ])->paginate(10);
                } else {
                    $data = MasterSalaryCut::leftjoin('master_users','master_salary_cuts.user_id','=','master_users.id')
                    ->whereRaw("information LIKE '%" . $request->get('query') . "%'")
                    ->orWhereRaw("nominal LIKE '%" . $request->get('query') . "%'")
                    ->select([
                        'master_users.id as user_id',
                        'master_users.name as user_name',
                        'master_salary_cuts.*'
                    ])
                    ->paginate(10);
                }
            }
            $user =  Auth::user();

            $company = DB::table('settings')->get();
            foreach ($company as $item) {
                $company_data[$item->name] = $item->value;
            }
            
            return view('masterData.salarycut.result', [
                'menu'=>['m-data','s-data-potongan'],
                'company_name'=>$company_data['Nama Perusahaan'],
                'company_logo'=>$company_data['Logo Perusahaan'],
                'search' => $request->get('query'),
                'salarycut' => $data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->idate
            ]);
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
