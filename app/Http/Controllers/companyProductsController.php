<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\CompanyProduct;
use App\Models\Company;
use App\Models\CityRegion;
use App\Models\ProductComponent;
use DataTables;
use Validator;

class companyProductsController extends Controller
{use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = CompanyProduct::with('comp_product')->with('comp')->get();

            return Datatables::of($data)

            ->addIndexColumn()

            ->addColumn('action', function($row){


                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';

                return $btn;

            })
            ->addColumn('components', function($row){
                //if ( sizeof($prices) >0)


                if(count($row->comp)>0)

                {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="details" class=" btn btn-dark btn-sm component">'.$row->comp[0]->name.'</a>';

                   return $btn    ;
                }
                else
               {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="details" class=" btn btn-dark btn-sm component">  أضف مكون</a>';

                return $btn;
            }
            })
            ->rawColumns(['action','components'])

            ->make(true);
        }
        return view('companies.company_products');
    }


    public function store_components(Request $request){
        
        $data =[

            'name' => $request->name,
            'product_id' => $request->product_id,
            'order_id'=> 0,
        ];
        $id =  ProductComponent::Create($data)->id;

        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' , "data"=>ProductComponent::where('product_id','=',$request->product_id)->orderby('order_id')->get() ]);
    }
    // store new components


    public function get_components($id){

        $data=ProductComponent::where('product_id','=',$id)->orderby('order_id')->get();
        return response()->json($data);
    } // get all product components



    public function delete_components($id){

        $this->destroyController($id,ProductComponent::class);
    } // delete component


    
    public function Update_components(Request $request ){


        $names=$request->name;
        $orders_id=$request->order_id;
        $component_id=$request->component_id;
        $i=0;
        foreach($names as $name ){
        $data =[
            'name' => $name,
            'order_id'=> $i,
        ];


        ProductComponent::where('id',"=",$component_id[$i])->update($data);
       $i++;
        }

        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' , "data"=>ProductComponent::where('product_id','=',$request->product_id)->orderby('order_id')->get() ]);


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
    {  ProductComponent::where('product_id',$id)->delete();
        $this->destroyController($id,CompanyProduct::class);
    }
}
