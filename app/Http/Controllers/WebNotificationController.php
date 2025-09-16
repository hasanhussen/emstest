<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WebNotificationController extends Controller
{
    //
    public function storeToken(Request $request)
    {
        if(!isset($request->user_id) || empty($request->user_id) || intval($request->user_id) < 0){
        return response()->json(['status'=>201,'success'=>false,'message'=>'Validation Error']);

        }
        $id =$request->user_id;

        User::where('id',$id)->update(['fcm_token'=>$request->token]);
        return response()->json(['status'=>200,'success'=>true,'message'=>'Token successfully stored.']);
    }
    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
          
        $serverKey = env('FIREBASE_SERVER_KEY');
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);   
        return "sent successful";     
    }
}
