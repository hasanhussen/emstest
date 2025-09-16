<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class chatcontroller extends Controller
{
    public function send_message(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
                if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $chat = Chat::where([
                ['user_id1', $user->id],
                ['user_id2', $request->user_id2],
            ])->orWhere([
                ['user_id2', $user->id],
                ['user_id1', $request->user_id2],
            ])->first();
                        if (is_null($chat)) {
                $chat = new Chat();
                $chat->user_id1 = $user->id;
                $chat->user_id2 =  $request->user_id2;
                $chat->save();
                $message = new Message();
                $message->user_id = $user->id;
                $message->chat_id =  $chat->id;
                $message->message =  $request->message;
                $message->type =  $request->type;
                $message->save();
   
           
            }
            else {
            $message = new Message();
            $message->user_id = $user->id;
            $message->chat_id =  $chat->id;
            $message->message =  $request->message;
            $message->type =  $request->type;
            $message->save();
            
     
            
          
            
    
          
        }
        $res = Message::find($message->id);
        }
        return response()->json($res, 200);
    }
 
    public function getconversations(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
                if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
            $chats = Chat::where('user_id1',$user->id)->with('user1')->with('user2')->get();
            $chats->each(function ($chat) {
                $messages = Message::where('chat_id', $chat->id)->get();
    
                $chat->messages = $messages;
            });
        }
        return response()->json($chats, 200);
    }
    public function getchat(Request $request)
    {
        $user = User::where('api_token', $request->token)->first();
                if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم  لم يقم بتسجيل الدخول"
            ];
            return response()->json($message, 404);
        } else {
           
            $chat = Chat::where('user_id1',$user->id )->where('user_id2',$request->user_id2 )->with('user1')->with('user2')->first();
            if ($chat) {
                $messages = Message::where('chat_id', $chat->id)->get();
                
                $chat->messages = $messages;
            }
        }
        return response()->json($chat, 200);
    }
}
