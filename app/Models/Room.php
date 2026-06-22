<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price_per_night', 'max_guests',
        'image', 'images', 'amenities', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'images' => 'array',
        'amenities' => 'array',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function blockedDates()
    {
        return $this->hasMany(BlockedDate::class);
    }

    public function isAvailable(string $checkIn, string $checkOut): bool
    {
        $nights = [];
        $current = strtotime($checkIn);
        $end = strtotime($checkOut);
        while ($current < $end) {
            $nights[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        $blocked = $this->blockedDates()->whereIn('date', $nights)->exists();
        if ($blocked) return false;

        $overlapping = Booking::where('room_id', $this->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                        $q2->where('check_in', '<=', $checkIn)->where('check_out', '>=', $checkOut);
                    });
            })->exists();

        return !$overlapping;
    }

    public function blockedDateStrings(): array
    {
        return $this->blockedDates()->pluck('date')->map(fn ($d) => $d instanceof \Carbon\Carbon ? $d->format('Y-m-d') : $d)->toArray();
    }

    public function bookedDateStrings(): array
    {
        $dates = [];
        $bookings = $this->bookings()->where('status', '!=', 'cancelled')->get();
        foreach ($bookings as $b) {
            $current = strtotime($b->check_in);
            $end = strtotime($b->check_out);
            while ($current < $end) {
                $dates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
        }
        return array_unique($dates);
    }
}
