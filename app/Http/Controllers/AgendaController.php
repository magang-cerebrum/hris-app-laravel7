<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MasterAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AgendaController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $agenda = MasterAgenda::paginate(10);
        return view('masterdata.agenda.list',[
            'agenda'=>$agenda,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        return view('masterdata.agenda.create',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function store(Request $request)
    {
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

    public function edit(MasterAgenda $agenda)
    {
        $user = Auth::user();
        return view('masterdata.agenda.edit',[
            'agenda' => $agenda,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function update(Request $request, MasterAgenda $agenda)
    {
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

    public function destroy(Request $request)
    {
        foreach ($request->selectid as $item) {
            MasterAgenda::where('id',$item)->delete();
        }
        Alert::success('Berhasil!', 'Kegiatan terpilih berhasil dihapus!');
        return redirect('/admin/agenda');
    }

    public function search(Request $request){
        if ($request->get('query') == null) {return redirect('/admin/agenda');}
        $user = Auth::user();
        $result = MasterAgenda::where(function ($query) use ($request){
            $query->whereRaw("title LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("description LIKE '%" . $request->get('query') . "%'")
                ->orWhereRaw("start_event LIKE '" . $request->get('query') . "%'")
                ->orWhereRaw("end_event LIKE '" . $request->get('query') . "%'");
        })
        ->paginate(10);
        return view('masterdata.agenda.result',[
            'agenda' => $result,
            'search' => $request->get('query'),
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function searchCalendar()
    {
        $user = Auth::user();
        return view('masterdata.agenda.searchCalendar',[
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function calendar(Request $request){
        $user = Auth::user();
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
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }

    public function index_staff(){
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
}