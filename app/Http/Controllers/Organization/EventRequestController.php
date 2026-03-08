<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventStatus;
use App\Models\Zone;
use App\Models\ZoneBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRequestController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;
        $bookings = $tenant->zoneBookings()
            ->with('zone', 'event.status')
            ->latest()
            ->paginate(10);

        return view('organization.event-requests.index', compact('bookings'));
    }

    public function create()
    {
        $zones = Zone::where('is_active', true)->orderBy('name')->get();

        return view('organization.event-requests.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'zone_id' => 'required|exists:zones,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'expected_visitors' => 'nullable|integer|min:1',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $tenant = auth()->user()->tenant;
        $user = auth()->user();

        DB::transaction(function () use ($request, $tenant, $user) {
            $pendingStatus = EventStatus::where('name', 'Планируется')->first();
            $zone = Zone::find($request->zone_id);

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'status_id' => $pendingStatus->id,
                'organizer_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'location' => $zone?->name,
                'expected_visitors' => $request->expected_visitors,
                'budget' => $request->budget,
            ]);

            $days = max(1, now()->parse($request->start_date)->diffInDays(now()->parse($request->end_date)));

            ZoneBooking::create([
                'zone_id' => $request->zone_id,
                'tenant_id' => $tenant->id,
                'event_id' => $event->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_price' => $zone?->price_per_day ? $zone->price_per_day * $days : null,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('organization.event-requests.index')
            ->with('success', 'Заявка на проведение мероприятия успешно отправлена!');
    }

    public function show(ZoneBooking $zoneBooking)
    {
        $tenant = auth()->user()->tenant;
        abort_if($zoneBooking->tenant_id !== $tenant->id, 403);

        $zoneBooking->load('zone', 'event.status');

        return view('organization.event-requests.show', compact('zoneBooking'));
    }
}
