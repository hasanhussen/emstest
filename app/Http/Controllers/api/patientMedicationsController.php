<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PatientMedications;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class patientMedicationsController extends Controller
{
    public function add(Request  $request)
    {
    $user = User::all()->where('api_token', $request->token)->first();
    if ($user->role == 'طبيب' ||  $user->role == 'admin') {

        $patientMed = new PatientMedications();
        $patientMed->patient_id = $request->patient_id;
        $patientMed->med_id = $request->med_id;
        $patientMed->note = $request->note;
        $patientMed->dose = $request->dose;
        $patientMed->dosage_amount1 = $request->dosage_amount1;
        $patientMed->dosage_amount2 =  $request->dosage_amount2;
        $patientMed->date = $request->date;
        $patientMed->date1 =  $request->date1;
        $patientMed->time =  $request->time;
     
        $patientMed->state = $request->state;
        $patientMed->details = $request->details;
        $patientMed->doctor_id = $user->id;

        $patientMed->save();
        $patientMed->load('patient')->load('doctor')->load('medication');

        return response()->json($patientMed, 200);
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

    $patientMed =  PatientMedications::where('id', $request->id)->first();
    $patientMed->patient_id = $patientMed->patient_id;
    $patientMed->med_id = $request->med_id;
    $patientMed->dose = $request->dose;
    $patientMed->dosage_amount1 = $request->dosage_amount1;
    $patientMed->dosage_amount2 =  $request->dosage_amount2;
    $patientMed->date = $request->date;

        $patientMed->date1 =  $request->date1;


        $patientMed->time =  $request->time;

 

    $patientMed->state = $request->state;
    if(!empty($request->note)){
        $patientMed->note = $request->note;
    }
    if(!empty($request->details)){
        $patientMed->details = $request->details;
    }
    $patientMed->doctor_id = $user->id;

    $patientMed->save();
    $patientMed->load('patient')->load('doctor')->load('medication');

    return response()->json($patientMed, 200);
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

    $patientMed =PatientMedications::where('id',$request->id)->first();


    $patientMed->delete();

    return response()->json($patientMed, 200);
} else {
    $message = [
        'body' => "المستخدم ليس له صلاحية "
    ];
    return response()->json($message, 403);
}
}
public function urgentMedications(Request  $request)
{
    $user = User::where('api_token', $request->token)->first();


    if ($user->role == 'طبيب' ||  $user->role == 'admin') {
        $patientMed = PatientMedications::where('patient_id', $request->patient_id)->where('state', 0)->get();
        $patientMed->load('patient')->load('doctor')->load('medication');

        return  $patientMed;
    } else {

        $message = [
            'body' => "المستخدم ليس له صلاحية "
        ];
        return response()->json($message, 403);
    }
}
public function currentMedications(Request  $request)
{
    $user = User::where('api_token', $request->token)->first();


    if ($user->role == 'طبيب' ||  $user->role == 'admin') {
        $patientMed = PatientMedications::where('patient_id', $request->patient_id)->where('state', 1)->get();
        $patientMed->load('patient')->load('doctor')->load('medication');

        return  $patientMed;
    } else {

        $message = [
            'body' => "المستخدم ليس له صلاحية "
        ];
        return response()->json($message, 403);
    }
}
public function CanceledMedications(Request  $request)
{
    $user = User::where('api_token', $request->token)->first();


    if ($user->role == 'طبيب' ||  $user->role == 'admin') {
        $patientMed = PatientMedications::where('patient_id', $request->patient_id)->where('state', 2)->get();
        $patientMed->load('patient')->load('doctor')->load('medication');

        return  $patientMed;
    } else {

        $message = [
            'body' => "المستخدم ليس له صلاحية "
        ];
        return response()->json($message, 403);
    }
}
}
