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

        $screenBooking->update($data);

        $statusLabels = ['pending' => 'ожидание', 'confirmed' => 'подтверждено', 'cancelled' => 'отклонено'];

        return redirect()->back()->with('success', "Статус бронирования изменён на \"{$statusLabels[$request->status]}\".");
    }
}
