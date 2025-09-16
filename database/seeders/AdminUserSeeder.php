<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المستخدم
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',

        ]);

        // التأكد من وجود الدور "admin" أولاً أو إنشائه إذا لم يكن موجودًا
        $role = Role::firstOrCreate(['name' => 'admin']);

        // جلب جميع الصلاحيات
        $permissions = Permission::pluck('id', 'id')->all();

        // ربط الصلاحيات بالدور
        $role->syncPermissions($permissions);

        // إسناد الدور للمستخدم
        $user->assignRole([$role->id]);
    }
}
