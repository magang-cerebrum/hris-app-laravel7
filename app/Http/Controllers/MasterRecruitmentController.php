<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterRecruitment;
use App\MasterJobRecruitment;
use Asset\upload_recruitment\cv_upload;
use Asset\upload_recruitment\portofolio_upload;
use RealRashid\SweetAlert\Facades\Alert;

class MasterRecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = MasterRecruitment::paginate(10);
        return view('masterData.recruitment.listRecruitment', [
            'data' => $data,
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
        return view('recruitment.recruitment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'born_in'=>'required',
            'dob'=>'required',
            'address'=>'required',
            'phone_number'=>'required|numeric',
            'email'=>'required|email',
            'gender'=>'required',
            'last_education'=>'required',
            'position'=>'required',
            'file_cv'=>'file|required',
            'file_portofolio'=>'file|required'
        ]);

        $dob = $request->born_in . ', ' .$request->dob;
        
        date_default_timezone_set('Asia/Jakarta');

        $cv = $request->file('file_cv');
        $cv_name = "cv_" . $request->name . "_" . date('Y-m-d H-i-s') . "." . $cv->getClientOriginalExtension();
        $tujuan_upload = 'upload_recruitment/cv_upload';
        $cv->move($tujuan_upload, $cv_name);

        $portofolio = $request->file('file_portofolio');
        $portofolio_name = "portofolio_" . $request->name . "_" . date('Y-m-d H-i-s') . "." . $cv->getClientOriginalExtension();
        $tujuan_upload = 'upload_recruitment/portofolio_upload';
        $portofolio->move($tujuan_upload, $portofolio_name);

        $insert_data = new MasterRecruitment;
        $insert_data->name = $request->name;
        $insert_data->dob = $dob;
        $insert_data->address = $request->address;
        $insert_data->phone_number = $request->phone_number;
        $insert_data->email = $request->email;
        $insert_data->gender = $request->gender;
        $insert_data->last_education = $request->last_education;
        $insert_data->position = $request->position;
        $insert_data->file_cv = $cv_name;
        $insert_data->file_portofolio = $portofolio_name;
        $insert_data->save();

        return response()->json([
            'status' => 'success',
            'data' => $insert_data
        ], 200);

        activity()->log('Seorang pelamar telah mengisi form rekruitasi untuk posisi' .' '. $request->position);
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->input('check');
        
        foreach($ids as $deletes) {
            $data= MasterRecruitment::where("id",$deletes)->first();

            $path_cv = 'upload_recruitment/cv_upload/'.$data->file_cv;
            $file_path_cv = public_path($path_cv);
            unlink($file_path_cv);

            $path_porto = 'upload_recruitment/portofolio_upload/'.$data->file_portofolio;
            $file_path_porto = public_path($path_porto);
            unlink($file_path_porto);

            $data->delete();
        }
        Alert::success('Berhasil!', 'Data pelamar terpilih berhasil dihapus!');
        return redirect('/admin/recruitment');
    }
    public function search(Request $request){
        if ($request->get('query') == null) {return redirect('/admin/recruitment');}
        $user = Auth::user();
        $data = MasterRecruitment::whereRaw("name LIKE '%" . $request->get('query') . "%'")
        ->orWhereRaw("position LIKE '%" . $request->get('query') . "%'")
        ->orWhereRaw("last_education LIKE '%" . $request->get('query') . "%'")
        ->paginate(10);
        return view('masterdata.recruitment.resultRecruitment',[
            'data' => $data,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }
}
