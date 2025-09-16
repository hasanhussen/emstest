<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class agentController extends Controller
{
    use allTrait;
    /**
     * Display a listing of the resource.

     * @return \Illuminate\Http\Response
     */
    function __construct()
{
$this->middleware('permission:المستخدمين|اضافة مستخدم|تعديل مستخدم|حذف مستخدم', ['only' => ['index','store']]);
$this->middleware('permission:اضافة مستخدم', ['only' => ['create','store']]);
$this->middleware('permission:تعديل مستخدم', ['only' => ['edit','update']]);
$this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
}
    public function index(Request $request)
    {
        $subscriptions=Subscription::get();

        $roles = Role::all();
        $user = User::first();

        if ($request->ajax()) {
            $user = auth()->user();
            $data = User::get();

            // $data = User::orderBy('id')->select('*');

            return DataTables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($row) use ($user){

                    if($user->hasrole('admin')){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                        $btn.= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                        $btn.= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="add" class="btn btn-info btn-sm add"> <i class="fa fa-plus"></i> </a>';
                        $btn.= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="profile" class="btn btn-info btn-sm profile"> <i class="fa fa-user"></i> </a>';

                    }


                    return $btn;
                })

                ->addColumn('avatar', function ($row) {

                    return "<img src='" . asset('storage/' . $row->avatar) . "' width='50' height='50'>";
                })

                ->addColumn('before', function ($row) {

                    return "<img src='" . asset('storage/' . $row->before) . "' width='50' height='50'>";
                })

                ->addColumn('after', function ($row) {

                    return "<img src='" . asset('storage/' . $row->after) . "' width='50' height='50'>";
                })

                ->addColumn('gender',function($row){

                    if(( $row->gender)== 0)
                      {$gender= "ذكر";}

                      if(( $row->gender)== 1)

                       {$gender=  " انثى";}


                     return $gender    ;

               })

               ->addColumn('subscription',function($row){

                if(( $row->subscription)== 0)
                  {$subscription= "غير مشترك";}

                  if(( $row->subscription)== 1)

                   {$subscription=  " مشترك";}


                 return $subscription    ;

           })


                ->rawColumns(['action', 'avatar','gender','subscription','before','after'])

                ->make(true);

            return;
        }

        return view('agents.index',compact('roles','subscriptions'));
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
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:6',

            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data =[ 'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'avatar' => $request->avatar,
        'role' => $request->role,
        'gender' => $request->gender,
        'birthday' => $request->birthday,
        'height' => $request->height,
        'weight' => $request->weight,


        'before' => $request->before,
        'after' => $request->after,
        'instagram' => $request->instagram,
        'facebook' => $request->facebook,
    ];


        $id =  User::updateOrCreate(

            ['id' => $request->_id],
            $data);




        $id->assignRole( $request->role);
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
        return  $this->editController($id, User::class);
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
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:6',

            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        $id =  User::updateOrCreate(


            ['id' => $request->_id],
           [ 'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'role' => $request->role,
            'gender' => $request->gender,
        'birthday' => $request->birthday,
        'height' => $request->height,
        'weight' => $request->weight,

        'before' => $request->before,
        'after' => $request->after,
        'instagram' => $request->instagram,
        'facebook' => $request->facebook,

        ]

        );
        $id->assignRole( $request->role);

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

        User::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
    }





}
