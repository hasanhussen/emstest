<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classification;
use App\Models\Subclassification;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;


class SubclassificationsController extends Controller
{ use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:التحاليل', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة تحليل', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل تحليل', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف تحليل', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $cat = Classification::get();

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Subclassification::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                    if ($user->can('تعديل تحليل') && $user->can('حذف تحليل')){
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    
            
                    }
             

                    return $btn;
                })

         
               ->addColumn('class_id', function ($row) {
                $cat = Classification::where('id',$row->class_id)->first();
                return $cat->name;
    
           })
 



                ->rawColumns(['action','class_id'])

                ->make(true);

            return;
        }

        return view('subclassifications.index',compact('cat'));
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
  
  
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'name' => $request->name,
            'class_id' => $request->class_id,
            'value' => $request->value,

        ];
      



        $id =  Subclassification::updateOrCreate(
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
        return  $this->editController($id, Subclassification::class);
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
            'class_id' => $request->class_id,
            'value' => $request->value,
        ];
      
        Subclassification::updateOrCreate(
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

        Subclassification::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
    public function getsubclassification($classificationId)
    {
        $subclass = Subclassification::where('class_id', $classificationId)->pluck('name', 'id');
        return response()->json($subclass);
    }

}
