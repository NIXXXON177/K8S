<?php

namespace App\Http\Controllers;

use App\Models\MediaFile;
use App\Models\MediaStatus;
use App\Models\Screen;
use App\Models\ScreenBooking;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdRequestController extends Controller
{
    public function create()
    {
        $screens = Screen::where('is_active', true)->orderBy('name')->get();

        return view('ad-request', compact('screens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'inn' => 'nullable|string|max:12',
            'screen_id' => 'required|exists:screens,id',
            'file_name' => 'required|string|max:255',
            'duration_sec' => 'required|in:15,30',
            'width_px' => 'required|integer|min:1',
            'height_px' => 'required|integer|min:1',
            'file_size_mb' => 'required|integer|min:1|max:400',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
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

            $pendingStatus = MediaStatus::where('name', 'На модерации')->first();

            $media = MediaFile::create([
                'tenant_id' => $tenant->id,
                'file_name' => $request->file_name,
                'file_path' => 'media/pending/' . $request->file_name,
                'original_name' => $request->file_name,
                'duration_sec' => $request->duration_sec,
                'width_px' => $request->width_px,
                'height_px' => $request->height_px,
                'file_size_mb' => $request->file_size_mb,
                'codec' => 'H264',
                'fps' => 25,
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

        return redirect()->route('ad-request.create')
            ->with('success', 'Ваша заявка на размещение рекламы успешно отправлена! Администратор рассмотрит её в ближайшее время.');
    }
}
