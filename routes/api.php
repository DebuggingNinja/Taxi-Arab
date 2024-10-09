<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Include user routes
include __DIR__ . '/user_api_routes.php';

// Include driver routes
include __DIR__ . '/driver_api_routes.php';

// Include public routes
include __DIR__ . '/public_api_routes.php';
