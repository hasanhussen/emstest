<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\User;
use Illuminate\Http\Request;

class medicalhistorycontroller extends Controller
{  public function addhistory(Request  $request)
    {
    $user = User::all()->where('api_token', $request->token)->first();
    if ($user->role == 'طبيب' ||  $user->role == 'admin') {

        $med = new MedicalHistory();
        $med->patient_id = $request->patient_id;
        $med->text = $request->text;
        $med->date = $request->date;
        $med->time =  $request->time;
        $med->user_id = $user->id;

        $med->save();
        $med->load('patient')->load('user');

        return response()->json($med, 200);
    } else {
        $message = [
            'body' => "المستخدم ليس له صلاحية "
        ];
        return response()->json($message, 403);
    }
}
public function update(Request  $request)
{
$user = User::all()->where('api_token', $request->token)->first();
if ($user->role == 'طبيب' ||  $user->role == 'admin') {

    $med =  MedicalHistory::where('id', $request->id)->first();
    $med->patient_id = $med->patient_id;
    $med->date = $request->date;
    $med->time =  $request->time;

 

    if(!empty($request->text)){
        $med->text = $request->text;
    
    }
    $med->user_id = $user->id;

    $med->save();
    $med->load('patient')->load('user');

    return response()->json($med, 200);
} else {
    $message = [
        'body' => "المستخدم ليس له صلاحية "
    ];
    return response()->json($message, 403);
}
}
public function remove(Request  $request)
{
$user = User::all()->where('api_token', $request->token)->first();
if ($user->role == 'طبيب' ||  $user->role == 'admin') {

    $med =MedicalHistory::where('id',$request->id)->first();


    $med->delete();
    $message = [
        'body' => " تم الحذف بنجاح  "
    ];

    return response()->json($message, 200);
} else {
    $message = [
        'body' => "المستخدم ليس له صلاحية "
    ];
    return response()->json($message, 403);
}
}
public function patient_medicalhistory(Request  $request)
{
    $user = User::where('api_token', $request->token)->first();


    if ($user->role == 'طبيب' ||  $user->role == 'admin') {
        $patientMed = MedicalHistory::where('patient_id', $request->patient_id)->get();
        $patientMed->load('patient')->load('user');

        return  $patientMed;
    } else {

        $message = [
            'body' => "المستخدم ليس له صلاحية "
        ];
        return response()->json($message, 403);
    }
}
}