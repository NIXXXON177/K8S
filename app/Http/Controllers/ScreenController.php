<?php

namespace App\Http\Controllers;

use App\Models\Screen;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('screens.index', compact('screens'));
    }

    public function map()
    {
        $screens = Screen::where('is_active', true)
            ->orderBy('floor')
            ->orderBy('zone_name')
            ->orderBy('name')
            ->get();

        $floors = $screens->groupBy('floor')->sortKeys();

        return view('screens.map', compact('screens', 'floors'));
    }
}
