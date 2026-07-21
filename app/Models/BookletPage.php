<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookletPage extends Model
{
    protected $fillable = [
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
}
