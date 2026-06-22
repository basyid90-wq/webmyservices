<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number', 'room_id', 'customer_name', 'customer_email', 'customer_phone',
        'check_in', 'check_out', 'guests_adults', 'guests_kids', 'total_nights',
        'subtotal', 'discount', 'total', 'status', 'payment_channel', 'transaction_id', 'paid_at',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'paid_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public static function generateBookingNumber(): string
    {
        $prefix = 'HL-BKG-' . date('ymd');
        $last = static::where('booking_number', 'like', $prefix . '%')->orderBy('booking_number', 'desc')->first();
        if ($last) {
            $seq = (int) substr($last->booking_number, -4) + 1;
        } else {
            $seq = 1;
        }
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
