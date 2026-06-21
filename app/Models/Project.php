<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'client_id',
        'category',
        'thumbnail',
        'description',
        'technologies',
        'live_url',
        'completion_date',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_published' => 'boolean',
        'completion_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
