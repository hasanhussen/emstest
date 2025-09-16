<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Order;
use App\Models\Tax;
use App\Models\Conversation;
use DataTables;
use Validator;
use DB;

class orderController extends Controller
{use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $st = $request->input("st");
                $ed = $request->input("ed");
    
                if( !empty($st) && !empty($ed))
                {
                   $data=Order::with('user1')->with('company')->with('order_details')->
                   whereBetween('created_at', [$st, $ed])->get();
    
                }
                else{
    
                $data = Order::with('user1')->with('company')->with('order_details')
                ->get();
                }
            
    
               return Datatables::of($data)
    
              ->addIndexColumn()
    
              ->addColumn('action', function($row){
    

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    

                return $btn;
    
                })

                    
              ->addColumn('info', function($row){
    

    
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-dark btn-sm info"> التفاصيل </a>';

                return $btn;
    
                })
                ->addColumn('conversation',function($row){

                  $bbtn ='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-dark btn-sm conversation"> عرض </a>';
          
                  return $bbtn;
          
                      })
                ->addColumn('notes', function($row){
                   
                  if(strlen($row->notes)>30){
  
                 return mb_substr($row->notes, 0, 30) ."....";}
                 
                 else{
                  return $row->notes;  
                 }
  
              })
                ->addColumn('order_status',function($row){
                    $order_status="";
    
                    if(( $row->order_status)==0)
                      {$order_status= "  قيد المعالجة";}
                    elseif(( $row->order_status)==1)
                      {$order_status= "مكتمل ";}
                      elseif(( $row->order_status)==2)
                      {$order_status= "تم التسليم ";}
                    else
                       {$order_status=  " مرفوض";}
                  
    
                     return $order_status    ;
    
               })
               ->addColumn('company_order_status',function($row){
                $company_order_status="";

                if(( $row->company_order_status)==0)
                  {$company_order_status= "  قيد المعالجة";}
                elseif(( $row->company_order_status)==1)
                  {$company_order_status= "مقبول ";}
                  elseif(( $row->company_order_status)==2)
                  {$company_order_status= "تم التسليم ";}
                else
                   {$company_order_status=  " مرفوض";}
              

                 return $company_order_status    ;

           })
           ->addColumn('client_order_status',function($row){
            $client_order_status="";

            if(( $row->client_order_status)==0)
              {$client_order_status= "  طلب ";}
           
            else
               {$client_order_status=  " الغاء";}
          

             return $client_order_status    ;

       })
           
               ->addColumn('payment_type',function($row){
                  $payment_type="";

                   if(( $row->payment_type)==0)
                     {$payment_type= "  كاش ";}
                   
                     {$payment_type=  " اونلاين";}
              

                 return $payment_type    ;

           })
           ->addColumn('total_bill',function($row){

               return  $row->total_bill = $row->earn_value + 
               $row->dilever_coust+ $row->order_bill;
             
       })
  
           
           
              ->rawColumns(['action','order_status','payment_type','company_order_status'
                            ,'client_order_status','info','notes','total_bill','conversation'])
    
              ->make(true);
        }
    }
        return view('orders.index'); 
       }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
       $data1= Order::whereBetween('created_at', [$start, $end])->get();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // order
        $order=Order::with('user1_id')->with('conversation')->find($id);

        // conversation
       
        $joinn = DB::table('conversations')
         ->select('*')
         ->join('orders', 'conversations.order_id', '=', 'orders.id')
         ->where('conversations.order_id', $id)
         ->get();
        
                
        $res = ["order"=>$order, "joinn"=>$joinn];
       return response()->json($res);
    }

    public function get_conversation($id){

      $data=Conversation::where('order_id','=',$id)->with('user')->orderby('created_at')->get();
      return response()->json($data);
  } // get all order conversation 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  // order
        $order=Order::with('user1')->with('order_details')->with('company')->find($id);
    
    
        //order details, products
         $joinn =   DB::table('orders')
      ->join('order_details', 'orders.id', '=', 'order_details.order_id')
      ->join('company_products', 'order_details.product_id', '=', 'company_products.id')
      ->where('orders.id', $id)
      ->get();

      

        $res = ["order"=>$order, "joinn"=>$joinn];
       return response()->json($res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     



    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController($id,Order::class);
    }
    public function showMap(){
      return view("map.show");
    }
}
