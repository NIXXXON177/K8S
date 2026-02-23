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
}
