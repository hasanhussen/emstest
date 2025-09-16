<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\FollowUpFile;
use App\Models\User;
use Illuminate\Http\Request;

class follow_upsController extends Controller
{
    public function add(Request  $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();

        if ($user->role == 'طبيب' ||  $user->role == 'admin') {

            $followUp = new FollowUp();


            $followUp->patient_id = $request->patient_id;
            $followUp->clinic_id = $request->clinic_id;
            $followUp->follow_up = $request->follow_up;
            $followUp->note = $request->note;
            $followUp->alert = $request->alert;
            $followUp->date = $request->date;
            $followUp->time = $request->time;
            $followUp->doctor_id = $user->id;

            $followUp->save();
            if ($request->file) {
            
                function getFileType($extension) {
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            return 'image';
                            case 'mp3':
                            case 'wav':
                                return 'audio';
                            case 'pdf':
                                return 'PDF';
                            case 'mp4':
                            case 'avi':
                            case 'mov':
                                return 'video';
                        default:
                            return 'غير معروف';
                    }
                }
          
            
               
                    $files = new FollowUpFile();
                    $files->followup_id =  $followUp->id;
                    $file = $request->file;
                    $filename = $request->filename;
                    $decoded = base64_decode($file);
            
           
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $fileType = getFileType($extension);
            
       
                    switch ($fileType) {
                        case 'image':
                            $folderName = 'images';
                            break;
                        case 'audio':
                            $folderName = 'audio';
                            break;
                        case 'PDF':
                            $folderName = 'pdf';
                            break;
                        case 'video':
                            $folderName = 'videos';
                            break;
                        default:
                            $folderName = 'other';
                            break;
                    }
            
                    $folderPath = public_path('files/' . $folderName);
                    $file = $folderPath . '/' . $filename;
                    file_put_contents($file, $decoded);
                    $files->file =  $filename;
            
                    $files->save();
                }
            $followUp->load('patient')->load('doctor')->load('clinic')->load('file');

            return response()->json($followUp, 200);
        } else {
            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }

    public function index(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $follow_ups = FollowUp::where('patient_id', $request->patient_id)->where('doctor_id', $user->id)->get();
            $follow_ups->load('patient')->load('doctor')->load('clinic')->load('file');

            return  $follow_ups;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function otherFollow_ups(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $follow_ups = FollowUp::where('patient_id', $request->patient_id)->where('doctor_id','!=', $user->id)->get();
            $follow_ups->load('patient')->load('doctor')->load('clinic')->load('file');

            return  $follow_ups;
        } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function remove(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $follow_ups = FollowUp::where('id', $request->id)->first();
$file=FollowUpFile::where('followup_id', $follow_ups->id)->first();
         $follow_ups->delete();
         $file->delete();

            $message = [
                'body' => "تم حذف المتابعة "
            ];
            return response()->json($message, 200);
                } else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
    public function update(Request  $request)
    {
        $user = User::where('api_token', $request->token)->first();


        if ($user->role == 'طبيب' ||  $user->role == 'admin') {
            $followUp = FollowUp::where('id', $request->id)->first();

            $followUp->patient_id = $followUp->patient_id;
            $followUp->clinic_id = $request->clinic_id;
            $followUp->follow_up = $request->follow_up;
            $followUp->note = $request->note;
            $followUp->alert = $request->alert;
            $followUp->date = $request->date;
            $followUp->time = $request->time;
            $followUp->doctor_id = $user->id;

            $followUp->save();
            if ($request->file) {
            
                function getFileType($extension) {
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            return 'image';
                            case 'mp3':
                            case 'wav':
                                return 'audio';
                            case 'pdf':
                                return 'PDF';
                            case 'mp4':
                            case 'avi':
                            case 'mov':
                                return 'video';
                        default:
                            return 'غير معروف';
                    }
                }
          
            

                    $files =  FollowUpFile::where('followup_id', $followUp->id)->first();
                    $files->followup_id =  $followUp->id;
                    $file = $request->file;
                    $filename = $request->filename;
                    $decoded = base64_decode($file);
            
           
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $fileType = getFileType($extension);
            
       
                    switch ($fileType) {
                        case 'image':
                            $folderName = 'images';
                            break;
                        case 'audio':
                            $folderName = 'audio';
                            break;
                        case 'PDF':
                            $folderName = 'pdf';
                            break;
                        case 'video':
                            $folderName = 'videos';
                            break;
                        default:
                            $folderName = 'other';
                            break;
                    }
            
                    $folderPath = public_path('files/' . $folderName);
                    $file = $folderPath . '/' . $filename;
                    file_put_contents($file, $decoded);
                    $files->file =  $filename;
            
                    $files->save();}
            $followUp->load('patient')->load('doctor')->load('clinic')->load('file');

            return response()->json($followUp, 200);}
                 else {

            $message = [
                'body' => "المستخدم ليس له صلاحية "
            ];
            return response()->json($message, 403);
        }
    }
}
