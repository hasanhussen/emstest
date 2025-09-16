<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Slider;
use Validator;
use DataTables;


class SliderController extends Controller
{
    use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Slider::get();

            return Datatables::of($data)

            ->addIndexColumn()

            ->addColumn('action', function($row){

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';


                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';

                return $btn;

            })->addColumn('image',function ($row){

                return "<img src='".asset('storage/'.$row->image)."' width='50' height='50'>";
            })

            ->rawColumns(['action','image'])

            ->make(true);
        }
        return view('slider.index');
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
            'Slidertitle' => 'required|string|min:3',

        ]);
    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    } // end if fails .
        //        }
        $data =[
            'Slidertitle' => $request->Slidertitle,

        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }



        $id =  Slider::updateOrCreate(['id' => $request->_id],
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
        // $item = Slider::find($id);

        // return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  $this->editController($id,Slider::class);
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
            'Slidertitle' => $request->Slidertitle,


        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }
        Slider::updateOrCreate(['id' => $request->_id],
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
        $this->destroyController($id,Slider::class);
    }
}
