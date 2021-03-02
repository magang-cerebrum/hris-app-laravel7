<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionTicketing;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
class TransactionTicketingController extends Controller
{
    public function admin_index(){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
        $user = Auth::user();
        $ticketing = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
            ->select(['transaction_ticketings.*','master_users.name'])
            ->orderByDesc('created_at')
            ->get();
        
        return view('masterdata.transactionticketing.list',[
            'ticketing' => $ticketing,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
    }
    }
    public function admin_edit(TransactionTicketing $ticket){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
        $user = Auth::user();
        $namanya = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
            ->where('master_users.id','=',$ticket->user_id)
            ->select('master_users.name')
            ->get();
        $status = ['Dikirimkan','On Progress','Selesai'];
        return view('masterdata.transactionticketing.edit',[
            'ticketing' => $ticket,
            'sender' => $namanya,
            'status' => $status,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);
        }
    }
    public function admin_response(TransactionTicketing $ticket, Request $request){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')){
        $request->validate(['status' => 'required']);
        TransactionTicketing::where('id', $ticket->id)
            ->update([
                'status' => $request->status,
                'response' => $request->response,
            ]);
            Alert::success('Berhasil!', 'Respon untuk ticket dengan ID '. $ticket->id . ' berhasil dikirim!');
        return redirect('/admin/ticketing');
            }
    }
    public function make_on_progress(Request $request){
        if(Gate::denies('is_admin')){
            return abort(403,'Access Denied, Only Admin Can Access');
        }
        elseif(Gate::allows('is_admin')) {
            if ($request->selectid[0] != '') {
                foreach ($request->selectid as $item) {
                    TransactionTicketing::where('id', $item)->update([
                        'status' => 'On Progress',
                        'response' => 'Ticket sedang dalam tahap pengerjaan, mohon ditunggu ya kak :)'
                    ]);
                }
            } else {
                foreach ($request->selectid_full as $item) {
                    TransactionTicketing::where('id', $item)->update([
                        'status' => 'On Progress',
                        'response' => 'Ticket sedang dalam tahap pengerjaan, mohon ditunggu ya kak :)'
                    ]);
                }
            }
        
        Alert::success('Berhasil!', 'Ticket dengan ID terpilih sekarang berstatus On Progress');
        return redirect('/admin/ticketing');
    }
    }
    public function staff_index(){
        if(Gate::denies('is_staff')){
            return abort(403,'Access Denied, Only Staff Can Access');
        }
        elseif(Gate::allows('is_staff')) {
        $user = Auth::user();
        $ticketing = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
            ->where('user_id','=',$user->id)
            ->select(['transaction_ticketings.*','master_users.name'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('staff.transactionticketing.history',[
            'ticketing' => $ticketing,
            'name'=>$user->name,
            'profile_photo'=>$user->profile_photo,
            'email'=>$user->email,
            'id'=>$user->id
        ]);}
    }
    public function staff_create(){
        if(Gate::denies('is_staff')){
            return abort(403,'Access Denied, Only Staff Can Access');
        }elseif(Gate::allows('is_staff')){
        $user = Auth::user();
        return view('staff.transactionticketing.createticket',['id'=>$user->id]);}
    }
    public function staff_input(Request $request){
        if(Gate::denies('is_staff')){
            return abort(403,'Access Denied, Only Staff Can Access');
        }
        elseif(Gate::allows('is_staff')){
        $request->validate([
            'message' => 'required'
        ]);
        TransactionTicketing::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'category' => $request->category,
        ]);
        Alert::success('Berhasil!', 'Input Ticket baru berhasil!');
        return redirect('/staff/ticketing');}
    }
    
}
