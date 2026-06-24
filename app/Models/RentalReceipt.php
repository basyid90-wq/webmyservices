<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RentalReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'customer_name',
        'customer_phone',
        'payment_method',
        'total_amount',
        'deposit_amount',
        'balance_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $receipt) {
            if (empty($receipt->receipt_number)) {
                $receipt->receipt_number = static::generateNumber();
            }
        });

        static::saving(function (self $receipt) {
            $receipt->total_amount = $receipt->items->sum('total_price');
            $receipt->balance_amount = max(0, $receipt->total_amount - $receipt->deposit_amount);
        });
    }

    public static function generateNumber(): string
    {
        $prefix = 'BARAKAH-' . now()->format('Ym');
        $last = DB::table('rental_receipts')
            ->where('receipt_number', 'like', $prefix . '%')
            ->orderBy('receipt_number', 'desc')
            ->lockForUpdate()
            ->value('receipt_number');

        $next = $last ? (int) substr($last, -3) + 1 : 1;
        return $prefix . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->hasMany(RentalReceiptItem::class);
    }
}
