<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        $screens = Screen::orderBy('name')->paginate(15);

        return view('admin.screens.index', compact('screens'));
    }

    public function edit(Screen $screen)
    {
        return view('admin.screens.edit', compact('screen'));
    }

    public function update(Request $request, Screen $screen)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'width_px' => 'required|integer|min:1',
            'height_px' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'has_night_version' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['has_night_version'] = $request->boolean('has_night_version');
        $validated['is_active'] = $request->boolean('is_active');

        $screen->update($validated);

        return redirect()->route('admin.screens.index')->with('success', 'Экран обновлён.');
    }
}
