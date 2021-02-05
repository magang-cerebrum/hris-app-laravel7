<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\MasterRecruitment;

class MasterRecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterRecruitment::paginate(5);
        return view('masterData.adminRecruitment', ['data' => $data]);
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
            'name'=>'required|alpha',
            'born_in'=>'required',
            'dob'=>'required',
            'live_at'=>'required',
            'phone_number'=>'required|numeric',
            'email'=>'required|email',
            'gender'=>'required',
            'last_education'=>'required',
            'position'=>'required',
            'file_cv'=>'required',
            'file_portofolio'=>'required'
        ]);

        $dob = $request->born_in . ', ' .$request->dob;
        
        date_default_timezone_set('Asia/Jakarta');

        $cv = $request->file('file_cv');
        $cv_name = "cv_" . $request->name . "_" . date('Y-m-d H-i-s') . "." . $cv->getClientOriginalExtension();
        $tujuan_upload = public_path(cv_upload);
        $cv->move($tujuan_upload, $cv_name);

        $portofolio = $request->file('file_portofolio');
        $portofolio_name = "portofolio_" . $request->name . "_" . date('Y-m-d H-i-s') . "." . $cv->getClientOriginalExtension();
        $tujuan_upload = public_path(portofolio_upload);
        $portofolio->move($tujuan_upload, $portofolio_name);


        MasterRecruitment::create([
            'name'=>$request->name,
            'dob'=>$dob,
            'live_at'=>$request->live_at,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'gender'=>$request->gender,
            'last_education'=>$request->last_education,
            'position'=>$request->position,
            'file_cv'=>$cv_name,
            'file_portofolio'=>$portofolio_name
        ]);

        
        
        return redirect('/success');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterRecruitment $recruitment)
    {
        $path_cv = 'cv_upload/'.$recruitment->file_cv;
        $file_path_cv = public_path($path_cv);
        unlink($file_path_cv);

        $path_porto = 'portofolio_upload/'.$recruitment->file_portofolio;
        $file_path_porto = public_path($path_porto);
        unlink($file_path_porto);

        MasterRecruitment::destroy($recruitment->id);
        return redirect('/admin/recruitment');
    }
}
