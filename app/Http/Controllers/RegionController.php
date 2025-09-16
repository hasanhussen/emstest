<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{   use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
{
$this->middleware('permission:المناطق', ['only' => ['index','store']]);
$this->middleware('permission:اضافة منطقة', ['only' => ['create','store']]);
$this->middleware('permission:تعديل منطقة', ['only' => ['edit','update']]);
$this->middleware('permission:حذف منطقة', ['only' => ['destroy']]);
}
    public function index(Request $request)
    {
     $cities=City::get();

        if ($request->ajax()) {

            $data = Region::get();

            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;
                })

               

                ->addColumn('city_id', function ($row) {
                    $city = City::where('id',$row->city_id)->first();
                    return $city->name;
        
               })



                ->rawColumns(['action','city_id'])

                ->make(true);

            return;
        }

        return view('regions.index',compact('cities'));
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
             
    /*'visit' => 'required|enum:كشف طبي,عمل جراحي,حالة اسعافية,غير ذلك',
                'RegionCondition' => 'required|enum: خطيرة,متوسطة , خفيفة' */
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'name' => $request->name,
            'city_id' => $request->city_id
        ];
      



        $id =  Region::updateOrCreate(
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
        return  $this->editController($id, Region::class);
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
                'name' => 'required|string',
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .

        $data = [
            'name' => $request->name,
            'city_id' => $request->city_id,

        ];
      
        Region::updateOrCreate(
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

        Region::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
}
