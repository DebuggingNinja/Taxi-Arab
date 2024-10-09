<?php

namespace App\Http\Controllers\Dashboard\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\CreateAdminRequest;
use App\Http\Requests\Dashboard\Admin\UpdateAdminRequest;
use App\Http\Requests\Dashboard\User\CreateUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function index(request $request)
    {
        user_can('List.Role');
        $records = Admin::with(['roles'])->Filters($request)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.admins.index', compact('records'));
    }
    public function create()
    {
        user_can('Create.Role');
        return view('dashboard.admins.create');
    }
    public function store(CreateAdminRequest $request)
    {
        user_can('Create.Role');
        Admin::create($request->validated());
        return redirect()->route('dashboard.admins.index')->with('Success', 'تم انشاء ادمن بنجاح');
    }
    public function edit(Request $request)
    {
        user_can('Update.Role');
        $record = Admin::findOrFail($request->route('admin'));
        return view('dashboard.admins.edit', compact('record'));
    }
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        user_can('Update.Role');
        $admin->update($request->validated());
        return redirect()->back()->with('Success', 'تم تعديل الادمن بنجاح');
    }
    public function show(Admin $admin)
    {
        user_can('List.Role');
        $record = $admin;
        return view('dashboard.admins.show', compact('record'));
    }
    public function destroy(Admin $admin)
    {
        user_can('Delete.Role');

        $admin->delete();
        return redirect()->back()->with('Success', 'تم حذف الادمن بنجاح');
    }

    public function listRoles(request $request)
    {
        user_can('List.Role');
        $role_id = Admin::findOrFail($request->route('admin'))->roles()->first()?->name;
        $roles = Role::all();
        return view('dashboard.admins.role', compact('roles', 'role_id'));
    }
    public function setRole(request $request)
    {
        user_can('Update.Role');
        $role_id = Admin::findOrFail($request->route('admin'))->syncRoles([$request->role_id]);
        return redirect()->route('dashboard.admins.index')->with('Success', 'تم تغيير دور الادمن بنجاح');
    }
}
