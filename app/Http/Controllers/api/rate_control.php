<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Order;
use App\Models\UserStars;
class rate_control extends Controller
{
    
    public function add_star(Request $request){
            $user=User::where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
        
        $user_start= new UserStars();
        $user_start->user1_id=$user->id;
             $user_start->user2_id=$request->id;
             
           $user_start->stars=$request->star;
           $user_start->save();
         $message=[
         'title' =>"تم",
     'body' =>"تم ارسال التقييم بنجاح"];
        
             return response()->json($message,200);
        
    }
        
        
        
        
    }
    
        public function add_comment(Request $request){
            $user=User::where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
        
        $user_start= new Comment();
        $user_start->user1_id=$user->id;
             $user_start->user2_id=$request->id;
             
           $user_start->comment=$request->comment;
           $user_start->save();
         $message=[
         'title' =>"تم",
     'body' =>"تم ارسال تعليقك بنجاح"];
        
             return response()->json($message,200);
        
    }
        
        }  
                public function comment(Request $request){
            $user=User::where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
        
        $start=Comment::where('user2_id',$user->id)->get();
        return $start;
   
        
    }
        
        
    }
    
       public function driver_comment(Request $request){

        
        $start=Comment::where('user2_id',$request->id)->get();
        return $start;
   
        
    
        
        
    }
    
}
