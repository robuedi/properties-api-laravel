<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\UserPropertiesController;
use App\Http\Controllers\Api\v1\CountriesController;
use App\Http\Controllers\Api\v1\CitiesController;
use App\Http\Controllers\Api\v1\ListingTypesController;
use App\Http\Controllers\Api\v1\PropertyTypesController;

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

Route::prefix('v1')->group(function(){

    //authentication
    Route::prefix('auth')->group(function(){
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function(){
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('user', [AuthController::class, 'getUser']);
            Route::get('refresh-token', [AuthController::class, 'refreshToken']);
        });
    });
    
    Route::middleware('auth:sanctum')->group(function(){
        Route::apiResource('user/{user}/properties', UserPropertiesController::class);
    });

    Route::get('countries', [CountriesController::class, 'index']);
    Route::get('cities', [CitiesController::class, 'index']);
    Route::get('listing-types', [ListingTypesController::class, 'index']);
    Route::get('property-types', [PropertyTypesController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
