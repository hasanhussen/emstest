<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use App\Models\Note;
use App\Models\Test;
use App\Models\TestRequest;
use App\Models\User;
use Illuminate\Http\Request;

class testscontroller extends Controller
{
    public function add(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if ($user->role == 'طبيب' ||  $user->role == 'admin') {

            $testrequest = new TestRequest();
            $testrequest->patient_id = $request->patient_id;
            $testrequest->condition = $request->condition;
            $testrequest->state = $request->state;
            $testrequest->user_id = $user->id;

            $testrequest->save();

            foreach ($request->subclass_id as $data) {
                $tests = new Test();

                $subclass_id = $data['subclass_id'];
                $tests->subclass_id = $subclass_id;
                $tests->value = 0;
                $tests->trequest_id = $testrequest->id;
                $tests->save();
            }
            $testrequest->load('tests');

            return response()->json($testrequest, 200);
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


        if ($user->role == 'طبيب' ||  $user->role == 'admin' || $user->role == 'مخبر') {
            $classification = Classification::with('subclass')->get();


            return response()->json($classification, 200);
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }



    public function testresult(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'مخبر' ||  $user->role == 'admin') {
            $tests = Test::where('id', $request->test_id)->first();
            $tests->value = $request->value;
            $tests->save();

            return response()->json($tests, 200);
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }



    public function addnote(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'مخبر' ||  $user->role == 'admin' ||  $user->role == 'طبيب') {
            $note = new Note();
            $note->user_id = $user->id;
            $note->request_id = $request->request_id;
            $note->note = $request->note;

            $note->save();

            return response()->json($note, 200);
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }



    public function patient_tests(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin' || $user->role == 'مخبر') {
            $testre = TestRequest::where('patient_id', $request->patient_id)->get();
            if (is_null($testre)) {

                $message = [
                    'title' => "Not Found",
                    'body' => "المريض ليس لديه تحاليل  "
                ];
                return response()->json($message, 404);
            } else {
                $results = [];
            
                foreach ($testre as $test) {
                    $tests = Test::where('trequest_id', $test->id)->with('subclass')->get();
                    $results[] = $tests;
                }
                return response()->json($results, 200);
            }
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
