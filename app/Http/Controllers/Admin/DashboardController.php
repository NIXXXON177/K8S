<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MediaFile;
use App\Models\Screen;
use App\Models\ScreenBooking;
use App\Models\Tenant;
use App\Models\ZoneBooking;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'events' => Event::count(),
            'active_events' => Event::where('status_id', 3)->count(),
            'screens' => Screen::where('is_active', true)->count(),
            'tenants' => Tenant::count(),
            'pending_media' => MediaFile::where('status_id', 1)->count(),
            'screen_bookings' => ScreenBooking::count(),
            'zone_bookings' => ZoneBooking::count(),
            'pending_bookings' => ScreenBooking::where('status', 'pending')->count(),
        ];

        $recentMedia = MediaFile::with('tenant', 'status')
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = ScreenBooking::with('screen', 'tenant', 'media')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMedia', 'recentBookings'));
    }
}
