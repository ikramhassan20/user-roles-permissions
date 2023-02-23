<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function Permission()
    {
        $admin_permission = Permission::where('slug', 'all')->first();
        $editor_permission = Permission::where('slug', 'create-tasks')->first();
        $viewer_permission = Permission::where('slug','view-tasks')->first();

        // Admin Role
        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Admin_Role';
        $admin_role->save();
        $admin_role->permissions()->attach($admin_permission);

        // Editor Role
        $editor_role = new Role();
        $editor_role->slug = 'editor';
        $editor_role->name = 'Editor_Role';
        $editor_role->save();
        $editor_role->permissions()->attach($editor_permission);

        // Viewer Role
        $viewer_role = new Role();
        $viewer_role->slug = 'viewer';
        $viewer_role->name = 'Viewer_Role';
        $viewer_role->save();
        $viewer_role->permissions()->attach($viewer_permission);


        $editor_role = Role::where('slug', 'editor')->first();
        $viewer_role = Role::where('slug','viewer')->first();

        $editUsers = new Permission();
        $editUsers->slug = 'create-task';
        $editUsers->name = 'Create Tasks';
        $editUsers->save();
        $editUsers->roles()->attach($editor_role);

        $viewTasks = new Permission();
        $viewTasks->slug = 'view-tasks';
        $viewTasks->name = 'View Tasks';
        $viewTasks->save();
        $viewTasks->roles()->attach($viewer_role);

        $admin_role = Role::where('slug', 'admin')->first();
        $editor_role = Role::where('slug', 'editor')->first();
        $view_role = Role::where('slug','viewer')->first();

        $admin_perm = Permission::where('slug','create-tasks')->first();
        $edit_perm = Permission::where('slug','create-tasks')->first();
        $view_perm = Permission::where('slug','view-tasks')->first();

        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('password');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($admin_perm);

        $editor = new User();
        $editor->name = 'Editor User';
        $editor->email = 'editor1@test.com';
        $editor->password = bcrypt('password');
        $editor->save();
        $editor->roles()->attach($editor_role);
        $editor->permissions()->attach($edit_perm);

        $user = new User();
        $user->name = 'Viewer User';
        $user->email = 'viewer1@test.com';
        $user->password = bcrypt('password');
        $user->save();
        $user->roles()->attach($view_role);
        $user->permissions()->attach($view_perm);

        return redirect()->route('dashboard');
    }
}
