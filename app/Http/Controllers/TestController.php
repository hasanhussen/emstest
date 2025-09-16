<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Subclassification;
use App\Models\Test;
use App\Models\TestRequest;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{ use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 /*   function __construct()
    {
    $this->middleware('permission:المرضى', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة مريض', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل مريض', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف مريض', ['only' => ['destroy']]);
    }*/
    public function index(Request $request)
    {

        $subclass=Subclassification::get();

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Test::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                    if ($user->can('تعديل مريض') && $user->can('حذف مريض')){
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    
                    }

                    return $btn;
                })

               
               
            
    
     
           ->addColumn('subclass_id', function ($row) {
            $subclass = Subclassification::where('id',$row->subclass_id)->first();
            return $subclass->name;

     })
         





                ->rawColumns(['action','subclass_id'])

                ->make(true);

            return;
        }

        return view('medicaltests.index',compact('subclass'));
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
    public function store(Request $request,$id)
    {

        $validateErrors = Validator::make(
            $request->all(),
            [
            
                'value' => 'required',
  
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'trequest_id' => $request->trequest_id,
            'subclass_id' => $request->subclass_id,
            'value' => $request->value,
         

        ];
      



        $id =  Test::updateOrCreate(
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  $this->editController($id, Test::class);
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
            'trequest_id' => $request->trequest_id,
            'subclass_id' => $request->subclass_id,
            'value' => $request->value,
        ];
      
        Test::updateOrCreate(
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

        Test::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
    public function add($id)
    {
        $test=Test::where('trequest_id',$id)->find($id);
        $tests=TestRequest::where('id',$id)->first();

        $subclass=Subclassification::get();
        

        return view('testRequest.index',compact('subclass','test'));
    }
}
