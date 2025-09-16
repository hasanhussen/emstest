<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Offer;
use App\Models\Order;
use DataTables;
use Validator;

class offerController extends Controller
{
    use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        { if ($request->ajax()) {

            $data = Offer::with('delegate_offer')->with('order_offer')->get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    
    
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    
                return $btn;
    
            })
            ->addColumn('offer_status',function($row){
                $offer_status="";
    
                if(( $row->offer_status)==0)
                  {$offer_status= "  قيد المعالجة";}

               elseif(($row->offer_status)==1)
               {$offer_status= "   مقبول";}

                else
                   {$offer_status=  " مرفوض";}
              
                 return $offer_status    ;
    
           })
        
            ->rawColumns(['action','offer_status'])
    
            ->make(true);
        }
        return view('offers.index');
    
    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->destroyController($id,Offer::class);

    }
}
