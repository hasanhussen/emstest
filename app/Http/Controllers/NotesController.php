<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NotesController extends Controller
{ use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* function __construct()
    {
    $this->middleware('permission:المرضى', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة مريض', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل مريض', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف مريض', ['only' => ['destroy']]);
    }*/
    public function index(Request $request)
    {

        

        if ($request->ajax()) {
            $user = auth()->user();
            $data = Note::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user) {
                  
                    if ($user->can('تعديل مريض') && $user->can('حذف مريض')){
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    }

                    return $btn;
                })

        
           



                ->rawColumns(['action'])

                ->make(true);

            return;
        }

        return view('notes.index');
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
                'note' => 'required',
       
  
            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'request_id' => $request->request_id,
            'note' => $request->note,
            'user_id' => $request->user_id,

        ];
      



        $id =  Note::updateOrCreate(
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
        return  $this->editController($id, Note::class);
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
            'request_id' => $request->request_id,
            'note' => $request->note,
            'user_id' => $request->user_id,
        ];
      
        Note::updateOrCreate(
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

        Note::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }
}