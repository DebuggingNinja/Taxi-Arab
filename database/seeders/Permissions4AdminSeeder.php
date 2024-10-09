<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Permissions4AdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsData[] = ['name' => 'Balance.Charge', 'guard_name' => 'web'];
        $permissionsData[] = ['name' => 'Balance.Review', 'guard_name' => 'web'];
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
