<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'file_name',
        'file_path',
        'original_name',
        'duration_sec',
        'width_px',
        'height_px',
        'file_size_mb',
        'codec',
        'fps',
        'status_id',
        'reviewed_by',
        'rejection_reason',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'duration_sec' => 'integer',
            'width_px' => 'integer',
            'height_px' => 'integer',
            'file_size_mb' => 'integer',
            'fps' => 'integer',
            'reviewed_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(MediaStatus::class, 'status_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function screenBookings(): HasMany
    {
        return $this->hasMany(ScreenBooking::class, 'media_id');
    }

    public function matchesScreen(Screen $screen): bool
    {
        return $this->width_px === $screen->width_px
            && $this->height_px === $screen->height_px;
    }
}
