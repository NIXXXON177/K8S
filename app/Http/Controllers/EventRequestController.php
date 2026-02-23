<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventStatus;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Zone;
use App\Models\ZoneBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventRequestController extends Controller
{
    public function create()
    {
        $zones = Zone::where('is_active', true)->orderBy('name')->get();

        return view('event-request', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'inn' => 'nullable|string|max:12',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'zone_id' => 'required|exists:zones,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'expected_visitors' => 'nullable|integer|min:1',
            'budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request) {
            $tenantRole = Role::where('name', 'tenant')->first();

            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'role_id' => $tenantRole->id,
                    'name' => $request->contact_person,
                    'password' => Hash::make('temp_' . uniqid()),
                    'phone' => $request->phone,
                ]
            );

            $tenant = Tenant::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $request->company_name,
                    'contact_person' => $request->contact_person,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'inn' => $request->inn,
                ]
            );

            $pendingStatus = EventStatus::where('name', 'Планируется')->first();

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'status_id' => $pendingStatus->id,
                'organizer_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'location' => Zone::find($request->zone_id)?->name,
                'expected_visitors' => $request->expected_visitors,
                'budget' => $request->budget,
            ]);

            $zone = Zone::find($request->zone_id);
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

        return redirect()->route('event-request.create')
            ->with('success', 'Ваша заявка на проведение мероприятия успешно отправлена! Администратор рассмотрит её в ближайшее время.');
    }
}
