<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;
use App\Models\PatientService;
use App\Models\Region;

class PatientServiceController extends Controller
{ use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:المرضى|خدمات المريض', ['only' => ['index']]);
    $this->middleware('permission:خدمات المريض', ['only' => ['show']]);
    }
    public function index(Request $request)
    {

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Patient::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                   
     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="services" class=" btn btn-secondary btn-sm services"> <i class="fa fa-medkit"></i> </a>';

                   
                    return $btn;
                })

               
                ->addColumn('gender',function($row){
                    $gender="";
        
                    if(( $row->gender)==0)
                      {$gender= "  ذكر";}
                   
                    else
                       {$gender=  " أنثى";}
                  
        
                     return $gender    ;
        
               })
               ->addColumn('city_id', function ($row) {
                $city = City::where('id',$row->city_id)->first();
                return $city->name;
    
           })
           ->addColumn('region_id', function ($row) {
            $region = Region::where('id',$row->region_id)->first();
            return $region->name;

     })  
        
           



     ->rawColumns(['action','gender','city_id','region_id'])

                ->make(true);

            return;
        }

        return view('patientServices.index');
    }


  
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

 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $services = PatientService::where('patient_id',$id)->get();
        $patient = Patient::where('id',$id)->first();

        return view('patientServices.patientservices',compact('services','patient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

  
}
