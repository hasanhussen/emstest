<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplainType;
use App\Models\Complain;
use App\Models\User;
class complaint_control extends Controller
{

        public function index()
    {
       

        $data = ComplainType::get();
        
        return $data;

    }

    public function add(Request $request){
    $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
   $company=new Complain();
   $company->user2_id	=$request->user;
   $company->complainType_id=$request->id;
   $company->type=$request->text;
      $company->user1_id	=$user->id;
   $company->complain_date=$request->comp_date;
   $company->notes=$request->notes;
  $company->image='a';
   $company->save();
   
   return response()->json($company,200);
   }
  
    }
    
    
}
