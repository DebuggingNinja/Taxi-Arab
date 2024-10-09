<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function showConfiguration()
    {
        user_can('Show.Setting');
        return view('dashboard.settings.configure');
    }
    public function update(UpdateSettingsRequest $request)
    {
        user_can('Update.Setting');
        foreach ($request->validated() as $key => $value) {
            if (in_array($key, ['DRIVERS_RINGTONE', 'USERS_RINGTONE', 'AUTO_PICK_DRIVER', 'APP_TAX_PERCENTAGE'])) continue;
            Setting::updateOrCreate(
                ['key_name' => $key],
                ['value' => $value]
            );
        }

        Setting::updateOrCreate(
            ['key_name' => 'AUTO_PICK_DRIVER'],
            ['value' => (bool) $request->AUTO_PICK_DRIVER]
        );

        if($request->APP_TAX_PERCENTAGE)
            Setting::updateOrCreate(
                ['key_name' => 'APP_TAX_PERCENTAGE'],
                ['value' =>  ($request->APP_TAX_PERCENTAGE / 100)]
            );

        if ($request->hasFile('DRIVERS_RINGTONE')) {
            $path = $request->file('DRIVERS_RINGTONE')->store('public/ringtones');
            $path = str_replace('public/', '', $path);
            Setting::updateOrCreate(['key_name' => 'DRIVERS_RINGTONE'], ['value' => $path]);
        }

        if ($request->hasFile('USERS_RINGTONE')) {
            $path = $request->file('USERS_RINGTONE')->store('public/ringtones');
            $path = str_replace('public/', '', $path);
            Setting::updateOrCreate(['key_name' => 'USERS_RINGTONE'], ['value' => $path]);
        }
        Cache::forget('settings');
        return redirect()->back()->with('Success', 'تم حفظ الاعدادات بنجاح');
    }

    public function getContactInfo(){
        return successResponse([
            'email' => getSetting('SUPPORT_EMAIL'),
            'phone' => getSetting('SUPPORT_PHONE')
        ]);
    }


    public function userRingtone()
    {
        $ringtonePath = getSetting('USERS_RINGTONE');

        if ($ringtonePath) {
            return successResponse(asset('storage/' . $ringtonePath));
        }

        return null;
    }
    public function driverRingtone()
    {
        $ringtonePath = getSetting('DRIVERS_RINGTONE');

        if ($ringtonePath) {
            return successResponse(asset('storage/' . $ringtonePath));
        }

        return null;
    }
}
