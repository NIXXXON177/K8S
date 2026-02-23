<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'floor',
        'zone_name',
        'width_px',
        'height_px',
        'description',
        'has_night_version',
        'is_active',
        'pos_x',
        'pos_y',
    ];

    protected function casts(): array
    {
        return [
            'width_px' => 'integer',
            'height_px' => 'integer',
            'has_night_version' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ScreenBooking::class);
    }

    public function resolution(): string
    {
        return "{$this->width_px}x{$this->height_px}";
    }
}
