<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Management
        $permissions = [
            'List.User',
            'Show.User',
            'Update.User',
            'Delete.User',
            'Create.User',
            'Block.User',
            'Unblock.User',
            'Notify.User',
        ];

        // Role Management
        $permissions = array_merge($permissions, [
            'List.Role',
            'Update.Role',
            'Delete.Role',
            'Create.Role',
        ]);

        // Driver Management
        $permissions = array_merge($permissions, [
            'List.Driver',
            'Show.Driver',
            'Update.Driver',
            'Delete.Driver',
            'Create.Driver',
            'Block.Driver',
            'Unblock.Driver',
            'Notify.Driver',
            'Accept.Driver',
            'Reject.Driver',

        ]);

        // Trip Management
        $permissions = array_merge($permissions, [
            'List.Ride',
            'Show.Ride',
        ]);

        // Complaints Management
        $permissions = array_merge($permissions, [
            'List.Complaint',
            'Show.Complaint',
            'Approve.Complaint',
        ]);

        // Region Management
        $permissions = array_merge($permissions, [
            'List.Zone',
            'Delete.Zone',
            'Create.Zone',
        ]);

        // Car Type Management
        $permissions = array_merge($permissions, [
            'Enable.CarType',
            'Disable.CarType',
            'Show.CarType',
            'List.CarType',
            'Create.CarType',
            'Update.CarType',
        ]);
        // Settings Management
        $permissions = array_merge($permissions, [
            'Show.Setting',
            'Update.Setting',
        ]);

        // Card Management
        $permissions = array_merge($permissions, [
            'Create.Card',
            'List.Card',
        ]);

        // Card Management
        $permissions = array_merge($permissions, [
            'Create.DiscountCard',
            'List.DiscountCard',
        ]);

        // Notifications Management
        $permissions = array_merge($permissions, [
            'Send.Notification',
        ]);

        // Add more permissions for other modules as needed

        $permissionsData = [];
        foreach ($permissions as $permission) {
            $permissionsData[] = ['name' => $permission, 'guard_name' => 'web'];
        }

        Permission::insert($permissionsData);

        // Create a superadmin role

        $superadminRole = Role::where('name', 'سوبر ادمن')->first();

        if(!$superadminRole)
            $superadminRole = Role::create([
                'name' => 'سوبر ادمن',
                'guard_name' => 'web',
            ]);

        // Attach all permissions to the superadmin role
        $permissions = \Spatie\Permission\Models\Permission::all();
        $superadminRole->syncPermissions($permissions);
    }
}
