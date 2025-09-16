<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use App\Models\Payment;
use App\Models\CardsType;
use DataTables;
use Validator;

class paymentController extends Controller
{
    use allTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if ($request->ajax()) {
                $st = $request->input("st");
                $ed = $request->input("ed");
    
                if( !empty($st) && !empty($ed))
                {
                   $data=Payment::with('user')->with('card')->whereBetween('created_at', [$st, $ed])->get();
    
                }
                else{
                    $data = Payment::with('user')->with('card')->get();
                }
           

            return Datatables::of($data)

            ->addIndexColumn()

            ->addColumn('action', function($row){


                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash-o"></i> </a>';

                return $btn;

            })
            ->rawColumns(['action'])

            ->make(true);
        }}
        return view('payment.index');
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

            'user_id' => $request->user_id,
            'card_id' => $request->card_id,
            'owner_name' => $request->owner_name,
            'payType' => $request->payType,
            'code' => $request->code,
            'expirationDate' => $request->expirationDate,
            'csc' => $request->csc,
        ];

        $id =  Payment::updateOrCreate(['id' => $request->_id], $data)->id;

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
        return  $this->editController($id,Transfer::class);
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
        $data =[

            'user_id' => $request->user_id,
            'card_id' => $request->card_id,
            'owner_name' => $request->owner_name,
            'payType' => $request->payType,
            'code' => $request->code,
            'expirationDate' => $request->expirationDate,
            'csc' => $request->csc,

        ];

        Payment::updateOrCreate(['id' => $request->_id],
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
        // Cardtype::where('transtype_id',$id)->delete();
        $this->destroyController($id,Payment::class);
    }
}
