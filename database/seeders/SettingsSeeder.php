<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [


            // Compansation
            [
                'key_name' => 'MINIMUM_SPEED_FOR_DELAY_CALCULATION',
                'value' => '1'
            ],

            [
                'key_name' => 'DRIVER_COMPANSATION_FOR_MORE_THAN_2KM',
                'value' => '1'
            ],

            [
                'key_name'  => 'DRIVER_SEARCH_RADIUS',
                'value'     => '5'
            ],

            [
                'key_name' => 'RUSH_HOUR_MULTIPLIER',
                'value' => '0.2'
            ], [
                'key_name' => 'CANCELLATION_FEES',
                'value' => '1'
            ], [
                'key_name' => 'REWARD_POINT_RATIO',
                'value' => '1'
            ], [
                'key_name' => 'REWARD_MIN',
                'value' => '1'
            ],
            [
                'key_name' => 'DRIVER_SEARCH_RETRY_INTERVAL_SECONDS',
                'value' => '20'
            ],
            [
                'key_name' => 'MINIMUM_CREDIT_TO_ACCEPT_RIDE',
                'value' => '0'
            ],
            [
                'key_name' => 'MAX_ADDRESSES_LIMIT',
                'value' => '10'
            ],

            [
                'key_name' => 'APP_TAX_PERCENTAGE',
                'value' => '0.10'
            ],
            [
                'key_name' => 'USER_INIT_BALANCE',
                'value' => '0'
            ],
            [
                'key_name' => 'DISCOUNT_FROM_BALANCE',
                'value' => '0'
            ],
            [
                'key_name' => 'DRIVER_INIT_BALANCE',
                'value' => '0'
            ],
            [
                'key_name' => 'INVITE_EXPIRY_TIMEOUT',
                'value' => '15'
            ],
            [
                'key_name' => 'DRIVERS_RINGTONE',
                'value' => ''
            ],
            [
                'key_name' => 'USERS_RINGTONE',
                'value' => '15'
            ],
            [
                'key_name' => 'AUTO_PICK_DRIVER',
                'value' => false
            ],
            [
                'key_name' => 'ACTIVATE_ASSET_DRIVER',
                'value' => false
            ],
            [
                'key_name' => 'ALLOW_PANEL_CHARGE',
                'value' => true
            ],
            [
                'key_name' => 'MAX_CHARGE_LIMIT',
                'value' => '100'
            ],
            [
                'key_name' => 'SUPPORT_EMAIL',
                'value' => 'customer_service@taxiarab.net'
            ],
            [
                'key_name' => 'SUPPORT_PHONE',
                'value' => ''
            ],
            [
                'key_name' => 'APP_TERMS',
                'value' => ''
            ],
        ];

        $keys = array_map(fn ($setting) => $setting['key_name'], $settings);

        $exists = Setting::whereIn('key_name', $keys)->get('key_name')->pluck('key_name')->toArray();

        DB::table('settings')->whereNotIn('key_name', $keys)->delete();

        $settings = array_filter($settings, fn($q) => !in_array($q['key_name'], $exists));

        // Transform the array directly for upsert
        $data = array_map(function ($setting) {
            return [
                'key_name' => $setting['key_name'],
                'value' => $setting['value'],
            ];
        }, $settings);

        // Perform upsert directly
        DB::table('settings')->upsert($data, ['key_name'], ['value']);
    }
}
