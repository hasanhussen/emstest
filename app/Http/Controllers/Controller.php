<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Kreait\Firebase\Messaging\CloudMessage ;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sendFCM($tokens, $title, $details){
        $messaging = app('firebase.messaging');
        $message = CloudMessage::fromArray([
            'token' => $tokens,
            'notification' => ["title"=>$title,"details"=>$details], // optional
            'data' =>  ["title"=>$title,"details"=>$details], // optional
        ]);
        
        $messaging->send($message);

    }
}
