<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentInterpretation extends Model
{
    protected $fillable = [
        'category',
        'min_score',
        'max_score',
        'interpretation',
        'nursing_recommendation',
        'family_education_recommendation',
        'is_active',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}