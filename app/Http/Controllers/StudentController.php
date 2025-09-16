<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Middleware to manage permissions
     */
    public function __construct()
    {
        $this->middleware('permission:المستخدمين|اضافة مستخدم|تعديل مستخدم|حذف مستخدم', ['only' => ['index', 'store']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::get();

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

        return view('users.index');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }

        // Create or update user
        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'api_token' => Str::random(60), // Generate API token
            ]
        );

        // Assign role to the user
        $user->assignRole($request->role);

        return response()->json(['status' => 200, 'message' => 'تم حفظ المستخدم بنجاح', 'data' => $user]);
    }


    public function edit($id)
{
    // البحث عن الطالب بناءً على ID
    $student = User::findOrFail($id);

    // إعادة البيانات كـ JSON للاستجابة
    return response()->json($student);
}


    /**
     * Update an existing user
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }

        // Update user data
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Assign role
        $user->assignRole($request->role);

        return response()->json(['status' => 200, 'message' => 'تم تحديث المستخدم بنجاح', 'data' => $user]);
    }

    /**
     * Remove a user from storage
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['status' => 200, 'message' => 'تم حذف المستخدم بنجاح']);
    }
}
