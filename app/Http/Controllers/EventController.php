<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventStatus;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $statuses = EventStatus::all();
        $query = Event::with('status', 'organizer');

        if ($request->filled('status')) {
            $query->where('status_id', $request->status);
        }

        $events = $query->orderBy('start_date', 'desc')->paginate(9);

        return view('events.index', compact('events', 'statuses'));
    }

    public function show(Event $event)
    {
        $event->load('status', 'organizer', 'zoneBookings.zone');

        return view('events.show', compact('event'));
    }
}
