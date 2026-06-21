<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'name',
        'company_name',
        'email',
        'whatsapp',
        'subject',
        'industry',
        'website_goal',
        'reference_urls',
        'content_status',
        'additional_budget',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'additional_budget' => 'decimal:2',
    ];
}
