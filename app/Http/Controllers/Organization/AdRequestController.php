<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\MediaStatus;
use App\Models\Screen;
use App\Models\ScreenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdRequestController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tenant = $user->tenant;
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

    public function screenBookings(Screen $screen)
    {
        $bookings = ScreenBooking::where('screen_id', $screen->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->select('start_date', 'end_date', 'status')
            ->orderBy('start_date')
            ->get()
            ->map(fn($b) => [
                'start' => $b->start_date->format('Y-m-d'),
                'end' => $b->end_date->format('Y-m-d'),
                'status' => $b->status === 'confirmed' ? 'Подтверждено' : 'Ожидает',
            ]);

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tenant = $user->tenant;

        $hasNewFile = $request->hasFile('video_file');

        $hasSavedFile = $request->session()->has('pending_video_path');

        if ($hasNewFile) {
            $request->validate([
                'video_file' => 'file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm,video/x-matroska|max:512000',
            ], [
                'video_file.mimetypes' => 'Неподдерживаемый формат видео.',
                'video_file.max' => 'Максимальный размер видео — 500 МБ.',
            ]);

            $uploadedFile = $request->file('video_file');
            $originalName = $uploadedFile->getClientOriginalName();
            $tempPath = $uploadedFile->store('media/temp/' . $tenant->id, 'public');

            $request->session()->put('pending_video_path', $tempPath);
            $request->session()->put('pending_video_name', $originalName);
        }

        if (!$hasNewFile && !$hasSavedFile) {
            return back()->withErrors(['video_file' => 'Загрузите видеофайл.'])->withInput();
        }

        $request->validate([
            'screen_id' => 'required|exists:screens,id',
            'start_date' => 'required|date|after_or_equal:today',
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
            'screen_id.required' => 'Выберите экран для размещения.',
            'screen_id.exists' => 'Выбранный экран не найден.',
            'start_date.required' => 'Укажите дату начала.',
            'start_date.after_or_equal' => 'Дата начала должна быть не ранее сегодняшнего дня.',
            'end_date.required' => 'Укажите дату окончания.',
            'end_date.after' => 'Дата окончания должна быть позже даты начала.',
            'video_checked.required' => 'Видео должно пройти проверку перед отправкой заявки.',
        ]);

        $overlap = ScreenBooking::where('screen_id', $request->screen_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->exists();

        if ($overlap) {
            return back()->withErrors([
                'screen_id' => 'Этот экран уже занят в выбранный период. Выберите другие даты или другой экран.',
            ])->withInput();
        }

        $screen = Screen::findOrFail($request->screen_id);

        $tempPath = $request->session()->get('pending_video_path');
        $originalName = $request->session()->get('pending_video_name', 'video.mp4');
        $finalPath = 'media/videos/' . $tenant->id . '/' . basename($tempPath);
        Storage::disk('public')->move($tempPath, $finalPath);

        $request->session()->forget(['pending_video_path', 'pending_video_name']);

        $width = $request->video_width ?: $screen->width_px;
        $height = $request->video_height ?: $screen->height_px;

        DB::transaction(function () use ($request, $tenant, $originalName, $finalPath, $width, $height) {
            $pendingStatus = MediaStatus::where('name', 'На модерации')->first();

            $media = MediaFile::create([
                'tenant_id' => $tenant->id,
                'file_name' => $originalName,
                'file_path' => $finalPath,
                'original_name' => $originalName,
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tenant = $user->tenant;
        abort_if($screenBooking->tenant_id !== $tenant->id, 403);

        $screenBooking->load('screen', 'media.status');

        return view('organization.ad-requests.show', compact('screenBooking'));
    }
}
