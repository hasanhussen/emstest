<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Notification;
use DataTables;
use Validator;

class NotificationController extends Controller
{
    use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        { if ($request->ajax()) {

            $data = Notification::get();
    
            return Datatables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row){
    
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
    
    
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';
    
                return $btn;
    
            })
          
            ->rawColumns(['action'])
    
            ->make(true);
        }
        return view('notifications.index');
    
    }
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
        $tokens = User::where("fcm",'!=',null)->get()->pluck('fcm');
       
        $this->sendFCM($tokens, $request->title, $request->details);
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
