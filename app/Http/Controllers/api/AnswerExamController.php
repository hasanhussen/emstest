<?php

namespace App\Http\Controllers\api;

use App\Models\AnswerExam;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnswerExamController extends Controller
{
    /**
     * تخزين إجابة الطالب.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // التحقق من التوكن
        $user = User::where('api_token', $request->header('api_token'))->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'رمز التحقق غير صالح.',
            ], 401);
        }

        // التحقق من صحة البيانات القادمة من الطلب
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required|exists:exams,id',
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // إذا كان هناك أخطاء في التحقق، يتم إرجاعها
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'فشل التحقق من البيانات',
                'errors' => $validator->errors(),
            ], 422);
        }

        // تخزين البيانات في جدول answers_exam
        $answerExam = AnswerExam::create([
            'exam_id' => $request->exam_id,
            'question_id' => $request->question_id,
            'answer_id' => $request->answer_id,
            'user_id' => $request->user_id,
        ]);

        // إرجاع استجابة نجاح مع البيانات المخزنة
        return response()->json([
            'success' => true,
            'message' => 'تم تخزين الإجابة بنجاح',
            'data' => $answerExam,
        ], 201);
    }
}
