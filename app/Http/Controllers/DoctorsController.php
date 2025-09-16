<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\Clinic;
use App\Models\DoctorGroup;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DoctorsController extends Controller
{ use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if ($request->ajax()) {

            $data = User::where('role','طبيب')->get();


            return DataTables::of($data)

                ->addIndexColumn()


             
        

            ->addColumn('clinic_id', function ($row) {
                $clinic = Clinic::where('id',$row->clinic_id)->first();
                return $clinic->name;
    
           })
           ->addColumn('group_id', function ($row) {
            $group = Group::where('id',$row->group_id)->first();
            return $group->name;

       })
          



            ->rawColumns(['clinic_id','group_id'])

                ->make(true);

            return;
        }

        return view('doctors.index' );
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
        //
    }
    
}
