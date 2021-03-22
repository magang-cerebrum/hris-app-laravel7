<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\MasterSalaryAllowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SalaryAllowanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $salaryallowance = MasterSalaryAllowance::leftjoin('master_users','master_salary_allowances.user_id','=','master_users.id')
        ->select([
            'master_users.id as user_id',
            'master_users.name as user_name',
            'master_salary_allowances.*'
        ])
        ->paginate(10);
        return view('masterdata.salaryallowance.list',[
            'salaryallowance' => $salaryallowance,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
        return view('masterdata.salaryallowance.create', [
            'staff'=>$staff,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request)
    {
        if ($request->type == 'Semua') {
            $request->validate([
                'information' => 'required',
                'nominal' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            MasterSalaryAllowance::create([
                'information' => $request->information,
                'type' => $request->type,
                'nominal' => $nominal
            ]);
        } else {
            $request->validate([
                'information' => 'required',
                'range_month' => 'required',
                's_nominal' => 'required',
                'user_id' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->s_nominal);
            $month = date('m');
            $year = date('Y');
            for ($i=0; $i < $request->range_month; $i++) {
                MasterSalaryAllowance::create([
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
        Alert::success('Berhasil!', 'Tunjangan gaji baru telah ditambahkan!');
        return redirect('/admin/salary-allowance');
    }

    public function edit(MasterSalaryAllowance $allowance)
    {
        $user = Auth::user();
        $staff = DB::table('master_users')->where('status','=','Aktif')->select(['id','name'])->get();
        return view('masterdata.salaryallowance.edit',[
            'allowance' => $allowance,
            'staff' => $staff,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function update(Request $request, MasterSalaryAllowance $allowance)
    {
        if ($allowance->type == 'Semua') {
            $request->validate([
                'information' => 'required',
                'nominal' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            MasterSalaryAllowance::where('id','=',$allowance->id)
            ->update([
                'information' => $request->information,
                'nominal' => $nominal
            ]);
        } else {
            $request->validate([
                'information' => 'required',
                'month' => 'required',
                'nominal' => 'required',
                'user_id' => 'required'
            ]);
            $nominal = preg_replace('/[Rp. ]/','',$request->nominal);
            $split = explode('-',$request->month);
            MasterSalaryAllowance::where('id','=',$allowance->id)
            ->update([
                'information' => $request->information,
                'nominal' => $nominal,
                'month' => switch_month($split[0]),
                'year' => $split[1],
                'user_id' => $request->user_id
            ]);
        }
        Alert::success('Berhasil!', 'Tunjangan gaji '.$allowance->information.' berhasil diperbaharui!');
        return redirect('/admin/salary-allowance');
    }

    public function destroyAll(Request $request)
    {
        foreach ($request->selectid as $item) {
            MasterSalaryAllowance::where('id','=',$item)->delete();
        }
        Alert::success('Berhasil!', 'Tunjangan gaji yang dipilih berhasil dihapus!');
        return redirect('/admin/salary-allowance');
    }

    public function search(Request $request){
        if ($request->get('query') == null) {return redirect('/admin/salary-cut');}
        if (strpos($request->get('query'),'/')) {
            $split = explode('/',$request->get('query'));
            $data = MasterSalaryAllowance::leftjoin('master_users','master_salary_allowances.user_id','=','master_users.id')
            ->where("month",switch_month($split[0]))
            ->where("year",$split[1])
            ->select([
                'master_users.id as user_id',
                'master_users.name as user_name',
                'master_salary_allowances.*'
            ])
            ->paginate(10);
        } else {
            $check_user = DB::table('master_users')->select(['id','name'])
            ->whereRaw("name LIKE '%" . $request->get('query') . "%'")
            ->get();
            if (count($check_user) != 0) {
                foreach ($check_user as $item){$ids[] = $item->id;}
                $data = MasterSalaryAllowance::leftjoin('master_users','master_salary_allowances.user_id','=','master_users.id')
                ->whereIn("user_id",$ids)
                ->select([
                    'master_users.id as user_id',
                    'master_users.name as user_name',
                    'master_salary_allowances.*'
                ])->paginate(10);
            } else {
                $data = MasterSalaryAllowance::leftjoin('master_users','master_salary_allowances.user_id','=','master_users.id')
                ->whereRaw("information LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("nominal LIKE '%" . $request->get('query') . "%'")
                ->select([
                    'master_users.id as user_id',
                    'master_users.name as user_name',
                    'master_salary_allowances.*'
                ])
                ->paginate(10);
            }
        }
        $user =  Auth::user();

        return view('masterData.salaryallowance.result', [
            'salaryallowance' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->idate
        ]);
    }
}
