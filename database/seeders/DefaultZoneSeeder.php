<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yourPolygonData = [
            'name' => 'Default',
            'active' => 1,
            'polygon' => [
                [42.4363280313443, -71.59881101586915],
                [42.421630170320164, -71.61958204248047],
                [42.421630170320164, -71.59451948144532]
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Zone::create($yourPolygonData);
    }
}
