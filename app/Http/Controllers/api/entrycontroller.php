<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\Request;

class entrycontroller extends Controller
{   
     public function add(Request  $request)
    {
    $user = User::all()->where('api_token', $request->token)->first();
 

    $entry = new Entry();
    $entry->patient_id = $request->patient_id;
  
    $entry->state = $request->state;
    $entry->exit_date =  $request->exit_date;
    $entry->date = $request->date;
    $entry->cause =  $request->cause;

    $entry->user_id = $user->id;

    $entry->save();
    $entry->load('patient')->load('user');

    return response()->json($entry, 200);}
}
