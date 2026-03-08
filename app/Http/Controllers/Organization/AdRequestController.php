<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\MediaStatus;
use App\Models\Screen;
use App\Models\ScreenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdRequestController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;
        $bookings = $tenant->screenBookings()
            ->with('screen', 'media.status')
            ->latest()
            ->paginate(10);

        return view('organization.ad-requests.index', compact('bookings'));
    }

    public function create()
    {
        $screens = Screen::where('is_active', true)->orderBy('name')->get();

        return view('organization.ad-requests.create', compact('screens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'screen_id' => 'required|exists:screens,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:1000',
            'video_checked' => 'required|in:1',
            'video_file_name' => 'nullable|string|max:255',
            'video_duration' => 'nullable|integer',
            'video_width' => 'nullable|integer',
            'video_height' => 'nullable|integer',
            'video_size' => 'nullable|numeric',
            'video_codec' => 'nullable|string|max:50',
            'video_fps' => 'nullable|integer',
        ], [
            'video_checked.required' => 'Видео должно пройти проверку перед отправкой заявки.',
        ]);

        $tenant = auth()->user()->tenant;
        $screen = Screen::findOrFail($request->screen_id);

        $fileName = $request->video_file_name ?: 'video.mp4';
        $width = $request->video_width ?: $screen->width_px;
        $height = $request->video_height ?: $screen->height_px;

        DB::transaction(function () use ($request, $tenant, $fileName, $width, $height) {
            $pendingStatus = MediaStatus::where('name', 'На модерации')->first();

            $media = MediaFile::create([
                'tenant_id' => $tenant->id,
                'file_name' => $fileName,
                'file_path' => 'media/pending/' . $fileName,
                'original_name' => $fileName,
                'duration_sec' => $request->video_duration ?: 15,
                'width_px' => $width,
                'height_px' => $height,
                'file_size_mb' => $request->video_size ?: 0,
                'codec' => $request->video_codec ?: 'H264',
                'fps' => $request->video_fps ?: 25,
                'status_id' => $pendingStatus->id,
            ]);

            ScreenBooking::create([
                'screen_id' => $request->screen_id,
                'media_id' => $media->id,
                'tenant_id' => $tenant->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('organization.ad-requests.index')
            ->with('success', 'Видео прошло проверку. Заявка отправлена администратору на рассмотрение!');
    }

    public function show(ScreenBooking $screenBooking)
    {
        $tenant = auth()->user()->tenant;
        abort_if($screenBooking->tenant_id !== $tenant->id, 403);

        $screenBooking->load('screen', 'media.status');

        return view('organization.ad-requests.show', compact('screenBooking'));
    }
}
