<?php

use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
Route::prefix('/events')->middleware('auth:api')->group( function() {
    Route::get('/', [EventController::class, 'index']);
    Route::get('active-events', [EventController::class, 'getActiveEvents']);
    Route::get('{id}', [EventController::class, 'show']);
    Route::post('/', [EventController::class, 'store']);
    Route::put('{id?}', [EventController::class, 'update']);
    Route::patch('{id?}', [EventController::class, 'updateEvent']);
});
