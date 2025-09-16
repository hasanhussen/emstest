<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetails;
use App\Models\Offer;
use DB;
class order_control extends Controller
{
         public function get_wait_order_for_driver(Request $request)
    {
    $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $data = Order::where('order_status',1)->where('company_order_status',1)->with('company')->with('order_details')
                ->get();
    return response()->json($data);
    }
    }
    
   public function    get_offers_for_order(Request $request){
        
            $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $data = Offer::where('order_id',$request->id)->with('delegate_offer')
                ->get();
    return response()->json($data);
    }
    }
    
     public function    accept_offers(Request $request){
        
            $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $data = Offer::where('id',$request->id)->first();
              $data->offer_status=1;
              $data->save();
    return response()->json($data);
    }
    }
    
     public function    decline_offers(Request $request){
        
            $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $data = Offer::where('id',$request->id)->first();
              $data->offer_status=2;
              $data->save();
    return response()->json($data);
    }
    }
    
    
        public function get_my_order(Request $request)
    {
    $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $order = Order::where('user1_id',$user->id)->with('company')->with('order_details')
                ->get();
                
             $joinn =   DB::table('orders')
                  ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                  ->join('company_products', 'order_details.product_id', '=', 'company_products.id')
                  ->where('orders.id', $order->id)
                  ->get();

      

        $res = ["order"=>$order, "joinn"=>$joinn];
    return $res;
    }
    }

    
    
    
          public function get_my_order_driver(Request $request)
    {
    $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    
    } else{
              $data = Order::where('user2_id',$user->id)->with('company')->with('order_details')
                ->get();
    return response()->json($data);
    }
    }
    
    
    
    public function add_order(Request $request){
         $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    }
    else{
        $order= new Order();
        $order->user1_id=$user->id;
        $order->user2_id=0;
        $order->company_id=$request->id;
           $order->payment_type=3;
        $order->dilever_coust=0;
           $order->order_bill=0;
              $order->total_bill=0;
           
        $order->tax_value=0;
           $order->earn_value=0;
        $order->order_status=0;
           $order->client_order_status =0;
        $order->company_order_status=0;
           $order->receiving_location=0;
             $order->delivery_location=0;
           
               $order->distance=0;
           $order->notes=0;
        $order->order_date=$request->order_date;
        $order->save();
    
        
        $newstd=$order::where('user1_id',$user->id)->latest()->first();
        $prod= new OrderDetails();
$prod->order_id=$newstd->id;
$prod->product_id=$request->prod_id;
$prod->price=$request->price;
$prod->quantity=$request->quantity;
$prod->total_coust=$request->quantity*$request->price;
$prod->save();
      return $order;      
    }
     
        
        
        
    }
    
    
    
    
    
        public function add_to_order(Request $request){
         $user=User::all()->where('api_token',$request->token)->first();
    if(is_null($user)){
    
     $message=[
         'title' =>"Not Found",
     'body' =>"المستخدم غير موجود"];
     return response()->json($message,404);
    }
    else{

        
        $newstd=Order::where('user1_id',$user->id)->where('id',$request)->first();
        $prod= new OrderDetails();
$prod->order_id=$request->id;
$prod->product_id=$request->prod_id;
$prod->price=$request->price;
$prod->quantity=$request->quantity;
$prod->total_coust=$request->quantity*$request->price;
$prod->save();
      return $prod;      
    }
     
        
        
        
    }
    
    
    
    
    
    
    
    
}
