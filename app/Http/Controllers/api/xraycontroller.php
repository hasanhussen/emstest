<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Xray;
use App\Models\XrayImage;
use Illuminate\Http\Request;

class xraycontroller extends Controller
{
    public function addxray(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();

        if ($user->role == 'الاسعاف' ||  $user->role == 'admin') {

            $xray = new Xray();


            $xray->patient_id = $request->patient_id;
            $xray->user_id = $user->id;
            $xray->time = $request->time;
            $xray->date = $request->date;
            $xray->imageType = $request->imageType;
            $xray->part = $request->part;
            $xray->injection = $request->injection;
            $xray->state = $request->state;

            $xray->save();


            $xrayimg = new XrayImage();
            if ($request->images) {
                $folderPath =  storage_path('app/public/xray/uploads/');

                foreach ($request->images as $data) {
                    $image = $data['image'];
                    $imgname = $data['imgname'];
                    $decodedImage = base64_decode($image);
                    $file = $folderPath . $imgname;
                    file_put_contents($file, $decodedImage);
                    $xrayimg->image = "xray/uploads/" . $imgname;
                    $xrayimg->image_id = $xray->id;
                    $xrayimg->save();
                }
            }
            return response()->json($xray, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function getxray(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'الاسعاف' ||  $user->role == 'admin') {
            $xray = Xray::where('patient_id', $request->patient_id)->with('image')->get();


            return  $xray;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
