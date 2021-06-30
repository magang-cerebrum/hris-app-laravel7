<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionTicketing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;
class TransactionTicketingController extends Controller
{
    public function admin_index(){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            $ticketing = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->select(['transaction_ticketings.*','master_users.name'])
                ->whereIn('transaction_ticketings.status',['Dikirimkan','On Progress'])
                ->orderByDesc('created_at')
                ->paginate(10);
            $ticketing_done = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
            ->select(['transaction_ticketings.*','master_users.name'])
            ->where('transaction_ticketings.status','=','Selesai')
            ->orderByDesc('created_at')
            ->paginate(10);
            return view('masterData.transactionticketing.list',[
                'ticketing' => $ticketing,
                'done' => $ticketing_done,
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
    public function admin_edit(TransactionTicketing $ticket){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            elseif(Gate::allows('is_admin')){
            $user = Auth::user();
            $namanya = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->where('master_users.id','=',$ticket->user_id)
                ->select('master_users.name')
                ->first();
            $status = ['Dikirimkan','On Progress','Selesai'];
            return view('masterData.transactionticketing.edit',[
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
    public function admin_response(TransactionTicketing $ticket, Request $request){
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }

    public function admin_search(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_admin')){
                Alert::error('403 - Unauthorized', 'Halaman tersebut hanya bisa diakses oleh Admin!')->width(600);
                return back();
            }
            if ($request->get('query') == null) {return redirect('/admin/ticketing');}
            if (strpos($request->get('query'),'/')) {
                $split = explode('/',$request->get('query'));
                $ticketing = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->select(['transaction_ticketings.*','master_users.name'])
                ->whereIn('transaction_ticketings.status',['Dikirimkan','On Progress'])
                ->whereRaw("transaction_ticketings.created_at LIKE '".$split[1]."-".$split[0]."%'")
                ->orderByDesc('transaction_ticketings.created_at')
                ->paginate(10);
    
                $ticketing_done = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->select(['transaction_ticketings.*','master_users.name'])
                ->where('transaction_ticketings.status','=','Selesai')
                ->whereRaw("transaction_ticketings.created_at LIKE '".$split[1]."-".$split[0]."%'")
                ->orderByDesc('transaction_ticketings.created_at')
                ->paginate(10);
            } else {
                $ticketing = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->select(['transaction_ticketings.*','master_users.name'])
                ->whereIn('transaction_ticketings.status',['Dikirimkan','On Progress'])
                ->where(function ($query) use ($request){
                    $query->whereRaw("master_users.name LIKE '%" . $request->get('query') . "%'")
                        ->orWhereRaw("transaction_ticketings.category LIKE '%" . $request->get('query') . "%'")
                        ->orWhereRaw("transaction_ticketings.status LIKE '%" . $request->get('query') . "%'");
                })
                ->orderByDesc('transaction_ticketings.created_at')
                ->paginate(10);
    
                $ticketing_done = TransactionTicketing::leftJoin('master_users','master_users.id','=','user_id')
                ->select(['transaction_ticketings.*','master_users.name'])
                ->where('transaction_ticketings.status','=','Selesai')
                ->where(function ($query) use ($request){
                    $query->whereRaw("master_users.name LIKE '%" . $request->get('query') . "%'")
                        ->orWhereRaw("transaction_ticketings.category LIKE '%" . $request->get('query') . "%'")
                        ->orWhereRaw("transaction_ticketings.status LIKE '%" . $request->get('query') . "%'");
                })
                ->orderByDesc('transaction_ticketings.created_at')
                ->paginate(10);
            }
            $user =  Auth::user();
            return view('masterData.transactionticketing.result', [
                'ticketing' => $ticketing,
                'done' => $ticketing_done,
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

    public function staff_index(){
        if(Auth::check()){
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
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
    public function staff_create(){
        if(Auth::check()){
            if(Gate::denies('is_staff')){
                return abort(403,'Access Denied, Only Staff Can Access');
            }elseif(Gate::allows('is_staff')){
            $user = Auth::user();
            return view('staff.transactionticketing.createticket',['id'=>$user->id]);}
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
    public function staff_input(Request $request){
        if(Auth::check()){
            if(Gate::denies('is_staff')){
                return abort(403,'Access Denied, Only Staff Can Access');
            }
            elseif(Gate::allows('is_staff')){
                $request->validate([
                    'message' => 'required'
                ]);
                if($request->anon) {
                    $anonim = true;
                }
                else {
                    $anonim = false;
                }
                TransactionTicketing::create([
                    'is_anonim' => $anonim,
                    'user_id' => $request->user_id,
                    'message' => $request->message,
                    'category' => $request->category,
                ]);
                Alert::success('Berhasil!', 'Input Ticket baru berhasil!');
                return redirect('/staff/ticketing');
            }
        }
        else {
            Alert::info('Sesi berakhir!','Silahkan login kembali!');
            return redirect('/login');
        }
    }
}
