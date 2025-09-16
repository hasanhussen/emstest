<?php

namespace App\Http\Controllers\api;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        // التحقق من وجود التوكن وصحة المستخدم
        $user = Auth::guard('api')->user(); // الحصول على المستخدم الحالي باستخدام الـ API guard

        // التحقق من أن المستخدم موجود
        if (!$user) {
            return response()->json(['error' => 'No user found'], 401);
        }

        // التأكد من أن دور المستخدم هو "طالب"
        if (!$user->hasRole('طالب')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // جلب تاريخ اليوم
        $today = Carbon::today()->toDateString();

        // جلب المواد مع الامتحانات التي تكون بتاريخ اليوم
        $subjects = Subject::with(['exams' => function ($query) use ($today) {
            $query->whereDate('exam_date', $today); // استبدل "exam_date" باسم العمود الخاص بتاريخ الامتحان
        }])->get();

        // إرجاع المواد بتنسيق JSON
        return response()->json([
            'status' => 'success',
            'subjects' => $subjects
        ]);
    }
}



