<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    function __construct()
{
$this->middleware('permission:الصلاحيات|اضافة الصلاحية|تعديل الصلاحية|حذف صلاحية', ['only' => ['index','store']]);
$this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
$this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
$this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
}
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Permission::all();

            // $data = User::orderBy('id')->select('*');

            $user = auth()->user();
            return DataTables::of($data)
    
            ->addIndexColumn()
    
            ->addColumn('action', function($row) use ($user) {
                      
                if ($user->can('تعديل صلاحية') & $user->can('حذف صلاحية')){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="diamonds" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
    
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                }
                    return $btn;
                })

             




                ->rawColumns(['action'])

                ->make(true);

            return;
        }

        return view('permissions.index');    }
      
    

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {

     
        
        $validateErrors = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
              

            ]
        );
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        //        }
        $data = [
            'name' => $request->name,


        ];
        if (!empty($request->avatar)) {
            $data['avatar'] = $request->avatar;
        }



        $id =  Permission::updateOrCreate(
            ['id' => $request->_id],
            $data
        )->id;

        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات  بنجاح .', "data" => null]);
    }

    public function edit( $id)
    {       
        return  $this->editController($id, Permission::class);
    }

    public function update(Request $request,  $id)
    {
        $data = [
            'name' => $request->name,
          


        ];
      
        Permission::updateOrCreate(
            ['id' => $request->_id],
            $data
        );


        return response()->json(['status' => 200, 'message' => ' تم حفظ البيانات بنجاح    .']);
    }

    public function destroy( $id)
    {  Permission::find($id)->delete();

        return response()->json(['success' => ' تم الحذف بنجاح']);
     


    }

    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
        
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }
}