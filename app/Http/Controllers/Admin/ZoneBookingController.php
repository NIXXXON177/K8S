<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoneBooking;
use Illuminate\Http\Request;

class ZoneBookingController extends Controller
{
    public function index()
    {
        $bookings = ZoneBooking::with('zone', 'tenant', 'event')
            ->latest()
            ->paginate(10);

        return view('admin.zone-bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, ZoneBooking $zoneBooking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $zoneBooking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Статус бронирования зоны обновлён.');
    }
}
