<?php
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:الأجوبة|إضافة إجابة|تعديل إجابة|حذف إجابة', ['only' => ['index', 'store']]);
        $this->middleware('permission:إضافة إجابة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل إجابة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف إجابة', ['only' => ['destroy']]);
    }

    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Answer::with('question')->get();

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

    $questions = Question::all(); // اجلب قائمة الأسئلة
    return view('answers.index', compact('questions')); // مررها إلى العرض
}

    public function create()
    {
        $questions = Question::all();
        return view('answers.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $validateErrors = Validator::make(
            $request->all(),
            [
                'answer_text' => 'required|string|max:255',
                'is_correct' => 'required|in:0,1', // قبول القيم 0 أو 1
                'question_id' => 'required|exists:questions,id',
            ]
        );

        if ($validateErrors->fails()) {
            return response()->json(['status' => 400, 'message' => $validateErrors->errors()->first()]);
        }

        $data = [
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct ? true : false, // تحويل القيمة إلى boolean
            'question_id' => $request->question_id,
        ];

        $answer = Answer::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json(['status' => 200, 'message' => 'تم حفظ البيانات بنجاح.', 'data' => $answer]);
    }

    public function edit($id)
{
    // استرجاع الإجابة مع تحميل العلاقة الخاصة بها (مثل السؤال المرتبط)
    $answer = Answer::with('question')->findOrFail($id);

    // إرجاع البيانات بتنسيق JSON
    return response()->json($answer);
}


    public function update(Request $request, $id)
    {
        $validateErrors = Validator::make(
            $request->all(),
            [
                'answer_text' => 'required|string|max:255',
                'is_correct' => 'required|in:0,1', // قبول القيم 0 أو 1
                'question_id' => 'required|exists:questions,id',
            ]
        );

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        $data = [
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct ? true : false, // تحويل القيمة إلى boolean
            'question_id' => $request->question_id,
        ];

        Answer::updateOrCreate(['id' => $id], $data);

        return response()->json(['status' => 200, 'message' => 'تم التعديل بنجاح.']);
    }

    public function destroy($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return response()->json(['status' => 404, 'message' => 'العنصر غير موجود.']);
        }

        $answer->delete();

        return response()->json(['status' => 200, 'message' => 'تم الحذف بنجاح.']);
    }
}
