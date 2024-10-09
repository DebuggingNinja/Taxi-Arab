<?php

use App\Http\Controllers\API\User\Address\AddressController;
use App\Http\Controllers\API\User\Auth\AuthController;
use App\Http\Controllers\API\User\Cards\DiscountCardController;
use App\Http\Controllers\API\User\Profile\ProfileController;
use App\Http\Controllers\API\User\Ride\RideController;
use App\Http\Controllers\Dashboard\Complaints\ComplaintsController;
use App\Http\Controllers\Sockets\AuthController as SocketsAuthController;
use Faker\Provider\ar_EG\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain('api.' . env('APP_DOMAIN'))->middleware('api.language')->group(function () {



    Route::prefix('users')->group(function () {

        /**
         * Guest Users (Unauthorized)
         */
        Route::middleware('guest:user')->group(function () {
            /**
             * Auth
             */
            Route::post('register', [AuthController::class, 'checkPhoneName']);
            Route::post('register/send-otp', [AuthController::class, 'register']);
            Route::post('register/verify-otp', [AuthController::class, 'verifyUserOtpRegister']);

            Route::post('auth', [AuthController::class, 'otpAuthenticate']);
            Route::post('auth/verify-otp', [AuthController::class, 'verifyUserOtpAuth']);
        });

        /**
         * Authenticated Users
         */
        Route::middleware('auth:user', 'user.isActive', 'user.isNotBlocked')->group(function () {

            Route::prefix('discount-cards')->group(function () {
                Route::get('charging-history', [DiscountCardController::class, 'index']);
                Route::post('activate', [DiscountCardController::class, 'activate']);
                Route::post('validate', [DiscountCardController::class, 'validateCard']);
                Route::get('available', [DiscountCardController::class, 'available']);
            });

            // In Active Ride Routes
            Route::middleware('user.inActiveRide')->group(function () {
                Route::prefix('ride')->group(function () {
                    Route::post('invites/send', [RideController::class, 'searchForDriver']);
                    Route::get('current', [RideController::class, 'showCurrentRideInformation']);
                    Route::post('cancel', [RideController::class, 'cancel']);
                });
            });

            // Not In Active Ride Routes
            Route::middleware('user.notInActiveRide')->group(function () {
                Route::prefix('ride')->group(function () {
                    Route::post('upfront-fare', [RideController::class, 'rideUpfrontFares']);
                    Route::post('create', [RideController::class, 'create']);
                });
            });

            Route::post('update/profile-image', [ProfileController::class, 'updateProfileImage']);
            Route::post('update/device-token', [ProfileController::class, 'updateDeviceToken']);

            // Independednt Routes
            Route::get('profile', [ProfileController::class, 'profile']);
            Route::delete('profile/delete', [ProfileController::class, 'deleteProfile']);
            Route::post('complaint/send', [ComplaintsController::class, 'create']);
            Route::get('profile/rides', [ProfileController::class, 'ridesHistory']);
            Route::get('profile/notifications/history', [ProfileController::class, 'notificationsHistory']);

            Route::prefix('ride')->group(function () {
                Route::get('{ride}/view', [RideController::class, 'show']);
                Route::post('{ride}/rate', [RideController::class, 'rateRide']);
            });
            Route::prefix('address')->group(function () {
                Route::get('/', [AddressController::class, 'index']);
                Route::post('/create', [AddressController::class, 'store']);
                Route::delete('/{id}', [AddressController::class, 'destroy']);
            });
            Route::post('broadcast/auth', [SocketsAuthController::class, 'presence_auth']);
        });
    });
});
