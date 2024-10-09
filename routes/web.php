<?php

use App\Events\RideEvent;
use App\Http\Controllers\Dashboard\Admins\AdminsController;
use App\Http\Controllers\Dashboard\Auth\AuthenticationController;
use App\Http\Controllers\Dashboard\Cards\CardsController;
use App\Http\Controllers\Dashboard\CarType\CarTypeController;
use App\Http\Controllers\Dashboard\Complaints\ComplaintsController;
use App\Http\Controllers\Dashboard\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DiscountCards\DiscountCardsController;
use App\Http\Controllers\Dashboard\Drivers\DriversController;
use App\Http\Controllers\Dashboard\Notifications\NotificationsController;
use App\Http\Controllers\Dashboard\Rides\RidesController;
use App\Http\Controllers\Dashboard\Roles\RolesController;
use App\Http\Controllers\Dashboard\Settings\SettingsController;
use App\Http\Controllers\Dashboard\Users\UsersController;
use App\Http\Controllers\Dashboard\Zones\ZonesController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\WebSocketController;
use App\Services\FileUploadService;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/terms-and-conditions', [PublicController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('/contact-support', [PublicController::class, 'supportForm'])->name('support.messaging');
Route::post('/support-messaging', [PublicController::class, 'supportSubmit'])->name('support.submit');

Route::domain('admin.' . env('APP_DOMAIN'))->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard.login');
    });

    Route::get('/login', [AuthenticationController::class, 'dashboardLogin'])->name('dashboard.login');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('dashboard.login.submit');

    Route::prefix('')->middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'home'])->name('home');
        Route::get('/refresh', [DashboardController::class, 'refresh'])->name('home.refresh');

        Route::post('logout', [AuthenticationController::class, 'dashboardLogout'])->name('logout');

        Route::resource('drivers', DriversController::class, ['as' => 'dashboard']);
        Route::get('statuses/drivers', [DriversController::class, 'statuses'])->name('dashboard.drivers.statuses');
        Route::post('drivers/{driver}/acceptance/change', [DriversController::class, 'changeAcceptanceStatus'])->name('dashboard.drivers.acceptance');
        Route::post('drivers/{driver}/block', [DriversController::class, 'block'])->name('dashboard.drivers.block');
        Route::post('drivers/{driver}/unblock', [DriversController::class, 'unblock'])->name('dashboard.drivers.unblock');
        Route::post('drivers/{driver}/balance/charge', [DriversController::class, 'updateBalance'])->name('dashboard.drivers.chargeBalance');

        Route::prefix('drivers-statuses-api')->group(function (){
            Route::get('in-ride', [DriversController::class, 'inRide'])->name('dashboard.drivers.api.inRide');
            Route::get('looking-for-ride', [DriversController::class, 'lookingForRide'])->name('dashboard.drivers.api.lookingForRide');
            Route::get('offline', [DriversController::class, 'offline'])->name('dashboard.drivers.api.offline');
        });

        // manual charge
        Route::post('balance/agent/charge', [DriversController::class, 'updateBalanceForAgents'])->name('dashboard.drivers.chargeBalanceForAgents');
        Route::get('balance/charges', [DriversController::class, 'balanceCharges'])->name('dashboard.charges');
        Route::get('balance/charge', [DriversController::class, 'chargeBalance'])->name('dashboard.charge.create');

        //Route::post('drivers/{driver}/credit/add', [DriversController::class, 'addCredit']);
        Route::resource('users', UsersController::class, ['as' => 'dashboard']);
        Route::post('users/{user}/block', [UsersController::class, 'block'])->name('dashboard.users.block');
        Route::post('users/{user}/unblock', [UsersController::class, 'unblock'])->name('dashboard.users.unblock');
        Route::post('users/{user}/balance/charge', [UsersController::class, 'updateBalance'])->name('dashboard.users.chargeBalance');

        Route::resource('admins', AdminsController::class, ['as' => 'dashboard']);
        Route::get('admins/{admin}/role', [AdminsController::class, 'listRoles'])->name('dashboard.admins.role');
        Route::post('admins/{admin}/role/assign', [AdminsController::class, 'setRole'])->name('dashboard.admins.role.assign');


        Route::resource('rides', RidesController::class, ['as' => 'dashboard'])->only(['index', 'show']);
        Route::post('rides/cancel/{ride}', [RidesController::class, 'cancelRide'])->name('dashboard.rides.cancel');
        Route::resource('zones', ZonesController::class, ['as' => 'dashboard']);
        Route::resource('car-types', CarTypeController::class, ['as' => 'dashboard']);
        Route::post('car-types/{car_type}/enable', [CarTypeController::class, 'enable'])->name('dashboard.car-types.enable');
        Route::post('car-types/{car_type}/disable', [CarTypeController::class, 'disable'])->name('dashboard.car-types.disable');

        Route::resource('complaints', ComplaintsController::class, ['as' => 'dashboard']);
        Route::resource('roles', RolesController::class, ['as' => 'dashboard']);

        Route::resource('cards', CardsController::class, ['as' => 'dashboard'])->only('create', 'store', 'index');
        Route::resource('discount_cards', DiscountCardsController::class, ['as' => 'dashboard'])->only('create', 'store', 'index');
        Route::get('notifications/show', [NotificationsController::class, 'show'])->name('dashboard.notifications.send');
        Route::post('notifications/create', [NotificationsController::class, 'store'])->name('dashboard.notifications.store');

        Route::get('configuration', [SettingsController::class, 'showConfiguration'])->name('dashboard.configuration.show');
        Route::post('configuration', [SettingsController::class, 'update'])->name('dashboard.configuration.store');

        Route::get('map', [ZonesController::class, 'map'])->name('dashboard.map.show');
    });

});

Route::get('uploads/{prefix}/{file}', function ($prefix, $file){
    return FileUploadService::webLoad($prefix . "/" . $file);
});


Route::get('/', function () {
    return "<center><h1>Under Construction<h1><center>";
});
WebSocketsRouter::webSocket('/app/{appKey}', WebSocketController::class);


Route::get('test-pusher', function () {
    $ride = [
        'ride_id' => 0,
        'test' => 'pusher',
        'sender' => request()->query('sender', 'unknown')
    ];
    event(new \App\Events\TestPusherEvent($ride));
    return 'EVENT SENT TO PUSHER';
});