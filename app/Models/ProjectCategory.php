<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order'];

    public static function options(): array
    {
        return static::orderBy('sort_order')->pluck('name', 'name')->toArray();
    }
}
