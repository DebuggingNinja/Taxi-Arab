<?php

use App\Http\Controllers\API\Driver\Auth\AuthController;
use App\Http\Controllers\API\Driver\Cards\CardController;
use App\Http\Controllers\API\Driver\DriverController;
use App\Http\Controllers\API\Driver\Ride\RideController;
use App\Http\Controllers\API\Driver\Profile\ProfileController;
use App\Http\Controllers\Dashboard\Complaints\ComplaintsController;
use App\Http\Controllers\Sockets\AuthController as SocketsAuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain('api.' . env('APP_DOMAIN'))->group(function () {

    Route::prefix('drivers')->middleware('api.language')->group(function () {

        Route::middleware('guest:driver')->group(function () {
            /**
             * Auth
             */
            Route::post('register', [AuthController::class, 'driverRegisteration']);

            Route::post('auth', [AuthController::class, 'otpAuthenticate']);
            Route::post('auth/verify-otp', [AuthController::class, 'verifyUserOtpAuth']);
        });
        /**
         * Authenticated Users
         */
        Route::middleware('auth:driver', 'driver.isActiveDriver', 'driver.isBlockedDriver')->group(function () {
            Route::get('profile', [ProfileController::class, 'show']);
            Route::delete('profile/delete', [ProfileController::class, 'deleteProfile']);
            Route::post('update/profile-image', [ProfileController::class, 'updateProfileImage']);
            Route::post('update/device-token', [ProfileController::class, 'updateDeviceToken']);
            Route::get('profile/rides', [ProfileController::class, 'ridesHistory']);
            Route::get('profile/notifications/history', [ProfileController::class, 'notificationsHistory']);
            Route::get('profile/balance', [ProfileController::class, 'balanceDetails']);

            // new Endpoints of driver
            Route::controller(DriverController::class)->group(function () {
                Route::post('location-update', 'locationUpdate');
                Route::post('ride-traking', 'rideTraking');
            });


            Route::get('info', [ProfileController::class, 'show']);
            Route::prefix('cards')->group(function () {
                Route::get('charging-history', [CardController::class, 'index']);
                Route::post('charge', [CardController::class, 'charge']);
            });

            Route::post('complaint/send', [ComplaintsController::class, 'create']);
            //Route::post('broadcast/auth', [SocketsAuthController::class, 'presence_auth']);
            Route::middleware('driver.FundsProtection')->group(function () {
                Route::middleware('driver.notInActiveRide')->group(function () {
                    Route::post('ride/available', [RideController::class, 'setActiveForRides']);
                    Route::post('ride/unavailable', [RideController::class, 'setNotActiveForRides']);
                    // All actions made by Not in active rides Drivers
                    Route::post('ride/{ride}/accept', [RideController::class, 'acceptRide']);
                    Route::post('ride/{ride}/decline', [RideController::class, 'declineRide']);
                });
                Route::middleware('driver.inActiveRide')->group(function () {
                    // All actions made by in active rides Drivers
                    Route::post('ride/at-pickup', [RideController::class, 'driverInPickup']);
                    Route::post('ride/start', [RideController::class, 'startRide']);
                    Route::post('ride/end', [RideController::class, 'endRide']);
                    Route::post('ride/cancel', [RideController::class, 'cancel']);
                    Route::get('ride/current', [RideController::class, 'showCurrentRideInformation']);
                });
                Route::post('ride/payment/confirm', [RideController::class, 'confirmPayment']);
                Route::post('ride/{ride}/rate', [RideController::class, 'rate']);
                Route::post('ride/{ride}/accept', [RideController::class, 'acceptRide']);
                Route::get('ride/{ride}/show', [RideController::class, 'show']);
            });
        });
    });
});
