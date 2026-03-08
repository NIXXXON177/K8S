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
        $rules = [
            'status' => 'required|in:pending,confirmed,cancelled',
        ];

        if ($request->status === 'cancelled') {
            $rules['rejection_reason'] = 'required|string|max:1000';
        }

        $request->validate($rules);

        $data = ['status' => $request->status];

        if ($request->status === 'cancelled') {
            $data['rejection_reason'] = $request->rejection_reason;
        } else {
            $data['rejection_reason'] = null;
        }

        $zoneBooking->update($data);

        return redirect()->back()->with('success', 'Статус бронирования зоны обновлён.');
    }
}
