<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{  use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:الدول|حذف دولة', ['only' => ['index']]);
 
    $this->middleware('permission:حذف دولة', ['only' => ['destroy']]);
    }
    public function index(Request $request){
        if ($request->ajax()) {

            $data = Country::get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('code',function ($row){

                return "<img src='".asset('blade-flags/'.$row->code)."' width='50' height='50'>";
            })
           
            ->addColumn('action', function ($row){

          
                    $btn= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
          
 
                return $btn;
            })
            ->rawColumns(['action','code'])
    
            ->make(true);
        }
        return view("countries.index");
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
}
