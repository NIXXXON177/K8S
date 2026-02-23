<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'floor',
        'section',
        'area_sqm',
        'price_per_day',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'area_sqm' => 'decimal:2',
            'price_per_day' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ZoneBooking::class);
    }
}
