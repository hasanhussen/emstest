<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Patient;
use App\Models\PatientMedications;
use App\Models\pharmaceutical;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PatientMedicationsController extends Controller
{  use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        

        if ($request->ajax()) {
            $data = PatientMedications::get();


            return DataTables::of($data)

                ->addIndexColumn()


             

               
               ->addColumn('med_id', function ($row) {
                $med = pharmaceutical::where('id',$row->med_id)->first();
                return $med->name;
    
           })
           ->addColumn('patient_id', function ($row) {
            $patient = pharmaceutical::where('id',$row->patient_id)->first();
            return $patient->name;

       })
           ->addColumn('doctor_id', function ($row) {
            $doctor = User::where('id',$row->doctor_id)->first();
            return $doctor->name;

     })



                ->rawColumns(['gender','doctor_id','med_id'])

                ->make(true);

            return;
        }

        return view('pharmacy.patientMedications');
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
    public function showmed($id)
    {
        $medication = PatientMedications::where('patient_id',$id)->get();
        $patient = Patient::where('id',$id)->first();

        return view('pharmacy.patientMedications',compact('medication','patient'));

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
        //
    }
}
