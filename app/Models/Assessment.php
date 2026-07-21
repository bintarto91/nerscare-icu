<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Assessment extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'assessment_date',
        'total_score',
        'category',
        'interpretation',
        'nursing_recommendation',
        'family_education_recommendation',
        'notes',
        'follow_up_status',
        'follow_up_notes',
        'follow_up_date',
        'follow_up_by',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function followUpUser()
    {
        return $this->belongsTo(User::class, 'follow_up_by');
    }
}