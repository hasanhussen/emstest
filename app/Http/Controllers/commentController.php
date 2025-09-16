<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Comment;
use App\Models\User;
use App\Models\Order;
use App\Models\UserStar;
use DataTables;
use Validator;

class commentController extends Controller
{    use allTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {

    // 
        
    }
    public function comment(Request $request,$id)
    {
        if ($request->ajax()) {

            $data = Comment::with('user1')->with('user2')->where('user1_id','=',$id)->get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-info btn-sm show"> <i class="fa fa-info"></i> </a>';

                return $btn;
    
            })
            ->addColumn('comment', function($row){
                   
                if(strlen($row->comment)>30){

               return mb_substr($row->comment, 0, 30) ."....";}
               
               else{
                return $row->comment;  
               }

            })
    
            ->rawColumns(['action','comment'])
    
            ->make(true);
            
            
          
        }
        $user1=User::find($id);

        return view('comments.index',compact('user1'));
    
    }

    public function agent_evaluate(Request $request)

    {
        if ($request->ajax()) {
    
            $data =User::where('type','=',1)->get();
    
            return Datatables::of($data)
    
                ->addIndexColumn()
    
    
                ->addColumn('action', function($row){
        
                    
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';

                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-info  btn-sm info"> <i class="fa fa-info"></i> </a>';

    
                    
                    return $btn;
    
                })
                
                ->addColumn('all', function($row){
        
                    $btn = '<a href="comment/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="comment" class="btn btn-info  btn-sm comment"> <i class="ft ft-server"></i> </a>';
 
                    return $btn;
    
                })
             
             

                ->addColumn('commentSum',function ($row){
             
                   $comments = comment::where('user1_id',$row->id)->count();

                return $comments;

                  })
                  ->addColumn('orderSum',function ($row){
     
                    //uesr1 is for the agents

                    $comments = Order::where('user1_id',$row->id)->where('order_status','=',1)->count();
                    return $comments;
                   })
   
                ->rawColumns(['action','commentSum','orderSum','all'])
    
                ->make(true);
    
            return;
        }
        return view('comments.agent_evaluate');
    }

    public function delegate_evaluate(Request $request)

    {
        if ($request->ajax()) {
    
            $data =User::where('type','=',2)->get();
    
            return Datatables::of($data)
    
                ->addIndexColumn()
    
    
                ->addColumn('action', function($row){
        
                    
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="reject" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';

                    $btn .= ' <a href="comment/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="reject" class="btn btn-danger btn-sm info"> <i class="fa fa-info"></i> </a>';
    

                    return $btn;
    
                })
               
                ->addColumn('commentSum',function ($row){
             
                   $comments = comment::where('user2_id',$row->id)->count();
                   return $comments;

                  })
                  ->addColumn('orderSum',function ($row){
                      
                    $comments = Order::where('user2_id',$row->id)->where('order_status','=',1)->count();
                    return $comments;

                   })
                   ->addColumn('all', function($row){
        
                    $btn = '<a href="comment/'.$row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="comment" class="btn btn-info  btn-sm comment"> <i class="ft ft-server"></i> </a>';

                    
                    return $btn;
    
                })
   
                ->rawColumns(['action','commentSum','orderSum','all'])
    
                ->make(true);
    
            return;
        }
        return view('comments.delegate_evaluate');
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
        return  $this->editController($id,Comment::class);

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
        $this->destroyController($id,Comment::class);
    }
}
