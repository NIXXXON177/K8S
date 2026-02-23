<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScreenBooking;
use Illuminate\Http\Request;

class ScreenBookingController extends Controller
{
    public function index()
    {
        $bookings = ScreenBooking::with('screen', 'media', 'tenant')
            ->latest()
            ->paginate(10);

        return view('admin.screen-bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, ScreenBooking $screenBooking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $screenBooking->update(['status' => $request->status]);

        $statusLabels = ['pending' => 'ожидание', 'confirmed' => 'подтверждено', 'cancelled' => 'отменено'];

        return redirect()->back()->with('success', "Статус бронирования изменён на \"{$statusLabels[$request->status]}\".");
    }
}
