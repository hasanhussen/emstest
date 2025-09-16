<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class ShiftsController extends Controller
{ use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   function __construct()
{
$this->middleware('permission:المناوبات', ['only' => ['index','store']]);
$this->middleware('permission:اضافة مناوبة', ['only' => ['create','store']]);
$this->middleware('permission:تعديل مناوبة', ['only' => ['edit','update']]);
$this->middleware('permission:حذف مناوبة', ['only' => ['destroy']]);
}
    public function index(Request $request)
    {
     $groups=Group::get();

        if ($request->ajax()) {

            $data = Shift::get();

            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;
                })

               

                ->addColumn('group_id', function ($row) {
                    $group = Group::where('id',$row->group_id)->first();
                    return $group->name;
        
               })



                ->rawColumns(['action','group_id'])

                ->make(true);

            return;
        }

        return view('shifts.index',compact('groups'));
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
                'day' => 'required|string',
                'group_id' => 'required',
                'start' => 'required',
                'end' => 'required',


            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'day' => $request->day,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,

        ];
      



        $id =  Shift::updateOrCreate(
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
        return  $this->editController($id, Shift::class);
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

                'day' => 'required|string',
                'group_id' => 'required',
                'start' => 'required',
                'end' => 'required',            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        $data = [
            'day' => $request->day,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,

        ];
      



        $id =  Shift::updateOrCreate(
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

        Shift::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
}
