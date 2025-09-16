<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\User;
use App\Models\UserStars;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class userController extends Controller
{  use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax() ) {

            $data = User::get();
            // $data = User::orderBy('id')->select('*');

            return DataTables::of($data)

            ->addIndexColumn()


            ->addColumn('action', function($row){

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                return $btn;
            })

           ->addColumn('avatar',function ($row){

            return "<img src='".asset('storage/users/uploads/'.$row->avatar)."' width='50' height='50'>";

       })




            ->rawColumns(['action','avatar'])

            ->make(true);

            return;
        }

        return view('agents.index');

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
        $validateErrors = Validator::make($request->all(),
        [
            'name' => 'string|required|min:3|max:200',
            'phone_number' => 'requir|unique:phone_number',
            'password' => 'required|min:6|max:20',
        ]);
    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    }
        $data =[
            'name'=>$request->name,
            'phone_number'=>$request->Phone_number,
            "password" => Hash::make($request->password),
            'type'=>$request->type,
            'sex'=>$request->sex,


        ];

        $user  = User::create($data);

        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' ]);
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
        return  $this->editController($id,User::class);
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
        $user = User::find($id);
        $data =[
            'name'=>$request->name,
            'phone_number'=>$request->Phone_number,
            "password" => Hash::make($request->password),

        ];
        if(!empty($request->password)){
            $data["password"]= Hash::make($request->password);
        }

        User::where('id',$id)->update($data,$user);
        // DB::table('model');


        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' ]);

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

        return response()->json(['success'=>' تم الحذف بنجاح']);    }


    public function showProfile(Request $request){
        if(!Auth::user()){

            return redirect()->route('user.login');
        }
        $user = Auth()->user();
        return view("admin.profile", compact('user'));
    }

    public function updateProfile(Request $request){

        $user = Auth()->user();
        $check = User::where([['id','!=',$user->id],['phone_number','=',$request->Phone_number]])->count();
        if($check > 0){
            return response()->json(['status'=>201]);
        }


        $user->name = $request->input("name");
        $user->Phone_number = $request->input("phone_number");
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['status'=>200]);


    }
    public function logout(){

        auth()->logout();

        return redirect(route('admin-login'));
        }


        public function postLogin(Request $request){

            $credentials = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);
        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('dashboard'));
                }

            return redirect()->route('admin-login')->with("error","البيانات المدخلة غير صحيحة");
            }


        public function showStars($rating)
        {

                           $out = "";
                           foreach(range(1,5) as $i){
                                $out .= '<span class="fa-stack" style="width:1em">
                                <i class="fa fa-star fa-stack-1x"></i>';



                               if($rating >0){
                                if($rating >0.5){
                                    $out .= '   <i class="fa fa-star fa-star-full fa-stack-1x" ></i>';
                                   }

                                   else{
                                    $out .= '    <i class="fa fa-star-half fa-stack-1x" ></i>';
                                   }
                               }



                             $rating--;
                            $out .=' </span>';
                            }

                                return $out;
        }
    public function getStars($id){

        $data=UserStars::where('user2_id','=',$id)->get();
        return response()->json($data);

    }

}
