<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\Patient;
use Carbon\Carbon;

class EntryController extends Controller
{   use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
 

        if ($request->ajax()) {

            $data = Entry::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;
                })


                ->addColumn('patient_id', function ($row) {
                    $patient = Patient::where('id',$row->patient_id)->first();
                    return $patient->name;
        
               })


                ->rawColumns(['action','patient_id'])

                ->make(true);

            return;
        }

        return view('entry.index');
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
                'date' => 'required',
                'patient_id' => 'required',


            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'user_id' => $request->user_id,
            'patient_id' => $request->patient_id,
            'cause' => $request->cause,
            'state' => $request->state,
            'exit_date' => $request->exit_date,

       

        ];
      
        if (empty($request->date)) {
            $data['date'] =Carbon::now()->format('Y-m-d');

        }
        else{
            $data['date'] = $request->date;
        
        }

        $id =  Entry::updateOrCreate(
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
        return  $this->editController($id, Entry::class);
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
                'date' => 'required',
                'patient_id' => 'required',


            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'user_id' => $request->user_id,
            'patient_id' => $request->patient_id,
            'cause' => $request->cause,
            'state' => $request->state,
            'exit_date' => $request->exit_date,

       

        ];
      
        if (empty($request->date)) {
            $data['date'] =Carbon::now()->format('Y-m-d');

        }
        else{
            $data['date'] = $request->date;
        
        }

        $id =  Entry::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;


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

        Entry::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }

  
}
