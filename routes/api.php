<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Test the API
Route::post('/test', function () {
    return response()->json([
        'message' => 'API is working good'
    ]);
});  // working good


/**
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
 */
Route::post('/register', [AuthController::class, 'register']); // working good

Route::post('/login', [AuthController::class, 'login']); // working good

// ALl the routes below are required to be authenticated
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    }); // working good

    Route::post('/logout', [AuthController::class, 'logout']); // working good

    Route::post('/user/change-status', [UserController::class, 'changeStatus']); // working good
});

/**
|--------------------------------------------------------------------------
| Driver Routes
|--------------------------------------------------------------------------
 */
Route::get('/drivers', [DriverController::class, 'allDrivers']); // working good

Route::get('/available-drivers-count', [DriverController::class, 'availableDriversCount']); // working good
Route::get('/available-drivers-filter', [DriverController::class, 'availableDriversFilter']); // working good

Route::get('/busy-drivers-count', [DriverController::class, 'busyDriversCount']); // working good
Route::get('/busy-drivers-filter', [DriverController::class, 'busyDriversFilter']); // working good

Route::get('/offline-drivers-count', [DriverController::class, 'offlineDriversCount']); // working good
Route::get('/offline-drivers-filter', [DriverController::class, 'offlineDriversFilter']); // working good

Route::get('driver/{id}', [DriverController::class, 'getDriver']); // working good

Route::get('/map-drivers', [DriverController::class, 'MapDrivers']); // working good

/**
 |--------------------------------------------------------------------------
 | Location Routes
 |--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/location', [UserController::class, 'updateLocation']); // working good
});


/**
|--------------------------------------------------------------------------
| .......... Routes
|--------------------------------------------------------------------------
 */
