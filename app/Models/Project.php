<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected $appends = ['category_slug'];

    public function getCategorySlugAttribute(): string
    {
        return Str::slug($this->category ?? '');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
