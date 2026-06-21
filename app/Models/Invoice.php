<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'client_id',
        'project_id',
        'issue_date',
        'due_date',
        'status',
        'tax_rate',
        'discount',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = 'INV-' . date('Y') . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
                $invoice->saveQuietly();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->subtotal;
        });
    }

    public function getTaxAmountAttribute()
    {
        return $this->subtotal * $this->tax_rate / 100;
    }

    public function getTotalAttribute()
    {
        return $this->subtotal + $this->tax_amount - $this->discount;
    }

    public static function generateInvoiceNumber(): string
    {
        $last = static::latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;

        return 'INV-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
