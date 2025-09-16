<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class friendsrequest_controller extends Controller
{
    public function sendRequest(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = new FriendRequest();
            $F_request->user_id1 = $user->id;
            $F_request->user_id2 = $request->user_id2;
            $F_request->state = 0; //"بانتظار القبول

            $F_request->save();
            $F_request->load('user1')->load('user2');
            return response()->json($F_request, 200);
        }
    }
    public function friendsequests(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = FriendRequest::where('user_id2', $user->id)->where('state', '0')->with('user1')->get();
        }
        return response()->json($F_request, 200);
    }

    public function requestAccept(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = FriendRequest::where('user_id1', $user->id)->where('id', $request->id)->with('user2')->first();

            $F_request->state = 1; //مقبول

            $F_request->save();
        }
        return response()->json($F_request, 200);
    }
    public function requestReject(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = FriendRequest::where('user_id1', $user->id)->where('id', $request->id)->with('user2')->first();
            $F_request->state = 2; //تم رفض الطلب
            $F_request->save();

            $message = [

                'body' => " تم رفض طلب الصداقة"
            ];
        }
        return response()->json($message, 200);
    }
    public function cancel(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = FriendRequest::where('user_id1', $user->id)->where('id', $request->id)->with('user2')->first();

            $F_request->delete();

            $message = [

                'body' => " تم الغاء الصداقة"
            ];
        }
        return response()->json($message, 200);
    }
    public function cancelRequest(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $F_request = FriendRequest::where('user_id1', $user->id)->where('user_id2', $request->user_id2)->where('state', 'بانتظار القبول')->first();

            $F_request->state = 3; //تم الغاء الطلب
            $F_request->save();

            $message = [

                'body' => " تم الغاء طلب الصداقة"
            ];
        }
        return response()->json($message, 200);
    }
}
