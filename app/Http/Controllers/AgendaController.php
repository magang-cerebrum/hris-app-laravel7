<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class AgendaController extends Controller
{

    public function index()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            $agenda = MasterAgenda::paginate(10);
            return view('masterData.agenda.list',[
                'agenda'=>$agenda,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirct('/login');
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
            return view('masterData.agenda.create',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function store(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_date' => 'required',
                'calendar_color' => 'required'
            ]);
            MasterAgenda::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_event' => $request->start_date . " " . $request->start_time,
                'end_event' => $request->end_date . " " . $request->end_time,
                'calendar_color' => $request->calendar_color,
            ]);
            Alert::success('Berhasil!', 'Kegiatan baru telah ditambahkan!');
            return redirect('/admin/agenda');
        }
        else {
            return redirect('/login');
        }
    }

    public function edit(MasterAgenda $agenda)
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.agenda.edit',[
                'agenda' => $agenda,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function update(Request $request, MasterAgenda $agenda)
    {
        if(Auth::check()){
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_date' => 'required',
                'calendar_color' => 'required'
            ]);
            MasterAgenda::where('id',$agenda->id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_event' => $request->start_date . " " . $request->start_time,
                'end_event' => $request->end_date . " " . $request->end_time,
                'calendar_color' => $request->calendar_color,
            ]);
            Alert::success('Berhasil!', 'Kegiatan "' . $request->title . '" telah diperbaharui!');
            return redirect('/admin/agenda');
        }
        else {
            return redirect('/login');
        }
    }

    public function destroy(Request $request)
    {
        if(Auth::check()){
            foreach ($request->selectid as $item) {
                MasterAgenda::where('id',$item)->delete();
            }
            Alert::success('Berhasil!', 'Kegiatan terpilih berhasil dihapus!');
            return redirect('/admin/agenda');
        }
        else {
            return redirect('/login');
        }
    }

    public function search(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            if ($request->get('query') == null) {return redirect('/admin/agenda');}
            $user = Auth::user();
            $result = MasterAgenda::where(function ($query) use ($request){
                $query->whereRaw("title LIKE '%" . $request->get('query') . "%'")
                    ->orWhereRaw("description LIKE '%" . $request->get('query') . "%'")
                    ->orWhereRaw("start_event LIKE '" . $request->get('query') . "%'")
                    ->orWhereRaw("end_event LIKE '" . $request->get('query') . "%'");
            })
            ->paginate(10);
            return view('masterData.agenda.result',[
                'agenda' => $result,
                'search' => $request->get('query'),
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function searchCalendar()
    {
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            $user = Auth::user();
            return view('masterData.agenda.searchCalendar',[
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }

    public function calendar(Request $request){
        if(Auth::check()){
            $data = MasterAgenda::where(function ($query) use ($request){
                $query->whereRaw("start_event LIKE '" . $request->periode . "%'")
                    ->orWhereRaw("end_event LIKE '" . $request->periode . "%'");
            })
            ->get();
            
            return view('masterData.agenda.calendar',[
                'periode'=>$request->periode,
                'month'=>explode("-", $request->periode)[1],
                'year'=>explode("-", $request->periode)[0],
                'data' => $data,
            ]);
        }
        else {
            retrun redirect('/login');
        }
    }

    public function index_staff(){
        if(Auth::check()){
            $user = Auth::user();
            $data = MasterAgenda::where(function ($query){
                $query->whereRaw("start_event LIKE '" . date('Y-m') . "%'")
                    ->orWhereRaw("end_event LIKE '" . date('Y-m') . "%'");
            })
            ->get();
            return view('staff.agenda.calendar',[
                'month'=>date('m'),
                'year'=>date('Y'),
                'data' => $data,
                'name'=>$user->name,
                'profile_photo'=>$user->profile_photo,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }
        else {
            return redirect('/login');
        }
    }
}