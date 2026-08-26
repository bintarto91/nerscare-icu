<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookletPage extends Model
{
    protected $fillable = [
        'audience',
        'image_path',
        'alt_text',
        'kicker',
        'title',
        'body',
        'points',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'points' => 'array',
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        return asset(ltrim($this->image_path, '/'));
    }
}
