<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MedicalHistoryController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:المرضى|السوابق المرضية', ['only' => ['index']]);
    $this->middleware('permission:السوابق المرضية', ['only' => ['show']]);
    }
    public function index(Request $request)
    {

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Patient::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                   
                    if($user->can('السوابق المرضية')){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="services" class=" btn btn-secondary btn-sm services"> <i class="fa fa-medkit"></i> </a>';

                    }
                   
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

        return view('MedicalHistory.index');
    }

    public function show($id)
    {
        $medhistory =MedicalHistory ::where('patient_id',$id)->get();
        $patient = Patient::where('id',$id)->first();

        return view('MedicalHistory.medhistory',compact('medhistory','patient'));

    }
}
