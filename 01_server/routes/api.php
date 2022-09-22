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

Route::prefix('v1')->group(function() {
    Route::get('concerts', [\App\Http\Controllers\Api\ConcertController::class, 'index']);
    Route::get('concerts/{concertId}', [\App\Http\Controllers\Api\ConcertController::class, 'show']);
    Route::get('concerts/{concertId}/shows/{showId}/seating', [\App\Http\Controllers\Api\Concerts\Shows\SeatingController::class, 'show']);
    Route::post('concerts/{concertId}/shows/{showId}/reservation', [\App\Http\Controllers\Api\Concerts\Shows\ReservationController::class, 'store']);
    Route::post('concerts/{concertId}/shows/{showId}/booking', [\App\Http\Controllers\Api\Concerts\Shows\BookingController::class, 'store']);
    Route::post('tickets', [\App\Http\Controllers\Api\TicketController::class, 'show']);
});
