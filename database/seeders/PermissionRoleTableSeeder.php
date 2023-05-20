<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);

        $administrator_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, -7) != '_delete';
        });
        Role::findOrFail(4)->permissions()->sync($administrator_permissions);

        $student_permission = $administrator_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 7) == 'course_' || substr($permission->title, 0, 5) == 'test_' || substr($permission->title, 0, 9) == 'question_';
        });
        Role::findOrFail(3)->permissions()->sync($student_permission);

    }
}
