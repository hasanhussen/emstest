<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Models\Vital;
use App\Models\VitalPatient;
use App\Models\Vitalsign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class vitalcontroller extends Controller
{
    public function add(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();

        if ($user->role == 'الاسعاف' ||  $user->role == 'admin') {

            $vital = new Vital();


            $vital->patient_id = $request->patient_id;
            $vital->time = $request->time;
            $vital->date = $request->date;
            $vital->pressure = $request->pressure;
            $vital->temperature = $request->temperature;
            $vital->pulse = $request->pulse;
            $vital->RespiratoryRate = $request->RespiratoryRate;
            $vital->Oxygenation = $request->Oxygenation;
            $vital->user_id = $user->id;

            $vital->save();

            return response()->json($vital, 200);
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


        if ($user->role == 'الاسعاف' ||  $user->role == 'admin') {
            $vital = Vital::where('patient_id', $request->id)->get();


            return  $vital;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }

   /*  public function search(Request  $request)
    {
        $date = $request->date;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
    $patient=$request->patient_id;
    $value=$request->value;
    $vital_id=$request->input('vital_id', []);
    $user_id=$request->user_id;

        $vital = VitalPatient::query();

       if($vital_id){
        if ($date) {
            $vital->where('date', $date)->whereIn('vital_id',$vital_id);
        }
   
    
        if ($startDate && $endDate) {
            $vital->whereBetween('date', [$startDate, $endDate])->whereIn('vital_id',$vital_id);
        }
    
        if ($user_id) {
            $vital->where('user_id', $user_id)->whereIn('vital_id',$vital_id);
        }
   
        if ($value) {
            $vital->where('value', $value)->whereIn('vital_id',$vital_id);
        }
       }
       else{
        if ($date) {
            $vital->where('date', $date);
        }
   
    
        if ($startDate && $endDate) {
            $vital->whereBetween('date', [$startDate, $endDate]);
        }
    
        if ($user_id) {
            $vital->where('user_id', $user_id);
        }
   
        if ($value) {
            $vital->where('value', $value);
        }
       }
        $result = $vital->where('patient_id',$patient)->with('vitalsign')->get();

        return response()->json($result, 200);
    } */
    public function search(Request  $request)
    {
        $date = $request->date;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
    $patient=$request->patient_id;
    $pressure=$request->pressure;
    $temperature=$request->temperature;
    $pulse=$request->pulse;
    $RespiratoryRate=$request->RespiratoryRate;
    $Oxygenation=$request->Oxygenation;

    $user_id=$request->user_id;

        $vital = Vital::query();

     
        if ($date) {
            $vital->where('date', $date);
        }
    
        if ($startDate && $endDate) {
            $vital->whereBetween('date', [$startDate, $endDate]);
        }
    
        if ($user_id) {
            $vital->where('user_id', $user_id);
        }
        if ($pressure) {
            $vital->where('pressure', $pressure);
        } 
         if ($temperature) {
            $vital->where('temperature', $temperature);
        } 
         if ($pulse) {
            $vital->where('pulse', $pulse);
        } 
         if ($RespiratoryRate) {
            $vital->where('RespiratoryRate', $RespiratoryRate);
        }  
        if ($Oxygenation) {
            $vital->where('Oxygenation', $Oxygenation);
        }
       
        $result = $vital->where('patient_id',$patient)->get();

        return response()->json($result, 200);
    }
    

}
