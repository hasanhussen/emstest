<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\User;
use DataTables;
use Validator;
use Hash;


class delegateController extends Controller
{ use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax() ) {

            $data = User::where('type','=', 2)->with('stars')->get();

            return DataTables::of($data)

            ->addIndexColumn()

       
            ->addColumn('action', function($row){

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="diamonds" class="btn btn-danger btn-sm banInfo"> <i class="fa fa-trash"></i> </a>';
                return $btn;
            })

           ->addColumn('user_image',function ($row){

            return "<img src='".asset('storage/users/uploads/'.$row->user_image)."' width='50' height='50'>";

       })
       ->addColumn('user_info_image',function ($row){

           return "<img src='".asset('storage/users/uploads/'.$row->user_info_image)."' width='50' height='50'>";

       })

       ->addColumn('front_car_image',function ($row){

           return "<img src='".asset('storage/users/uploads/'.$row->front_car_image)."' width='50' height='50'>";

       })
       ->addColumn('license_image',function ($row){

           return "<img src='".asset('storage/users/uploads/'.$row->license_image)."' width='50' height='50'>";

       })
       ->addColumn('back_car_image',function ($row){

           return "<img src='".asset('storage/users/uploads/'.$row->back_car_image)."' width='50' height='50'>";

       })
       ->addColumn('form_image',function ($row){

           return "<img src='".asset('storage/users/uploads/'.$row->form_image)."' width='50' height='50'>";

       })
         
           ->addColumn('sex',function($row){
            $sex="";

            if(( $row->sex)==0)
              {$sex= "  ذكر";}
           
            else
               {$sex=  " أنثى";}
          

             return $sex    ;

       })
       ->addColumn('stars',function ($row){
        $stars_sum =  $row->stars->pluck('stars');

        $rating =  $stars_sum->avg();
        return $this->showStars($rating);

      })

            ->rawColumns(['action','form_image','back_car_image','license_image',
            'front_car_image','user_info_image','user_image','sex','stars'])

            ->make(true);

            return;
        }
     
        return view('delegates.index');
    
    }


    public function delegate_requests(Request $request)

    {
        if ($request->ajax()) {
    
            $data = User::where('type','=', 5)->get();
    
            return Datatables::of($data)
    
                ->addIndexColumn()
    
    
                ->addColumn('action', function($row){
    
    
    
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="edit btn btn-success btn-sm accept"> <i class="ft ft-server"></i> قبول</a>';
    
                    
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="reject" class="btn btn-danger btn-sm banInfo"> <i class="fa fa-trash-o"></i> حظر</a>';
    
                    
                    return $btn;
    
                })
                ->addColumn('user_image',function ($row){

                    return "<img src='".asset('storage/users/uploads/'.$row->user_image)."' width='50' height='50'>";
        
               })
                ->addColumn('user_info_image',function ($row){

                    return "<img src='".asset('storage/users/uploads/'.$row->user_info_image)."' width='50' height='50'>";
         
                })
         
                ->addColumn('front_car_image',function ($row){
         
                    return "<img src='".asset('storage/users/uploads/'.$row->front_car_image)."' width='50' height='50'>";
         
                })
                ->addColumn('license_image',function ($row){
         
                    return "<img src='".asset('storage/users/uploads/'.$row->license_image)."' width='50' height='50'>";
         
                })
                ->addColumn('back_car_image',function ($row){
         
                    return "<img src='".asset('storage/users/uploads/'.$row->back_car_image)."' width='50' height='50'>";
         
                })
                ->addColumn('form_image',function ($row){
         
                    return "<img src='".asset('storage/users/uploads/'.$row->form_image)."' width='50' height='50'>";
         
                })
                  
                    ->addColumn('sex',function($row){
                     $sex="";
         
                     if(( $row->sex)==0)
                       {$sex= "  ذكر";}
                    
                     else
                        {$sex=  " أنثى";}
                   
         
                      return $sex    ;
         
                })
                
    
                ->rawColumns(['action','form_image','back_car_image','license_image',
                'front_car_image','user_info_image','user_image','sex'])
    
    
                ->make(true);
    
            return;
        }
        return view('delegates.delegate_requests');
    }

   
    public function banned(Request $request)
    {
        if ($request->ajax()) {
    
            $data = User::where('type','=', 4)->get();

            return DataTables::of($data)

            ->addIndexColumn()

       
            ->addColumn('action', function($row){

              
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="diamonds" class="btn btn-success btn-sm accept"> مقبول </a>';
                return $btn;
            })
            ->addColumn('user_image',function ($row){

                return "<img src='".asset('storage/users/uploads/'.$row->user_image)."' width='50' height='50'>";
    
           })
        
           ->addColumn('sex',function($row){
            $sex="";

            if(( $row->sex)==0)
              {$sex= "  ذكر";}
           
            else
               {$sex=  " أنثى";}
          

             return $sex    ;

       })
       

            ->rawColumns(['action','sex','user_image'])

            ->make(true);

            return;
        }
        return view('delegates.ban_delegate');
    }
   


    public function accept_delegate($id)

    {
        User::where('id', $id)->update(['type' => "2",
    ]);
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
        return  $this->editController($id,User::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $data= User::where(['id' => $request->_id])
        ->update([
        'type' => "4",
        'ban_info'=>$request->ban_info
       
    ]);
    return response()->json($data);  
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

        return response()->json(['success'=>' تم الحذف بنجاح']);   
         
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


