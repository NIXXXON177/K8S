<?php

use App\Http\Controllers\AdRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ScreenBookingController;
use App\Http\Controllers\Admin\ScreenController as AdminScreenController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\ZoneBookingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', HomeController::class)->name('home');
Route::get('/about', fn () => view('about'))->name('about');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/screens', [ScreenController::class, 'index'])->name('screens.index');
Route::get('/screens/map', [ScreenController::class, 'map'])->name('screens.map');

Route::get('/ad-request', [AdRequestController::class, 'create'])->name('ad-request.create');
Route::post('/ad-request', [AdRequestController::class, 'store'])->name('ad-request.store');

Route::get('/event-request', [EventRequestController::class, 'create'])->name('event-request.create');
Route::post('/event-request', [EventRequestController::class, 'store'])->name('event-request.store');

// Admin auth
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin panel
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('events', AdminEventController::class)->except('show');

    Route::get('screens', [AdminScreenController::class, 'index'])->name('screens.index');
    Route::get('screens/{screen}/edit', [AdminScreenController::class, 'edit'])->name('screens.edit');
    Route::put('screens/{screen}', [AdminScreenController::class, 'update'])->name('screens.update');

    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::get('media/{mediaFile}', [MediaController::class, 'show'])->name('media.show');
    Route::post('media/{mediaFile}/approve', [MediaController::class, 'approve'])->name('media.approve');
    Route::post('media/{mediaFile}/reject', [MediaController::class, 'reject'])->name('media.reject');

    Route::get('screen-bookings', [ScreenBookingController::class, 'index'])->name('screen-bookings.index');
    Route::post('screen-bookings/{screenBooking}/status', [ScreenBookingController::class, 'updateStatus'])->name('screen-bookings.update-status');

    Route::get('zone-bookings', [ZoneBookingController::class, 'index'])->name('zone-bookings.index');
    Route::post('zone-bookings/{zoneBooking}/status', [ZoneBookingController::class, 'updateStatus'])->name('zone-bookings.update-status');

    Route::get('tenants', [TenantController::class, 'index'])->name('tenants.index');
});
