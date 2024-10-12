<?php

use App\Http\Controllers\AuthController;
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
});

/**
|--------------------------------------------------------------------------
| ... Routes
|--------------------------------------------------------------------------
 */


/**
|--------------------------------------------------------------------------
| ....... Routes
|--------------------------------------------------------------------------
 */


/**
|--------------------------------------------------------------------------
| .......... Routes
|--------------------------------------------------------------------------
 */
