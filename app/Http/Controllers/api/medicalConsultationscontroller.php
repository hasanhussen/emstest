<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MedicalConsultation;
use App\Models\User;
use Illuminate\Http\Request;

class medicalConsultationscontroller extends Controller
{
    public function add(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();

        if ($user->role == 'طبيب' ||  $user->role == 'admin') {

            $consultation = new MedicalConsultation();


            $consultation->patient_id = $request->patient_id;
            $consultation->clinic_id = $request->clinic_id;
            $consultation->doctor_id2 = $request->doctor_id2;
            $consultation->consultation = $request->consultation;
            $consultation->severity = $request->severity;
            $consultation->doctor_id = $user->id;

            $consultation->save();
            $consultation->load('patient')->load('doctor')->load('clinic')->load('doctor2');

            return response()->json($consultation, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }

    public function index(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $consultation = MedicalConsultation::where('patient_id', $request->patient_id)->get();
            $consultation->load('patient')->load('doctor')->load('clinic')->load('doctor2');

            return  $consultation;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function consultation_requests(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $consultation = MedicalConsultation::where('patient_id', $request->patient_id)->where('doctor_id2', $user->id)->get();
            $consultation->load('patient')->load('doctor')->load('clinic')->load('doctor2');

            return  $consultation;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function my_consultations(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $consultation = MedicalConsultation::where('patient_id', $request->patient_id)->where('doctor_id', $user->id)->get();
            $consultation->load('patient')->load('doctor')->load('clinic')->load('doctor2');

            return  $consultation;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function remove(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $consultation = MedicalConsultation::where('id', $request->id)->first();

         $consultation->delete();

            $message = [
                'body' => "تم حذف الاستشارة "
            ];
            return response()->json($message, 200);
                } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function update(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $consultation = MedicalConsultation::where('id', $request->id)->first();

            $consultation->patient_id = $consultation->patient_id;
            $consultation->clinic_id = $request->clinic_id;
            $consultation->doctor_id2 = $request->doctor_id2;
            $consultation->severity = $request->severity;
            $consultation->consultation = $request->consultation;
            $consultation->doctor_id = $user->id;

            $consultation->save();
            $consultation->load('patient')->load('doctor')->load('clinic')->load('doctor2');

            return response()->json($consultation, 200);}
                 else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
