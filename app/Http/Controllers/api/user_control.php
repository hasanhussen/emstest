<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class user_control extends Controller
{

    public function login(Request $request)
{
    // البحث عن المستخدم بناءً على الإيميل
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'title' => "Not Found",
            'body' => "المستخدم غير موجود"
        ], 404);
    }

    // التحقق من كلمة السر
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'title' => "Invalid Credentials",
            'body' => "اسم المستخدم أو كلمة السر غير صحيحة"
        ], 401);
    }

    // التحقق من حالة الحساب (محظور أم لا)
    if ($user->blocked == 1) {
        return response()->json([
            'title' => "Account Blocked",
            'body' => "الرجاء التواصل مع الإدارة لتفعيل الحساب"
        ], 403);
    }

    // توليد التوكن باستخدام Str::random أو يمكن استخدام Passport أو Sanctum لتوليد التوكن
    // $user->api_token = Str::random(60); // إذا كنت لا تستخدم Passport أو Sanctum
    $user->api_token = Str::random(60); // توليد توكن جديد (في حال لم تستخدم Passport أو Sanctum)
    $user->save();

    // إرجاع التوكن وبيانات المستخدم
    return response()->json([
        'title' => "Login Successful",
        'api_token' => $user->api_token,
        'user' => $user
    ], 200);
}



    public function getprofile(Request $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم غير موجود"
            ];
            return response()->json($message, 404);
        } else {

            return response()->json($user);
        }
    }
    public function update(Request $request)
    {
        $user = User::all()->where('api_token', $request->token)->first();
        if (is_null($user)) {

            $message = [
                'title' => "Not Found",
                'body' => "المستخدم غير موجود"
            ];
            return response()->json($message, 404);
        } else {

            $user->name = $request->name;

            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->group_id = $request->group_id;
            $user->clinic_id =  $request->clinic_id;
            $base64String = $request->image;
            $decodedData = base64_decode($base64String);
            $fileName =  $request->imgname;
            $filePath = public_path('users/' . $fileName);
        file_put_contents($filePath, $decodedData);

        $user->avatar=$fileName;

            $user->save();
        }
        return response()->json($user, 200);
    }
}
