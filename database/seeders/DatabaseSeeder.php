<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

//        $this->callSilent(DefaultZoneSeeder::class);
//        $this->callSilent(PermissionsTableSeeder::class);
        $this->callSilent(SettingsSeeder::class);
//
//        $user = Admin::create([
//            'name' => 'admin',
//            'email' => 'admin@admin.mail',
//            'password' => 'admin123'
//        ]);
//
//        $user->assignRole(Role::where('name', 'سوبر ادمن')->first());

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
