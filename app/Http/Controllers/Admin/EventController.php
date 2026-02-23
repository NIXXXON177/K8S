<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventStatus;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('status', 'organizer')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $statuses = EventStatus::all();
        return view('admin.events.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:event_statuses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'expected_visitors' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $validated['organizer_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Мероприятие создано.');
    }

    public function edit(Event $event)
    {
        $statuses = EventStatus::all();
        return view('admin.events.edit', compact('event', 'statuses'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:event_statuses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'expected_visitors' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Мероприятие обновлено.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Мероприятие удалено.');
    }
}
