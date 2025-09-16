<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Tax;
use DataTables;
use Validator;

class taxController extends Controller
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

            $data = Tax::get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
    
                return $btn;
    
            })
    
            ->rawColumns(['action'])
    
            ->make(true);
        }
        return view('taxes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */





  public function get_tax(Request $request){
        $tax = Tax::where(['id',1])->get()->first();
        return response()->json($tax);

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

        $data =[
            'tax' => $request->tax,

        ];
        
        $id =  Tax::updateOrCreate(['id' => $request->_id],
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
        return  $this->editController($id,Tax::class);

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
            'tax' => $request->tax,
        ];
        
        Tax::updateOrCreate(['id' => $request->_id],
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
// 
    }
}
