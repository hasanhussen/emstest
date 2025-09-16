<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\Exam; // نموذج الامتحان
use App\Models\Subject; // نموذج المادة
use Carbon\Carbon; // لتحويل التاريخ والوقت


class ExamController extends Controller
{
    use allTrait;

    public function __construct()
    {
        $this->middleware('permission:الامتحانات|إضافة امتحان|تعديل امتحان|حذف امتحان', ['only' => ['index', 'store']]);
        $this->middleware('permission:إضافة امتحان', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل امتحان', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف امتحان', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // جلب جميع المواد
        $subjects = Subject::all();

        if ($request->ajax()) {
            $data = Exam::with('subject')->get(); // استرجاع الامتحانات مع المواد المرتبطة بها

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

        // تمرير المواد إلى العرض
        return view('exams.index', compact('subjects'));
    }

    public function create()
    {
        // إحضار جميع المواد من قاعدة البيانات
        $subjects = Subject::all();

        return view('exams.create', compact('subjects'));
    }

    public function store(Request $request)
{
    // التحقق من صحة البيانات
    $validateErrors = Validator::make(
        $request->all(),
        [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
        ]
    );

    if ($validateErrors->fails()) {
        return response()->json(['status' => 400, 'message' => $validateErrors->errors()->first()]);
    }

    // استخدام التاريخ كما هو بدون تحويل
    $examDate = $request->exam_date;

    // البيانات التي سيتم حفظها
    $data = [
        'name' => $request->name,
        'subject_id' => $request->subject_id,
        'exam_date' => $examDate,  // استخدام التاريخ كما هو
    ];

    // إضافة أو تحديث السجل في قاعدة البيانات
    $exam = Exam::updateOrCreate(
        ['id' => $request->id],  // إذا كان id موجودًا سيتم التحديث
        $data                    // البيانات التي سيتم حفظها أو تحديثها
    );

    // إرجاع النتيجة
    return response()->json(['status' => 200, 'message' => 'تم حفظ البيانات بنجاح.', 'data' => $exam]);
}


    public function show($id)
    {
        $exam = Exam::findOrFail($id);

        return view('exams.show', compact('exam'));
    }

    public function edit($id)
{
    // استرجاع الإجابة مع تحميل العلاقة الخاصة بها (مثل السؤال المرتبط)
    $answer = Exam::with('question')->findOrFail($id);

    // إرجاع البيانات بتنسيق JSON
    return response()->json($answer);
}

public function update(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validateErrors = Validator::make(
        $request->all(),
        [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
        ]
    );

    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    }

    // استخدام exam_date كما هو بدون تحويل
    $examDate = $request->exam_date;

    // البيانات التي سيتم تحديثها
    $data = [
        'name' => $request->name,
        'subject_id' => $request->subject_id,
        'exam_date' => $examDate,  // استخدام التاريخ كما هو
    ];

    // تحديث البيانات في قاعدة البيانات
    Exam::updateOrCreate(['id' => $id], $data);

    return response()->json(['status' => 200, 'message' => 'تم التعديل بنجاح.']);
}


    public function destroy($id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return response()->json(['status' => 404, 'message' => 'العنصر غير موجود.']);
        }

        $exam->delete();

        return response()->json(['status' => 200, 'message' => 'تم الحذف بنجاح.']);
    }
}
