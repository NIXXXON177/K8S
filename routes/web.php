<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Organization\DashboardController as OrgDashboardController;
use App\Http\Controllers\Organization\AdRequestController as OrgAdRequestController;
use App\Http\Controllers\Organization\EventRequestController as OrgEventRequestController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ScreenBookingController;
use App\Http\Controllers\Admin\ScreenController as AdminScreenController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\ZoneBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('organization')->middleware(['auth', 'organization'])->name('organization.')->group(function () {
    Route::get('/', OrgDashboardController::class)->name('dashboard');

    Route::get('ad-requests', [OrgAdRequestController::class, 'index'])->name('ad-requests.index');
    Route::get('ad-requests/create', [OrgAdRequestController::class, 'create'])->name('ad-requests.create');
    Route::post('ad-requests', [OrgAdRequestController::class, 'store'])->name('ad-requests.store');
    Route::get('ad-requests/{screenBooking}', [OrgAdRequestController::class, 'show'])->name('ad-requests.show');

    Route::get('event-requests', [OrgEventRequestController::class, 'index'])->name('event-requests.index');
    Route::get('event-requests/create', [OrgEventRequestController::class, 'create'])->name('event-requests.create');
    Route::post('event-requests', [OrgEventRequestController::class, 'store'])->name('event-requests.store');
    Route::get('event-requests/{zoneBooking}', [OrgEventRequestController::class, 'show'])->name('event-requests.show');
});

Route::get('/admin', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

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
