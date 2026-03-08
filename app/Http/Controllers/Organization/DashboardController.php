<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $screenBookings = $tenant->screenBookings()->with('screen', 'media')->latest()->get();
        $zoneBookings = $tenant->zoneBookings()->with('zone', 'event')->latest()->get();

        $adStats = [
            'total' => $screenBookings->count(),
            'pending' => $screenBookings->where('status', 'pending')->count(),
            'confirmed' => $screenBookings->where('status', 'confirmed')->count(),
            'cancelled' => $screenBookings->where('status', 'cancelled')->count(),
        ];

        $eventStats = [
            'total' => $zoneBookings->count(),
            'pending' => $zoneBookings->where('status', 'pending')->count(),
            'confirmed' => $zoneBookings->where('status', 'confirmed')->count(),
            'cancelled' => $zoneBookings->where('status', 'cancelled')->count(),
        ];

        $recentAdRequests = $screenBookings->take(5);
        $recentEventRequests = $zoneBookings->take(5);

        return view('organization.dashboard', compact(
            'tenant', 'adStats', 'eventStats', 'recentAdRequests', 'recentEventRequests'
        ));
    }
}
