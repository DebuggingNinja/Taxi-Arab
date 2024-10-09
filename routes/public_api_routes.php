<?php

use App\Http\Controllers\API\CarType\CarTypeController;
use App\Http\Controllers\API\Zone\ZoneController;
use App\Http\Controllers\Dashboard\Settings\SettingsController;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Profile\ProfileController;
use App\Services\ZoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain('api.' . env('APP_DOMAIN'))->middleware('api.language')->group(function () {

    Route::get('/terms-and-conditions', function (){
        return successResponse([
            'url' => str_replace('api.', '', route('terms.conditions'))
        ]);
    });

    Route::get('car-types', [CarTypeController::class, 'index']);
    Route::get('customer-service', [SettingsController::class, 'getContactInfo']);
    Route::get('car-types/{carType}', [CarTypeController::class, 'show']);

    Route::post('car-types', [CarTypeController::class, 'store']);

    Route::get('zone/check', [ZoneController::class, 'AvailableLocation']);

    Route::get('test', function () {
    });

    Route::get('configuration/ringtone/user', [SettingsController::class, 'userRingtone'])->name('dashboard.configuration.ringtone.user');
    Route::get('configuration/ringtone/driver', [SettingsController::class, 'driverRingtone'])->name('dashboard.configuration.ringtone.driver');
});
