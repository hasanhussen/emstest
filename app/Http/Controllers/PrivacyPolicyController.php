<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;


class PrivacyPolicyController extends Controller
{   use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:سياسةالخصوصية|تعديل سياسة', ['only' => ['index','store']]);
        $this->middleware('permission:تعديل سياسة', ['only' => ['edit','update']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            $data = PrivacyPolicy::get();


            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user){
    
                    if ($user->can('تعديل سياسة')){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    }
                    return $btn;
                })





                ->rawColumns(['action'])

                ->make(true);

            return;
        }

        return view('privacyPolicy.index');
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
         $validateErrors = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'body' => 'required',

        ]
    );
    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    } // end if fails .
    //        }
    $data = [
        'title' => $request->title,
        'body' => $request->body,

   

    ];
  



    $id =  PrivacyPolicy::updateOrCreate(
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
        return  $this->editController($id, PrivacyPolicy::class);
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
                'title' => 'required',
                'body' => 'required',

            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'title' => $request->title,
            'body' => $request->body,

       

        ];
      



        $id =  PrivacyPolicy::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;

        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController($id,PrivacyPolicy::class);
    }
}
