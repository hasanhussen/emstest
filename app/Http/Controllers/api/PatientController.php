<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{


    public function add(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if ($user->role == 'الاستقبال' ||  $user->role == 'admin') {

            $patient = new Patient();


            $patient->name = $request->name;
            $patient->fatherName = $request->fatherName;
            $patient->gFatherName = $request->gFatherName;
            $patient->lastName = $request->lastName;
            $patient->motherName = $request->motherName;
            $patient->birthday =  $request->birth;
            $patient->gender = $request->gender;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->city_id = $request->city_id;
            $patient->region_id = $request->region_id;
            $patient->patientCondition = $request->patientCondition;
            $patient->visit = $request->visit;
            $patient->user_id = $user->id;

            $patient->save();

            return response()->json($patient, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }

    public function searchByadd(Request  $request)
    {
        $cityId = $request->city_id;
        $regionId = $request->region_id;

        $patients = Patient::query();

        if ($cityId) {
            $patients->where('city_id', $cityId);
        }

        if ($regionId) {
            $patients->where('region_id', $regionId);
        }

        $result = $patients->get();

        return response()->json($result, 200);
    }


    public function searchByName(Request  $request)
    {
        $name = $request->name;
        $motherName = $request->motherName;
        $fatherName = $request->fatherName;
        $gFatherName = $request->gFatherName;
        $lastName = $request->lastName;


        $patients = Patient::query();

        if ($name) {
            $patients->where('name', $name);
        }

        if ($motherName) {
            $patients->where('motherName', $motherName);
        }
        if ($fatherName) {
            $patients->where('fatherName', $fatherName);
        }
        if ($gFatherName) {
            $patients->where('gFatherName', $gFatherName);
        }
        if ($lastName) {
            $patients->where('lastName', $lastName);
        }

        $result = $patients->get();

        return response()->json($result, 200);
    }



    public function searchBybirthday(Request  $request)
    {
        $bday = $request->birthday;

        $patients = Patient::query();

        if ($bday) {
            $patients->where('birthday', $bday);
        }


        $result = $patients->get();

        return response()->json($result, 200);
    }
    public function searchByfile(Request  $request)
    {
        $id = $request->id;

        $patients = Patient::query();

        if ($id) {
            $patients->where('id', $id);
        }


        $result = $patients->get();

        return response()->json($result, 200);
    }
    public function update(Request $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if ($user->role == 'الاستقبال' ||  $user->role == 'admin') {
            $patient = Patient::where('id', $request->id)->first();
            $patient->name = $request->name;
            $patient->fatherName = $request->fatherName;
            $patient->gFatherName = $request->gFatherName;
            $patient->lastName = $request->lastName;
            $patient->motherName = $request->motherName;
            $patient->birthday =  $request->birthday;
            $patient->gender = $request->gender;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->city_id = $request->city_id;
            $patient->region_id = $request->region_id;
            $patient->patientCondition = $request->patientCondition;
            $patient->visit = $request->visit;
            $patient->user_id = $user->id;

            $patient->save();

            return response()->json($patient, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }


    public function latestpatients(Request $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if ($user->role == 'الاستقبال' ||  $user->role == 'admin') {
            $patient = Patient::orderBy('id', 'DESC')->with('forwards')->get();
          
            return response()->json($patient, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
