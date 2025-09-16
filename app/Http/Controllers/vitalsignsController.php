<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vitalsign;
use App\Http\Traits\allTrait;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class vitalsignsController extends Controller
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

    { if ($request->ajax()) {

        $data = Vitalsign::get();
        $user = auth()->user();
        return DataTables::of($data)

        ->addIndexColumn()

        ->addColumn('action', function($row) use ($user) {
                  
            if ($user->can('تعديل علامة حيوية') & $user->can('حذف علامة حيوية')){
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
            }
            return $btn;

        })->addColumn('image',function ($row){

            return "<img src='".asset('storage/'.$row->image)."' width='50' height='50'>";
        })

        ->rawColumns(['action','image'])

        ->make(true);
    }
    return view('Vitalsigns.index');

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
        $validateErrors = Validator::make($request->all(),
        [
            'name' => 'required|string|min:3',

        ]);
    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    } // end if fails .
        //        }
        $data =[
            'name' => $request->name,
            'min' => $request->min,
            'max' => $request->max,

        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }



        $id =  Vitalsign::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' , "data"=>null ]);

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
        return  $this->editController($id,Vitalsign::class);
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
        $data =[
            'name' => $request->name,
            'min' => $request->min,
            'max' => $request->max,

        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }
        Vitalsign::updateOrCreate(['id' => $request->_id],
        $data);


return response()->json(['status'=>200,'message' => ' تم حفظ البيانات بنجاح    .' ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController($id,Vitalsign::class);
    }
}
