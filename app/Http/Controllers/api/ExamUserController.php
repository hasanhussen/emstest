<?php
namespace App\Http\Controllers\API;

use App\Models\ExamUser;
use App\Models\User;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamUserController extends Controller
{
    // دالة لمعالجة دخول الطالب إلى الامتحان
    public function enterExam(Request $request, $userId, $examId)
    {
        // التحقق من api_token
        $apiToken = $request->header('api_token'); // الحصول على api_token من الهيدر
        $user = User::where('id', $userId)->where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->json([
                'message' => 'api_token غير صالح أو المستخدم غير موجود.',
                'status' => 'error'
            ], 401); // رمز حالة غير مصرح (Unauthorized)
        }

        // التحقق من وجود الامتحان
        $exam = Exam::findOrFail($examId);

        // التحقق مما إذا كان الطالب قد سجل في هذا الامتحان من قبل
        $examUser = ExamUser::where('user_id', $userId)
                            ->where('exam_id', $examId)
                            ->first();

        // إذا كان الطالب قد سجل في الامتحان من قبل
        if ($examUser) {
            return response()->json([
                'message' => 'لقد دخلت هذا الامتحان بالفعل، لا يمكنك الدخول مرة أخرى.',
                'status' => 'error'
            ], 400); // رمز حالة الخطأ 400 يعني أن الطلب غير صحيح
        }

        // إذا لم يدخل الامتحان من قبل، السماح له بالدخول
        $examUser = new ExamUser();
        $examUser->user_id = $userId;
        $examUser->exam_id = $examId;
        $examUser->save();

        return response()->json([
            'message' => 'تم الدخول إلى الامتحان بنجاح.',
            'status' => 'success',
            'data' => $examUser
        ], 200); // رمز حالة النجاح 200
    }
}
