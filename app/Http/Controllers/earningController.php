<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Earning;
use App\Models\Order;
 use  Carbon\Carbon;
use DataTables;
use Validator;
use DB;

class earningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $st = $request->start_date;
        $ed = $request->end_date;
        

        $daily= Order::whereDate('order_date',today())->sum('earn_value');

        $date = Carbon::today()->subDays(30);
        $monthly=Order::where('order_date','>=',$date)->sum('earn_value');

        $all_earn = Order::sum('earn_value');
        
            
        $earn=Order::whereBetween('order_date', [$st, $ed])->sum('earn_value');


    return view('earnings.daily_earn', compact('all_earn','daily','monthly','earn',));
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
 
       $st = $request->start_date;
       $ed = $request->end_date;
       
       $earn=Order::whereBetween('order_date', [$st, $ed])->sum('earn_value');

       return response()->json(['earn'=>$earn,'message' => ' تم حفظ البيانات بنجاح    .' ]);

       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
