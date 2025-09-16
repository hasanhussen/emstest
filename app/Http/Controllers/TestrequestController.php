<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Classification;
use App\Models\Note;
use App\Models\Patient;
use App\Models\Subclassification;
use App\Models\Test;
use App\Models\TestRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TestrequestController extends Controller
{ use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 /*-*/ /*  function __construct() 
    
    {
    $this->middleware('permission:اضافة طلب تحليل|التحاليل', ['only' => ['index','store']]);
    $this->middleware('permission:  اضافة طلب تحليل', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل طلب تحليل', ['only' => ['edit','update']]);
    $this->middleware('permission: حذف طلب تحليل', ['only' => ['destroy']]);
    //$this->middleware('permission: اضافة نتيجة تحليل', ['only' => ['destroy']]);
    $this->middleware('permission: اضافة ملاحظة للتحليل', ['only' => ['addnote']]);


    }*/
    public function index(Request $request)
    {
        $classification=Classification::with('subclass')->get();

        if ($request->ajax()) {
            $user = auth()->user();
            $data = TestRequest::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                    if ($user->can('تعديل طلب تحليل') && $user->can('حذف طلب تحليل')){
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="tests" class=" btn btn-info btn-sm tests"> <i class="fa fa-heart"></i> </a>';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="note" class=" btn btn-secondary btn-sm note" style="padding-left: 10px;padding-right: 10px;"> <i class="fa fa-info"></i> </a>';

                    }

                    return $btn;
                })

               
         
               ->addColumn('patient_id', function ($row) {
                $patient = Patient::where('id',$row->patient_id)->first();
                return $patient->name;
    
           })
           ->addColumn('patientfather', function ($row) {
            $patient = Patient::where('id',$row->patient_id)->first();
            return $patient->fatherName;

       })
       ->addColumn('patientlastname', function ($row) {
        $patient = Patient::where('id',$row->patient_id)->first();
        return $patient->lastName;

   })
           ->addColumn('user_id', function ($row) {
            $user = User::where('id',$row->user_id)->first();
            return $user->name;

     })



                ->rawColumns(['action','patient_id','user_id','patientlastname','patientfather'])

                ->make(true);

            return;
        }

        return view('testRequest.index',compact('classification'));
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
        $testrequest = new TestRequest();
        $testrequest->patient_id = $request->patient_id;
        $testrequest->state = $request->state;
        $testrequest->condition =  $request->condition;
      
    
       $testrequest->user_id = $request->user_id;
    
              $testrequest->save();

              foreach ( $request->subclassList as $subclass) {
                  $testInRequest = new Test();
                  $testInRequest->trequest_id = $testrequest->id;
                  $testInRequest->subclass_id = $subclass;
                  $testInRequest->value = 0;
                  $testInRequest->save();
              }

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
        return  $this->editController($id, TestRequest::class);
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
  

        $testrequest = TestRequest::where('id',$id)->find($id);

        $testrequest->patient_id = $request->patient_id;
        $testrequest->state = $request->state;
        $testrequest->condition =  $request->condition;
      
    
       $testrequest->user_id = $request->user_id;
    
              $testrequest->save();
           


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

        $tests= TestRequest::find($id);  
        $tests->delete();
     $test = Test::where('trequest_id',$tests->id)->get();
     foreach( $test as $t){
        $t->delete();
     }
        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
    public function addtest($id)
    {
        $tests=TestRequest::where('id',$id)->find($id);
        $test = Test::where('trequest_id',$id)->with('subclass')->get();
     
    
        return view('testRequest.result',compact('test','tests'));
    }
    public function add_update_result(Request $request,$id)
    {       

         $test = Test::where('id',$id)->find($id);

        $test->value=$request->value;
        $test->save();
        
    
        return back();
    }
    public function addnote(Request $request,$id)
    {
        $tests=TestRequest::where('id',$id)->find($id);
        $note =   new Note();
   

        $validateErrors = Validator::make(
            $request->all(),
            [
            
                'note' => 'required',
  
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
      
        $note->request_id = $tests->id;
        $note->note = $request->note;
        $note->user_id = $request->user_id;
        $note->save();
        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
    }

}