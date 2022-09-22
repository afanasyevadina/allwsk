<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('events', [\App\Http\Controllers\Api\EventController::class, 'index']);
    Route::get('organizers/{organizersSlug}/events/{eventSlug}', [\App\Http\Controllers\Api\Organizer\EventController::class, 'show']);

    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::post('organizers/{organizersSlug}/events/{eventSlug}/registration', [\App\Http\Controllers\Api\Organizer\Event\RegistrationController::class, 'store']);
    Route::get('registrations', [\App\Http\Controllers\Api\RegistrationController::class, 'index']);
});
