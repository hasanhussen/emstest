<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // قائمة الصلاحيات
        $permissions = [
            'الادوار',
            'اضافة دور',
            'حذف دور',
            'تعديل دور',
            'المستخدمين',
            'اضافة مستخدم',
            'حذف مستخدم',
            'تعديل مستخدم',
            'من نحن',
            'تعديل من نحن',
            'سياسة الخصوصية',
            'تعديل سياسة',
            'الصلاحيات',
            'اضافة صلاحية',
            'حذف صلاحية',
            'تعديل صلاحية',
            'المحادثات',
            'الرسائل',
            'الدول',
            'حذف دولة',
            'الفعاليات',
            'إضافة فعالية',
            'تعديل فعالية',
            'حذف فعالية',
            'الامتحانات',
            'إضافة امتحان',
            'تعديل امتحان',
            'حذف امتحان',
            'المواد',
            'إضافة مادة',
            'تعديل مادة',
            'حذف مادة',
            'الأسئلة',
            'إضافة سؤال',
            'تعديل سؤال',
            'حذف سؤال',
            'الأجوبة',
            'إضافة إجابة',
            'تعديل إجابة',
            'حذف إجابة',
            'الطلاب',
            'إضافة طالب',
            'تعديل طالب',
            'حذف طالب',
        ];

        // إضافة الصلاحيات إذا لم تكن موجودة
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // العثور على دور "admin" أو إنشائه إذا لم يكن موجودًا
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // إعطاء جميع الصلاحيات لدور "admin"
        $adminRole->syncPermissions(Permission::all());
    }
}
