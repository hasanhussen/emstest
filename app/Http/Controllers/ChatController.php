<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
    $this->middleware('permission:المحادثات|الرسائل', ['only' => ['index']]);
    $this->middleware('permission: الرسائل|المحادثات', ['only' => ['Message']]);
    }
    public function index(Request $request)

    { if ($request->ajax()) {

        $data = Chat::get();

        return DataTables::of($data)

        ->addIndexColumn()

        ->addColumn('action', function($row){

            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-eye"></i> </a>';



            return $btn;

        })
    

        ->addColumn('user1', function ($row) {
            $user = User::where('id',$row->user_id1)->first();
            return $user->name;

       })
       ->addColumn('user2', function ($row) {
        $user = User::where('id',$row->user_id2)->first();
        return $user->name;

   })           
           
                    
                    
                    
           ->rawColumns(['action','user1','user2'])

        ->make(true);
    }
    return view('chat.index');

    }
    public function Message(Request $request,$id)

    { $chat = Chat::where('id',$id)->first();
        if ($request->ajax()) {

        $data = Message::where('chat_id',$id)->get();

        return DataTables::of($data)

        ->addIndexColumn()

       
 

        ->addColumn('user', function ($row) {
            $user = User::where('id',$row->user_id)->first();
            return $user->name;
    
       })           
               
                        
                        
                        
               ->rawColumns(['user'])
    

        ->make(true);
    }
    return view('chat.messages',compact('chat'));

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
