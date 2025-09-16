<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\City;
use App\Models\Country;
use App\Models\cityRegion;
use DataTables;
use Validator;

class companiesController extends Controller
{use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Company::with('company')->with('city')->with('region')->with('company_owner')->get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    
                return $btn;
    
            })
            ->addColumn('delivery',function($row){
                $delivery="";
    
                if(( $row->delivery)==0)
                  {$delivery= "  كلا";}
               
                else
                   {$delivery=  " نعم";}
              
    
                 return $delivery    ;
    
           })
           ->addColumn('use_other_app',function($row){
            $use_other_app="";

            if(( $row->use_other_app)==0)
              {$use_other_app= "  كلا";}
           
            else
               {$use_other_app=  " نعم";}
          

             return $use_other_app    ;

       })   ->addColumn('image',function ($row){

        return "<img src='".asset('storage/companies/uploads/'.$row->image)."' width='50' height='50'>";

    })
    
            ->rawColumns(['action','delivery','use_other_app','image'])
    
            ->make(true);
        }
        return view('companies.index');
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
        $this->destroyController($id,Comment::class);    }
}
