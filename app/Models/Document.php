<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'doc_type',
        'doc_no',
        'doc_date',
        'due_date',
        'valid_until',
        'status',
        'client_id',
        'bill_to_name',
        'bill_to_email',
        'bill_to_phone',
        'bill_to_address',
        'notes',
        'currency',
        'subtotal',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'grand_total',
        'paid_amount',
        'payment_method',
        'payment_ref',
        'related_doc_id',
    ];

    protected $casts = [
        'doc_date' => 'date',
        'due_date' => 'date',
        'valid_until' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->doc_no)) {
                $document->doc_no = DocumentCounter::generateDocNo($document->doc_type);
            }
        });

        static::saving(function ($document) {
            if ($document->relationLoaded('items')) {
                $document->subtotal = $document->items->sum(function ($item) {
                    return ($item->qty * $item->unit_price) - $item->line_discount;
                });
            }
            $document->tax_amount = $document->subtotal * ($document->tax_percent / 100);
            $document->grand_total = $document->subtotal - $document->discount_amount + $document->tax_amount;
        });
    }

    public function items()
    {
        return $this->hasMany(DocumentItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function relatedDocument()
    {
        return $this->belongsTo(Document::class, 'related_doc_id');
    }

    public function convertTo(string $newType): Document
    {
        $newDoc = $this->replicate();
        $newDoc->doc_type = $newType;
        $newDoc->doc_no = DocumentCounter::generateDocNo($newType);
        $newDoc->related_doc_id = $this->id;
        $newDoc->doc_date = now();
        $newDoc->due_date = in_array($newType, ['INVOICE']) ? now()->addDays(14) : null;
        $newDoc->valid_until = in_array($newType, ['QUOTE']) ? now()->addDays(30) : null;

        if ($newType === 'RECEIPT') {
            $newDoc->status = 'Paid';
            $newDoc->paid_amount = $this->grand_total;
        } else {
            $newDoc->status = 'Draft';
            $newDoc->paid_amount = 0;
        }

        $newDoc->payment_method = null;
        $newDoc->payment_ref = null;
        $newDoc->timestamps = false;
        $newDoc->save();

        foreach ($this->items as $item) {
            $newItem = $item->replicate();
            $newItem->document_id = $newDoc->id;
            $newItem->timestamps = false;
            $newItem->save();
        }

        $newDoc->load('items');
        $newDoc->save();

        return $newDoc->fresh();
    }
}
