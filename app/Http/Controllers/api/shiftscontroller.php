<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class shiftscontroller extends Controller
{

    public function addshift(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();

        if ($user->role == 'موارد بشرية' ||  $user->role == 'admin') {

            $shift = new Shift();


            $shift->group_id = $request->group_id;
            $shift->day = $request->day;
            $shift->start = $request->start;
            $shift->end = $request->end;


            $shift->save();
            $shift->load('group');

            return response()->json($shift, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }

    public function all_shifts(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ( $user->role == 'موارد بشرية' ||  $user->role == 'admin') {
            $shifts = Shift::with('group')->get();

            return  $shifts;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function group_shifts(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' || $user->role == 'موارد بشرية' ||  $user->role == 'admin') {
            $shifts = Shift::where('group_id', $request->group_id)->with('group')->get();
 

            return  $shifts;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function doctors_shifts(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب') {
            $shift = Shift::where('group_id', $user->group_id)->with('group')->get();

            return  $shift;
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


        if ($user->role == 'موارد بشرية' ||  $user->role == 'admin') {
            $shift = Shift::where('id', $request->id)->first();

            $shift->delete();

            $message = [
                'body' => "تم حذف المناوبة "
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


        if ($user->role == 'موارد بشرية' ||  $user->role == 'admin') {
            $shift = Shift::where('id', $request->id)->first();

            $shift->group_id = $shift->group_id;
            $shift->day = $request->day;
            $shift->start = $request->start;
            $shift->end = $request->end;

            $shift->save();
            $shift->load('group');

            return response()->json($shift, 200);
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
