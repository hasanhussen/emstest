<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\About;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class aboutUsController extends Controller
{
    use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:من نحن|تعديل من نحن', ['only' => ['index','store']]);
    $this->middleware('permission:تعديل من نحن', ['only' => ['edit','update']]);
    }
        public function index(Request $request)
        {
           
    
            if ($request->ajax()) {
                $user = auth()->user();
                $data = About::get();
    
                // $data = User::orderBy('id')->select('*');
    
                return DataTables::of($data)
    
                    ->addIndexColumn()
    
    
                    ->addColumn('action', function ($row) use ($user){
    
                        if ($user->can('تعديل من نحن') ){
            
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                        }
                        return $btn;
                    })
    
                    ->addColumn('image', function ($row) {
    
                        return "<img src='" . asset('storage/' . $row->image) . "' width='50' height='50'>";
                    })
    
                   
    
    
    
                    ->rawColumns(['action', 'image'])
    
                    ->make(true);
    
                return;
            }
    
            return view('about.index');
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
       
        
        $data =[
            'title' => $request->title,
            'phone' => $request->phone,
            'email' => $request->email,
            'overview' => $request->overview,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'whatsApp' => $request->whatsApp,
            'telegram' => $request->telegram,


        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }



        $id =  About::updateOrCreate(['id' => $request->_id],
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
        return  $this->editController($id,About::class);

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
                'email' => 'email',
                'facebook' => 'url',
                'twitter' => 'url',
                'instagram' => 'url',


            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        $data =[
            'title' => $request->title,
            'phone' => $request->phone,
            'email' => $request->email,
            'overview' => $request->overview,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'whatsApp' => $request->whatsApp,
            'telegram' => $request->telegram,


        ];
        if(!empty($request->image)){
            $data['image'] = $request->image;
        }
        About::updateOrCreate(['id' => $request->_id],
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
        $this->destroyController($id,About::class);
    }
}
