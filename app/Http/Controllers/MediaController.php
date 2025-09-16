<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function storeMedia(Request $request , $table)
    {

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $name =  "";
        $path = "";
        switch ($table){


            case "company_types":
                $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                $path = storage_path('app/public/company_types/uploads');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $name = "company_types/uploads/".$name;
                break;

                case "companies":
                    $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                    $path = storage_path('app/public/companies/uploads');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $name = "companies/uploads/".$name;
                    break;
                    case "pharmaceutical":
                        $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                        $path = storage_path('app/public/pharmaceutical/uploads');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $name = "pharmaceutical/uploads/".$name;
                        break;

                case "clinics":
                    $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                    $path = storage_path('app/public/clinics/uploads');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $name = "clinics/uploads/".$name;
                    break;

                    case "Vitalsigns":
                        $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                        $path = storage_path('app/public/Vitalsigns/uploads');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $name = "Vitalsigns/uploads/".$name;
                        break;

                case "users":
                    $name = "users". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                    $path = storage_path('app/public/users/uploads');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $name = "users/uploads/".$name;
                    break;

                    
                case "company_products":
                    $name = "company_products". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                    $path = storage_path('app/public/company_products/uploads');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $name = "company_products/uploads/".$name;
                    break;

                    case "complains":
                        $name = "complains". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                        $path = storage_path('app/public/complains/uploads');
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $name = "complains/uploads/".$name;
                        break;

                        case "about":
                            $name = "cataloges". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                            $path = storage_path('app/public/about/uploads');
                            if (!file_exists($path)) {
                                mkdir($path, 0777, true);
                            }
                            $name = "about/uploads/".$name;
                            break;

                            case "sliders":
                                $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                                $path = storage_path('app/public/sliders/uploads');
                                if (!file_exists($path)) {
                                    mkdir($path, 0777, true);
                                }
                                $name = "sliders/uploads/".$name;
                                break;
                                case "xray":
                                    $name = "image". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                                    $path = storage_path('app/public/xray/uploads');
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                                    $name = "xray/uploads/".$name;
                                    break;


        }

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
            "img2"=>str_replace("/","_",$name)
        ]);
    }

    
    public function destroyMedia($table, Request $request){
        switch ($table){
            // case "users":
            //     $item = User::find($request->user_id);
            //     $images = explode(",",$item->images);
            //     $key = array_search($request->image, $images);
            //     if($key !== false){

            //         unset($images[$key]);
            //     }
            //     $images =implode(",",$images);

            //     User::where('id','=',$request->user_id)->update(['images'=>$images]);
            //     return response()->json(["status"=>200,"images" =>$images, "img"=>$request->image , "img2"=>str_replace("/","_",$images)]);
            //     break;


            // case "offer_products":
            //     $item = Product::find($request->product_id);
            //     $offer_images = explode(",",$item->offer_image);
            //     $key = array_search($request->image, $offer_images);
            //     if($key !== false){

            //         unset($offer_images[$key]);
            //     }
            //     $offer_images =implode(",",$offer_images);

            //     Product::where('id','=',$request->product_id)->update(['offer_image'=>$offer_images]);
            //     return response()->json(["status"=>200,"offer_image" =>$offer_images, "img"=>$request->image , "img2"=>str_replace("/","_",$offer_images)]);
            //     break;
        }

    }


}
