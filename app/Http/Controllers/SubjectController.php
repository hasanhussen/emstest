<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\allTrait;
use App\Models\Subject;

class SubjectController extends Controller
{
    use allTrait;

    function __construct()
    {
        $this->middleware('permission:المواد|إضافة مادة|تعديل مادة|حذف مادة', ['only' => ['index', 'store']]);
        $this->middleware('permission:إضافة مادة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مادة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مادة', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // جلب جميع المواد
        $subjects = Subject::all();

        if ($request->ajax()) {
            $data = $subjects;

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
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validateErrors = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',        // اسم المادة
                'description' => 'nullable|string|max:1000', // وصف المادة
            ]
        );

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        // البيانات التي سيتم حفظها
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // إضافة أو تحديث السجل في قاعدة البيانات
        $subject = Subject::updateOrCreate(
            ['id' => $request->id],  // إذا كان id موجودًا سيتم التحديث
            $data                    // البيانات التي سيتم حفظها أو تحديثها
        );

        // إرجاع النتيجة
        return response()->json(['status' => 200, 'message' => 'تم حفظ البيانات بنجاح.', 'data' => $subject]);
    }

    public function show($id)
    {
        $subject = Subject::findOrFail($id);

        return view('subjects.show', compact('subject'));
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return response()->json($subject);

    }

    public function update(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validateErrors = Validator::make(
        $request->all(),
        [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]
    );

    // في حال وجود أخطاء في التحقق من البيانات
    if ($validateErrors->fails()) {
        return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
    }

    // البحث عن المادة باستخدام الـ ID
    $subject = Subject::find($id);

    // إذا لم يتم العثور على المادة
    if (!$subject) {
        return response()->json(['status' => 404, 'message' => 'المادة غير موجودة']);
    }

    // تحديث المادة
    $subject->name = $request->name;
    $subject->description = $request->description;
    $subject->save();

    return response()->json(['status' => 200, 'message' => 'تم التعديل بنجاح.']);
}


    public function destroy($id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return response()->json(['status' => 404, 'message' => 'العنصر غير موجود.']);
        }

        $subject->delete();

        return response()->json(['status' => 200, 'message' => 'تم الحذف بنجاح.']);
    }
}
