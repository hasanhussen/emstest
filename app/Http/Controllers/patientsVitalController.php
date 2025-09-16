<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Patient;
use App\Models\Vital;
use App\Models\VitalPatient;
use App\Models\Vitalsign;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class patientsVitalController extends Controller
{
    use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:العلامات الحيوية', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة علامة حيوية', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل علامة حيوية', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف علامة حيوية', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $vital = Vitalsign::get();
        $patient=Patient::get();

        if ($request->ajax()) {

            $data =VitalPatient::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;
                })

               
               ->addColumn('patient_id', function ($row) {
                $patient = Patient::where('id',$row->patient_id)->first();
                return $patient->name;
    
           })
           ->addColumn('vital_id', function ($row) {
            $vital = Vitalsign::where('id',$row->vital_id)->first();
            return $vital->name;

     })



                ->rawColumns(['action','patient_id','vital_id'])

                ->make(true);

            return;
        }

        return view('patientsVitals.index',compact('vital','patient'));
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

        $data = [
            'patient_id' => $request->patient_id,
            'pressure' => $request->pressure,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'RespiratoryRate' => $request->RespiratoryRate,
            'time' => $request->time,
            'date' => $request->date,
            'Oxygenation' => $request->Oxygenation,
            'user_id' => $request->user_id,

        ];
      
        if (empty($request->time)) {
            $data['time'] = Carbon::now()->format('H:i:s');
        }
        else{
            $data['time'] = $request->time;

        }
        if (empty($request->date)) {
            $data['date'] =Carbon::now()->format('Y-m-d');

        }

else{
    $data['date'] = $request->date;

}
        $id =  Vital::updateOrCreate(
            ['id' => $request->_id],
            $data,
        
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
            'patient_id' => $request->patient_id,
            'pressure' => $request->pressure,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'RespiratoryRate' => $request->RespiratoryRate,
            
            'Oxygenation' => $request->Oxygenation,
            'user_id' => $request->user_id,
            'time' => $request->time,
            'date' => $request->date,
        ];
        if (empty($request->time)) {
            $data['time'] = Carbon::now()->format('H:i:s');
        }
        else{
            $data['time'] = $request->time;

        }
        if (empty($request->date)) {
            $data['date'] =Carbon::now()->format('Y-m-d');

        }

else{
    $data['date'] = $request->date;

}
      
        Vital::updateOrCreate(
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

        Vital::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
    public function add($id)
    {
        $patient=Patient::where('id',$id)->find($id);
        $vitals=Vital::where('patient_id',$id)->get();
        

        return view('patientsVitals.show',compact('vitals','patient'));

    }
    
}
