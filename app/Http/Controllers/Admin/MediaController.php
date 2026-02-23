<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\MediaStatus;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $statuses = MediaStatus::all();
        $query = MediaFile::with('tenant', 'status', 'reviewer');

        if ($request->filled('status')) {
            $query->where('status_id', $request->status);
        }

        $media = $query->latest()->paginate(10);

        return view('admin.media.index', compact('media', 'statuses'));
    }

    public function show(MediaFile $mediaFile)
    {
        $mediaFile->load('tenant', 'status', 'reviewer', 'screenBookings.screen');

        return view('admin.media.show', compact('mediaFile'));
    }

    public function approve(MediaFile $mediaFile)
    {
        $approvedStatus = MediaStatus::where('name', 'Одобрено')->first();

        $mediaFile->update([
            'status_id' => $approvedStatus->id,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Медиафайл одобрен.');
    }

    public function reject(Request $request, MediaFile $mediaFile)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $rejectedStatus = MediaStatus::where('name', 'Отклонено')->first();

        $mediaFile->update([
            'status_id' => $rejectedStatus->id,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Медиафайл отклонён.');
    }
}
