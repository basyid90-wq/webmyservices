<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_receipt_id',
        'category',
        'model_unit',
        'quantity',
        'start_date',
        'end_date',
        'duration_days',
        'price_per_day',
        'price_type',
        'total_price',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'quantity' => 'integer',
        'duration_days' => 'integer',
        'price_per_day' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function receipt()
    {
        return $this->belongsTo(RentalReceipt::class, 'rental_receipt_id');
    }
}
