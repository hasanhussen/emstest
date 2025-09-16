<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\pharmaceutical;
use App\Models\pharmaceuticalClass;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class pharmaceuticalController extends Controller
{  use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:الادوية|اضافة دواء', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة دواء', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل دواء', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف دواء', ['only' => ['destroy']]);
    }
    public function index(Request $request)

    { 
      $class= pharmaceuticalClass::get();
        if ($request->ajax()) {
            $user = auth()->user();
        $data = pharmaceutical::get();

        return DataTables::of($data)

        ->addIndexColumn()

        ->addColumn('action', function ($row) use ($user) {
                  
            if ($user->can('تعديل دواء') && $user->can('حذف دواء')){
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
            
    
            }
     

            return $btn;
        })

 
       ->addColumn('pharma', function ($row) {
        $cat = pharmaceuticalClass::where('id',$row->pharma_id)->first();
        return $cat->name;

   })

        ->rawColumns(['action','pharma'])

        ->make(true);
    }
    return view('pharmacy.drugs',compact('class'));

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
            'pharma_id' => $request->pharma_id,
            'scientificName' => $request->scientificName,
            'description' => $request->description,

        ];
      



        $id =  pharmaceutical::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;

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
        return  $this->editController($id,pharmaceutical::class);
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
            'pharma_id' => $request->pharma_id,
            'scientificName' => $request->scientificName,
            'description' => $request->description,

        ];
        pharmaceutical::updateOrCreate(['id' => $request->_id],
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
        $this->destroyController($id,pharmaceutical::class);
    }
}