<?php

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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [\App\Http\Controllers\AuthController::class, 'showForm'])->name('index');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events');
    Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [\App\Http\Controllers\EventController::class, 'store'])->name('events.create');
    Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'detail'])->name('events.detail');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
    Route::post('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'update'])->name('events.edit');

    Route::get('/events/{event}/tickets/create', [\App\Http\Controllers\Event\TicketController::class, 'create'])->name('tickets.create');
    Route::post('/events/{event}/tickets/create', [\App\Http\Controllers\Event\TicketController::class, 'store'])->name('tickets.create');

    Route::get('/events/{event}/sessions/create', [\App\Http\Controllers\Event\SessionController::class, 'create'])->name('sessions.create');
    Route::post('/events/{event}/sessions/create', [\App\Http\Controllers\Event\SessionController::class, 'store'])->name('sessions.create');
    Route::get('/events/{event}/sessions/{session}/edit', [\App\Http\Controllers\Event\SessionController::class, 'edit'])->name('sessions.edit');
    Route::post('/events/{event}/sessions/{session}/edit', [\App\Http\Controllers\Event\SessionController::class, 'update'])->name('sessions.edit');

    Route::get('/events/{event}/channels/create', [\App\Http\Controllers\Event\ChannelController::class, 'create'])->name('channels.create');
    Route::post('/events/{event}/channels/create', [\App\Http\Controllers\Event\ChannelController::class, 'store'])->name('channels.create');

    Route::get('/events/{event}/rooms/create', [\App\Http\Controllers\Event\RoomController::class, 'create'])->name('rooms.create');
    Route::post('/events/{event}/rooms/create', [\App\Http\Controllers\Event\RoomController::class, 'store'])->name('rooms.create');

    Route::get('/events/{event}/report', [\App\Http\Controllers\Event\ReportController::class, 'index'])->name('events.report');
});
