<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProduct;
use App\Models\User;
use App\Models\Company;
use App\Models\ProductComponent;
class company_control extends Controller
{
           
                
                
                  public function store_product(Request $request){
        
     $data = CompanyProduct::where('company_id',$request->id)->with('comp')->get();
            
            
                       
            return $data;
        
    }
    
    
                    
                  public function my_product(Request $request){
                      
                          $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
   $company= Company::where('user_id',$user->id)->first();
        
     $data = CompanyProduct::where('company_id',$company->id)->with('comp')->get();
            
            
                       
            return $data;
        
    }
    
                  }
    
    
     public function addproduct(Request $request){
    $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
   $company= Company::where('user_id',$user->id)->first();
   
   $product= new CompanyProduct();
   
   
   $product->name=$request->name;
   $product->company_id=$company->id;
   $product->price=$request->price;
   $product->calories=$request->calories;
         $product->image='';
     
   $product->save();
   
   return response()->json($product,200);
   }
  
    }
    
    
    
         public function addcomp(Request $request){
             
             $comp=new ProductComponent();
             $comp->product_id=$request->id;
                 $comp->order_id=0;
             $comp->name=$request->name;
             $comp->save();
                return response()->json($comp,200);
         }
         
         
                

}
