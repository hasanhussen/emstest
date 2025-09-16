<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()){

            return redirect()->route('user-login');
        }
        $user = Auth()->user();
return view('web.auth.profile',compact('user')) ;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);
        return view('web.auth.profile',compact('user')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()){

            return redirect()->route('user-login');
        }
        $user = User::where('id',$id)->first();
return view('web.auth.editProfile',compact('user')) ;
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
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->birthday = $request->input('birthday');
        $user->gender = $request->input('gender');
        $user->height = $request->input('height');
        $user->phone = $request->input('phone');
        $user->weight = $request->input('weight');
        $user->instagram = $request->input('instagram');
        $user->role =$user->role ;
        $user->facebook = $request->input('facebook');

        $user->password=    $user->password;

        if($request-> hasFile('avatar')){
            $filename = "users/uploads/". time() . '.' . $request->file('avatar')->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('', $filename, 'public');
                $user->avatar=$path;
            }

if($request-> hasFile('after')){
    $filename = "users/uploads/". time() . '.' . $request->file('after')->getClientOriginalName();
    $path = $request->file('after')->storeAs('', $filename, 'public');
    $user->after=$path;

}

if($request-> hasFile('before')){
    $filename = "users/uploads/". time() . '.' . $request->file('before')->getClientOriginalName();
    $path = $request->file('before')->storeAs('', $filename, 'public');
    $user->before=$path;

}
        $user->save();
        return redirect()->route('userProfile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
