<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\FollowUpFile;
use App\Models\Patient;
use Illuminate\Http\Request;

class Follow_upsController extends Controller
{
    public function showFollow_ups($id)
    {
        $follow_ups = FollowUp::where('patient_id',$id)->get();
        $patient = Patient::where('id',$id)->first();

        return view('follow_ups.index',compact('follow_ups','patient'));

    }
    public function showfiles($id)
    {
        $follow_ups = FollowUp::find($id);
        $file=FollowUpFile::where('followup_id',$follow_ups->id)->first();
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
            $extension = pathinfo($file->file, PATHINFO_EXTENSION);
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

        return view('follow_ups.files',compact('follow_ups','file','fileType','folderName'));

    }
}
