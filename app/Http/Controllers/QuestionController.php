<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:الأسئلة|إضافة سؤال|تعديل سؤال|حذف سؤال', ['only' => ['index', 'store']]);
        $this->middleware('permission:إضافة سؤال', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل سؤال', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف سؤال', ['only' => ['destroy']]);
    }

    public function index(Request $request)
{
    // جلب جميع الاختبارات
    $exams = Exam::all();

    // جلب جميع الأسئلة مع الربط مع الاختبارات
    $questions = Question::with('exam')->get();

    // إذا كانت الطلبات من نوع AJAX
    if ($request->ajax()) {
        $data = $questions;

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-sm edit"><i class="fa fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // تمرير كل من الأسئلة والاختبارات إلى العرض
    return view('questions.index', compact('questions', 'exams'));
}


    public function create()
    {
        $exams = Exam::all(); // جلب الاختبارات
        return view('questions.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $validateErrors = Validator::make(
            $request->all(),
            [
                'exam_id' => 'required|exists:exams,id', // التحقق من وجود الاختبار
                'question_text' => 'required|string|max:1000', // نص السؤال
            ]
        );

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        $data = [
            'exam_id' => $request->exam_id,
            'question_text' => $request->question_text,
        ];

        $question = Question::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json(['status' => 200, 'message' => 'تم حفظ البيانات بنجاح.', 'data' => $question]);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.show', compact('question'));
    }

    public function edit($id)
{
    $question = Question::with('exam')->findOrFail($id);
    return response()->json($question);
}


public function update(Request $request, $id)
{
    $validateErrors = Validator::make(
        $request->all(),
        [
            'exam_id' => 'required|exists:exams,id',
            'question_text' => 'required|string|max:1000',
        ]
    );

    if ($validateErrors->fails()) {
        return response()->json(['status' => 422, 'message' => $validateErrors->errors()->first()]);
    }

    $data = [
        'exam_id' => $request->exam_id,
        'question_text' => $request->question_text,
    ];

    // تحديث أو إنشاء السؤال
    $updated = Question::updateOrCreate(['id' => $id], $data);

    if ($updated) {
        return response()->json(['status' => 200, 'message' => 'تم التعديل بنجاح.']);
    } else {
        return response()->json(['status' => 500, 'message' => 'حدث خطأ أثناء التعديل.']);
    }
}


    public function destroy($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['status' => 404, 'message' => 'العنصر غير موجود.']);
        }

        $question->delete();

        return response()->json(['status' => 200, 'message' => 'تم الحذف بنجاح.']);
    }
}
