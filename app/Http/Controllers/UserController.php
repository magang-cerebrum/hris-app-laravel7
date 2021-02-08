<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(MasterUser $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterUser $user)
    {
        return view('auth.editpass',['pass' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterUser $user)
    {
        if (Hash::check($request->oldpassword, $user->password)) {
            
            $request->validate([
                // 'oldpassword'=>User::get()->password,
                'newpassword'=>'required'
                ]);
        
           }
           else return back()->with('error','Password Lama Salah !');    

           
           if(Auth::user()->role_id == 1){
            MasterUser::Where('id',$user->id)->update([
                'password'=>Hash::make($request->newpassword)
            ]);
            return redirect('/admin/dashboard');
           }
           else{
            MasterUser::Where('id',$user->id)->update([
                'password'=>Hash::make($request->newpassword)
            ]);
            return redirect('/staff/dashboard');
           }
           
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterUser $user)
    {
        //
    }
}
