<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;

class transfercontroller extends Controller
{
    public function add(Request  $request)
    {
    $user = User::all()->where('api_token', $request->token)->first();
 

        $transfer = new Transfer();
        $transfer->patient_id = $request->patient_id;
      
        $transfer->to = $request->to;
        $transfer->from =  $request->from;
        $transfer->date = $request->date;
        $transfer->time =  $request->time;
   
        $transfer->user_id = $user->id;

        $transfer->save();
        $transfer->load('patient')->load('user');

        return response()->json($transfer, 200);
   
}
}
