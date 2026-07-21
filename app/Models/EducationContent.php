<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationContent extends Model
{
    protected $fillable = [
        'title',
        'target',
        'category',
        'content',
        'status',
        'created_by',
    ];
}