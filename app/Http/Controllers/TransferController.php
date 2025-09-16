<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\City;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Region;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;

class TransferController extends Controller
{use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:التحويل|المرضى', ['only' => ['index','add']]);
    
  }
    public function index(Request $request)
    {
        $clinics = Clinic::get();

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Patient::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                   
                    if ($user->can('التحويل') || $user->can('المرضى')){

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="edit" class=" btn btn-info btn-sm edit"> تحويل الى قسم</a>';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="transfer" class=" btn btn-primary btn-sm transfer">  عرض</a>';

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

            return view('transfer.index',compact('clinics'));
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
        public function add(Request $request,$id)
        {
    
            $patient=Patient::where('id',$id)->find($id);
   
    $transfer = new Transfer();
    $transfer->patient_id = $patient->id;
  
    $transfer->to = $request->to;
    $transfer->from =  $request->from;
    if (empty($request->date)) {
    $transfer->date   =Carbon::now()->format('Y-m-d');}
    else{
        $transfer->date = $request->date;
    
    }
    if (empty($request->time)) {
    $transfer->time =  Carbon::now()->format('H:i:s');}
    else{
        $transfer->time =  $request->time;
    
    }

              $transfer->user_id = $request->user_id;

          $transfer->save();
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
            $trans =Transfer ::where('patient_id',$id)->get();
            $patient = Patient::where('id',$id)->first();
    
            return view('transfer.show',compact('trans','patient'));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            return  $this->editController($id, Transfer::class);
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
            $validateErrors = Validator::make(
                $request->all(),
                [
                    'to' => 'required|string',
                    'patient_id' => 'required',
                    'user_id' => 'required',

                    'from' => 'required',
                    'date' => 'required',
                    'time' => 'required',

    
    
                ]
            );
            if ($validateErrors->fails()) {
                return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
            } // end if fails .
            //        }
            $data = [
                'user_id' => $request->user_id,
                'patient_id' => $request->patient_id,
                'from' => $request->from,
                'to' => $request->to,
                'date' => $request->date,
                'time' => $request->time,
    
            ];
          
            $id =  Transfer::updateOrCreate(
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
    
            Transfer::find($id)->delete();
    
            return response()->json(['success' => ' تم الحذف بنجاح']);
        }
    }
    