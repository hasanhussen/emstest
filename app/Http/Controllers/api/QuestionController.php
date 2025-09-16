<?php

namespace App\Http\Controllers\api;

use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class QuestionController extends Controller
{

    public function index(Request $request)
    {
        // التحقق من وجود التوكن وصحة المستخدم
        $user = Auth::guard('api')->user();
       // الحصول على المستخدم الحالي باستخدام الـ API guard

        // التحقق من أن المستخدم موجود
        if (!$user) {
            return response()->json(['error' => 'No user found'], 401);
        }

        // جلب exam_id من الطلب
        $examId = $request->input('exam_id');

        // إذا كان exam_id موجودًا، قم بفلترة الأسئلة بناءً عليه
        if ($examId) {
            $questions = Question::with('answers')
                ->where('exam_id', $examId)  // فلترة الأسئلة حسب exam_id
                ->get();
        } else {
            // إذا لم يكن exam_id موجودًا، جلب جميع الأسئلة
            $questions = Question::with('answers')->get();
        }

        // إضافة إجابة صحيحة إذا كانت موجودة
        $questions->map(function ($question) {
            // البحث عن الإجابة الصحيحة من بين الأجوبة المرتبطة
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            $question->correct_answer = $correctAnswer ? $correctAnswer->answer_text : null;

            return $question;
        });

        // إرجاع البيانات كاستجابة بصيغة JSON
        return response()->json([
            'status' => 200,
            'data' => $questions,
        ]);
    }
}
