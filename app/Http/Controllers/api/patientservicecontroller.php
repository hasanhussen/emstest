<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PatientService;
use App\Models\User;
use Illuminate\Http\Request;

class patientservicecontroller extends Controller
{
    public function addservice(Request  $request)
    {
    $user = User::all()->where('api_token', $request->token)->first();
    if (is_null($user)){
        $message = [
            'body' => "المستخدم لم يقم بتسجيل الدخول "
        ];
        return response()->json($message, 403);
      
    } else {
    
        $service = new PatientService();
        $service->patient_id = $request->patient_id;
        $service->service_id = $request->service_id;
        $service->text = $request->text;
        $service->date = $request->date;
        $service->time =  $request->time;
        $service->user_id = $user->id;
        $service->save();
        $service->load('patient')->load('user')->load('service');

        return response()->json($service, 200);
    }
}
public function update(Request  $request)
{
$user = User::all()->where('api_token', $request->token)->first();
if (is_null($user)){
    $message = [
        'body' => "المستخدم لم يقم بتسجيل الدخول "
    ];
    return response()->json($message, 403);
   
} else {
    $service =  PatientService::where('id', $request->id)->first();
    $service->patient_id = $service->patient_id;
    $service->service_id = $request->service_id;
    if(!empty($request->text)){
        $service->text = $request->text;    }
 
    $service->date = $request->date;
    $service->time =  $request->time;
    $service->user_id = $user->id;
    $service->save();
    $service->load('patient')->load('user')->load('service');

    return response()->json($service, 200);

    
}
}
public function remove(Request  $request)
{
$user = User::all()->where('api_token', $request->token)->first();
if (is_null($user)){
    $message = [
        'body' => "المستخدم لم يقم بتسجيل الدخول "
    ];
    return response()->json($message, 403);
} else {

    
    $service =PatientService::where('id',$request->id)->first();


    $service->delete();
    $message = [
        'body' => " تم الحذف بنجاح  "
    ];
    return response()->json($message, 200);
}
}

public function patient_services(Request  $request)
{
    $user = User::all()->where('api_token', $request->token)->first();
if (is_null($user)){
    $message = [
        'body' => "المستخدم لم يقم بتسجيل الدخول "
    ];
    return response()->json($message, 403);
} else {



        $service = PatientService::where('patient_id', $request->patient_id)->where('service_id',$request->service_id)->get();
        $service->load('patient')->load('user')->load('service');

        return  $service;}
   
}
public function all_patient_services(Request  $request)
{


    $user = User::all()->where('api_token', $request->token)->first();
    if (is_null($user)){
        $message = [
            'body' => "المستخدم لم يقم بتسجيل الدخول "
        ];
        return response()->json($message, 403);
    } else {

        $service = PatientService::where('patient_id', $request->patient_id)->get();
        $service->load('patient')->load('user')->load('service');

        return  $service;}
    
}
}
