<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Complain;
use App\Models\ComplainType;
use App\Models\User;
use DataTables;

class complainsController extends Controller
{use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Complain::where('type','=', 0)->with('user1')->with('user2')->with('complain_type')->get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    

                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="info" class="btn btn-info btn-sm show"> <i class="fa fa-info"></i> </a>';

                return $btn;
    
            })
            ->addColumn('notes', function($row){
                   
                if(strlen($row->notes)>30){

               return mb_substr($row->notes, 0, 30) ."....";}
               
               else{
                return $row->notes;  
               }

            })
            ->addColumn('image',function ($row){

                return "<img src='".asset('storage/'.$row->image)."' width='50' height='50'>";
            })
            
            ->addColumn('value', function($row){
        
    
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="value" class="btn btn-primary btn-sm value"> تعويض </a>';

                
                return $btn;

            })
    
            ->rawColumns(['action','notes','image','value'])
    
            ->make(true);
        }

        
        return view('complains.index');
        }

        public function deleted(Request $request)

        {
            if ($request->ajax()) {
        
                $data = Complain::where('type','=', 1)->with('user1')->with('user2')->with('complain_type')->get();
        
                return Datatables::of($data)
        
                    ->addIndexColumn()
        
        
                    ->addColumn('action', function($row){
        
    
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="reject" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
        
                        
                        return $btn;
        
                    })

        
        
        
                    ->rawColumns(['action'])
        
                    ->make(true);
        
                return;
            }
            return view('complains.deleted_complain');
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

        return  $this->editController($id,Complain::class);
    
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
        $this->destroyController($id,Complain::class);

    }

    public function delete_complain(Request $request,$id)

    {
            Complain::where('id', $id)->update(['type' => "1",
        ]);
    
    }
}
