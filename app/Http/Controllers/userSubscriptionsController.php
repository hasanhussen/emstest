<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\allTrait;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
class userSubscriptionsController extends Controller
{use allTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    $this->middleware('permission:اشتراكات المستخدمين', ['only' => ['index','store']]);
    $this->middleware('permission:اضافة اشتراك لمستخدم', ['only' => ['store']]);
    $this->middleware('permission:تعديل اشتراك لمستخدم', ['only' => ['update']]);
    $this->middleware('permission:حذف اشتراك لمستخدم', ['only' => ['destroy']]);
    }
        public function index(Request $request)
        {
         $subscriptions=Subscription::get();

            if ($request->ajax()) {

                $data = UserSubscription::get();

                return DataTables::of($data)

                    ->addIndexColumn()


                   ->addColumn('action', function ($row) {

                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="decline" class="btn btn-danger btn-sm decline"> <i class="fa fa-edit"></i> </a>';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="accept" class="edit btn btn-primary btn-sm accept"> <i class="fa fa-edit"></i> </a>';
                        return $btn;
                    })


                    ->addColumn('user_id', function ($row) {
                        $user = User::where('id',$row->user_id)->first();
                        return $user->name;

                   })



                    ->addColumn('subscription_id', function ($row) {

                        $subscription = Subscription::where('id', $row->subscription_id)->first();
                        return $subscription->name;
                    })
                    ->addColumn('state',function($row){

                        if(( $row->state)== 0)
                          {$state= "قيد الانتظار";}

                          elseif(( $row->state)== 1)

                           {$state=  " مقبول";}

                           else {
                            $state=  " مرفوض";}
                         return $state    ;

                   })

                    ->rawColumns(['action','user_id','subscription_id','state'])

                    ->make(true);

                return;
            }

            return view('usersubscriptions.index',compact('subscriptions'));
        }




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

         /*   $validateErrors = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
           ]
            );
            if ($validateErrors->fails()) {
                return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
            } // end if fails .
            //        }
            $sub = Subscription::where('id',$request->subscription_id)->first();

            $data = [
                'date' => $request->date,
                'user_id' => $request->user_id,
                'price' => $sub->price,
                'subscription_id' => $request->subscription_id
            ];




            $id =  UserSubscription::updateOrCreate(
                ['id' => $request->_id],
                $data
            )->id;

            return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
       */ }

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
            return  $this->editController($id, UserSubscription::class);
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
         }
         public function usersub_decline( $id)
         {
         $userSub=UserSubscription::find($id);

     $userSub->state=2;
     $userSub->save();

             return response()->json(['status' => 200, 'message' => ' تم  الرفض  بنجاح .', "data" => null]);

          }
          public function usersub_accept( $id)
          {
          $userSub=UserSubscription::find($id);

      $userSub->state=1;
      $userSub->save();
              return response()->json(['status' => 200, 'message' => ' تم  القبول  بنجاح .', "data" => null]);

           }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {

            UserSubscription::find($id)->delete();

            return response()->json(['success' => ' تم الحذف بنجاح']);
        }

        public function addsubscription(Request $request,$id)
        {
            $sub = Subscription::where('id',$request->subscription_id)->first();
                        $usersub = new UserSubscription();

                        $date = $usersub->created_at;
                        $carbon = Carbon::parse($date);
           $newDate = $carbon->addMonths(1)->format('Y-m-d');


            $usersub->user_id = $id;
            $usersub->price = $sub->price;
            $usersub->subscription_id = $request->subscription_id;
            $usersub->date = $newDate;

            $usersub->save();
            $user=User::where('id',$id)->first();
            $user->subscription='1';
            $user->save();

            return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
        }
    }
    