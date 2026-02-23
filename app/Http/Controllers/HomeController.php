<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Screen;

class HomeController extends Controller
{
    public function __invoke()
    {
        $events = Event::with('status', 'organizer')
            ->whereIn('status_id', [1, 2, 3])
            ->orderBy('start_date')
            ->take(4)
            ->get();

        $screens = Screen::where('is_active', true)
            ->take(6)
            ->get();

        return view('home', compact('events', 'screens'));
    }
}
