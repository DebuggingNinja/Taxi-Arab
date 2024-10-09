<?php

namespace App\Http\Controllers\Dashboard\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role as MyRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Termwind\Components\Dd;

class RolesController extends Controller
{
    public function index(request $request)
    {
        user_can('List.Role');
        $records = MyRole::Search($request->search)->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.roles.index', compact('records'));
    }

    public function create()
    {
        user_can('Create.Role');
        return view('dashboard.roles.create');
    }

    public function store(Request $request)
    {
        user_can('Create.Role');
        // Validate the request data
        $request->validate([
            'role_name' => 'required|string|max:255|unique:roles,name', // Add more validation rules if needed
            // Add validation rules for other fields
        ]);

        // Create a new role with the provided data
        $newRole = Role::create([
            'name' => $request->input('role_name'),
            'guard' => 'web'
            // Add other fields as needed
        ]);

        // Attach permissions to the new role based on the checkbox inputs
        $permissions = [];
        foreach ($request->all() as $key => $value)
            if ($key !== '_token' && $key !== 'role_name')
                $permissions[] = str_replace('_', '.', $key);

        try {
            $newRole->syncPermissions($permissions);
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Redirect or return a response as needed
        return redirect()->route('dashboard.roles.index')->with('Success', 'تم انشاء الدور بنجاح');
    }
    public function show()
    {
        //code()
    }
    public function edit($id)
    {
        user_can('Update.Role');
        // Assuming $id is the ID of the role you want to retrieve
        $record = Role::findById($id);

        // Load the permissions relationship
        $record->load('permissions');

        return view('dashboard.roles.edit', compact('record'));
    }
    public function update(Request $request)
    {
        user_can('Update.Role');
        // Validate the request data
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($request->route('role')), // Exclude role with ID 1 from uniqueness check
                // Add more validation rules if needed
            ],
            // Add validation rules for other fields
        ]);
        $role = Role::findById($request->route('role'));
        // Create a new role with the provided data
        $role->update([
            'name' => $request->input('role_name'),

        ]);

        // Attach permissions to the new role based on the checkbox inputs
        $permissions = [];
        foreach ($request->all() as $key => $value)
            if ($key !== '_token' && $key !== '_method' && $key !== 'role_name')
                $permissions[] = str_replace('_', '.', $key);

        try {

            $role->syncPermissions($permissions);
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Redirect or return a response as needed
        return redirect()->back()->with('Success', 'تم تعديل الدور بنجاح');
    }
    public function destroy($id)
    {
        user_can('Delete.Role');
        Role::findById($id)->delete();
        return redirect()->back()->with('Success', 'تم حذف الدور بنجاح');
    }
}
