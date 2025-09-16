<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Repayment;
use App\Models\Complain;
use App\Models\User;
use DataTables;
use Validator;

class repaymentController extends Controller
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

            $data = Repayment::with('complain_no')->with('complain_user')->get();
                 
            return Datatables::of($data)

            ->addIndexColumn()

            ->addColumn('action', function($row){


                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"> <i class="fa fa-trash-o"></i> </a>';

                return $btn;

            })
            ->addColumn('details', function($row){


                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="details" class="btn btn-info btn-sm details">  <i class="fa fa-edit"></i></a>';

                return $btn;

            })
            ->rawColumns(['action','details'])

            ->make(true);
        }

        
        return view('repayments.index');
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



      
    public function get_repayment_data($id)
    {
        $data = Complain::with('user1')
        ->with('user2')->with('complain_type')->find($id);


        return response()->json($data);
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
        return  $this->editController($id,Repayment::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
      
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
        $this->destroyController($id,Repayment::class);
    }
}
