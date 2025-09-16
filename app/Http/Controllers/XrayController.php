<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Xray;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Patient;
use App\Models\XrayImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class XrayController extends Controller
{   use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:الاشعة', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة اشعة', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل اشعة', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف اشعة', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
    



        if ($request->ajax()) {
        
            $data = Xray::with('image')->get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row)   {
                  
             
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="imagesModal" class="btn btn-info btn-sm addimage"><i class="fa fa-heart"></i></a>';
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-secondary btn-sm info"> <i class="fa fa-info"></i></a>';

            
                 

                    return $btn;
                })

                ->addColumn('patient_id', function ($row) {
                    $patient = Patient::where('id',$row->patient_id)->first();
                    return $patient->name;
        
               })
               ->addColumn('injection',function($row){
                $injection="";
    
                if(( $row->injection)==0)
                  {$injection= "  بدون حقن";}
               
                else
                   {$injection=  " مع حقن";}
              
    
                 return $injection    ;
    
           })



                ->rawColumns(['action','injection','patient_id'])

                ->make(true);

            return;
        }

        return view('Xrays.index');
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
      
        $data = [
            'patient_id' => $request->patient_id,
            'imageType' => $request->imageType,
            'part' => $request->part,
            'injection' => $request->injection,
            'state' => $request->state,
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


        $id =  Xray::updateOrCreate(
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
   
        $xrayImages = XrayImage::where('image_id', $id)->get();
        $images = $xrayImages->pluck('image');

        return response()->json(['images' => $images]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  $this->editController($id, Xray::class);

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
            'imageType' => $request->imageType,
            'part' => $request->part,
            'injection' => $request->injection,
            'state' => $request->state,
     
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


        $id =  Xray::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;

        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController($id,Xray::class);

    }

    public function addxray(Request $request,$id)
    {
        $image=Xray::where('id',$id)->find($id);
    
           
     $data = ['image_id' =>$image->id];

    
      
     if(!empty($request->image)){
        $data['image'] = $request->image;
    }
     XrayImage::Create(
     $data);

   
//return $request;
    return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
  
     }
     public function getImages( $id)
{
    $images = XrayImage::where('image_id', $id)->get();
    
    
   return response()->json(['status' => 200, 'message' => 'تم استرداد الصور بنجاح.', 'images' => $images]);
}
}
