<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Traits\allTrait;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;
use App\Models\Region;
use App\Models\Vitalsign;
use Illuminate\Http\Request;


class PatientsController extends Controller
{    use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:المرضى', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة مريض', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل مريض', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف مريض', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $cities = City::with('regions')->get();

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Patient::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                    if ($user->can('تعديل مريض') && $user->can('حذف مريض')){
                        $btn = ' <a href="javascript:void(0)" data-toggle="حذف مريض"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    
                    if ($user->can('اضافة علامة حيوية')){
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="addvital" class=" btn btn-info btn-sm addvital"> <i class="fa fa-heart"></i> </a>';
                    }
                    }
                    elseif ($user->can('اضافة علامة حيوية')){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="addvital" class=" btn btn-info btn-sm addvital"> <i class="fa fa-heart"></i> </a>';
                    }
                    if($user->can('ادوية المريض')){
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="addmed" class=" btn btn-secondary btn-sm addmed"> <i class="fa fa-medkit"></i> </a>';

                    }
                    if($user->can('متابعات المريض')){
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="showFollow_up" class=" btn btn-info btn-sm showFollow_up"> <i class="fa fa-info"></i> </a>';

                    }
                    if($user->can('استشارات المريض')){
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="consultation" class=" btn btn-info btn-sm consultation"> الاستشارات</a>';

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

        return view('patients.index',compact('cities'));
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

        $validateErrors = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'motherName' => 'required|string',
                'fatherName' => 'required|string',
                'phone' => 'required',
  
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'name' => $request->name,
            'fatherName' => $request->fatherName,
            'motherName' => $request->motherName,
            'gFatherName' => $request->gFatherName,
            'lastName' => $request->lastName,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'patientCondition' => $request->patientCondition,
            'visit' => $request->visit,
            'forward' => $request->forward,
            'user_id' => $request->user_id,

        ];
      



        $id =  Patient::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;

        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
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
        return  $this->editController($id, Patient::class);
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
  

        $data = [
            'name' => $request->name,
            'fatherName' => $request->fatherName,
            'motherName' => $request->motherName,
            'gFatherName' => $request->gFatherName,
            'lastName' => $request->lastName,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'patientCondition' => $request->patientCondition,
            'visit' => $request->visit,
            'forward' => $request->forward,
            'user_id' => $request->user_id,
        ];
      
        Patient::updateOrCreate(
            ['id' => $request->_id],
            $data
        );


        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات بنجاح    .']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Patient::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }

  
    public function getRegions($cityId)
    {
        $regions = Region::where('city_id', $cityId)->pluck('name', 'id');
        return response()->json($regions);
    }



   
}
