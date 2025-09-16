<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event; // استخدم النموذج المناسب
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Traits\allTrait;




class EventsController extends Controller
{
    /**
     * عرض قائمة الفعاليات.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:الفعاليات|اضافة فعالية|تعديل فعالية|حذف فعالية', ['only' => ['index','store']]);
        $this->middleware('permission:اضافة فعالية', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل فعالية', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف فعالية', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::all(); // جلب كل الفعاليات
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">تعديل</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">حذف</a>';
                    return $btn;
                })
                ->addColumn('type', function ($row) {
                    return $row->type; // عرض النوع0
                })
                ->addColumn('speakers', function ($row) {
                    return $row->speakers; // عرض المتحدثين
                })
                ->addColumn('participants', function ($row) {
                    return $row->participants; // عرض عدد المشاركين
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('events.index'); // تأكد من إنشاء الملف events.index
    }

    /**
     * تخزين حدث جديد.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|in:ورشة عمل,مؤتمر,ندوة',
            'event_date' => 'required|date',
            'speakers' => 'required|string',
            'participants' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }

        // تحديث أو إنشاء الحدث
        Event::updateOrCreate(
            ['id' => $request->id],
            $request->only(['name', 'type', 'event_date', 'speakers', 'participants'])
        );

        return response()->json(['status' => 200, 'message' => 'تم الحفظ بنجاح']);
    }

    /**
     * عرض صفحة تعديل الحدث.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // البحث عن الحدث بناءً على المعرّف
        $event = Event::findOrFail($id); // استخدام findOrFail لضمان الحصول على الحدث أو عرض خطأ 404 إذا لم يوجد

        return view('events.index', compact('event')); // إرجاع صفحة التعديل مع البيانات
    }

    /**
     * تحديث الحدث.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|in:ورشة عمل,مؤتمر,ندوة',
            'event_date' => 'required|date',
            'speakers' => 'required|string',
            'participants' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }

        // العثور على الحدث وتحديثه
        $event = Event::findOrFail($id);
        $event->update($request->only(['name', 'type', 'event_date', 'speakers', 'participants']));

        return response()->json(['status' => 200, 'message' => 'تم التحديث بنجاح']);
    }

    /**
     * حذف الحدث.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::findOrFail($id)->delete(); // استخدام findOrFail لضمان العثور على الحدث
        return response()->json(['status' => 200, 'message' => 'تم الحذف بنجاح']);
    }
}
