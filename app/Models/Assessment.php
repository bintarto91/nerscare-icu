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
        'administration_mode',
        'total_score',
        'missing_item_count',
        'emotional_score',
        'emotional_score_valid',
        'social_score',
        'social_score_valid',
        'category',
        'decision_code',
        'decision_profile',
        'interpretation',
        'nursing_recommendation',
        'family_education_recommendation',
        'clinical_decision_note',
        'personalization_triggers',
        'safety_alert',
        'safety_alert_details',
        'safety_alert_notes',
        'notes',
        'follow_up_status',
        'follow_up_notes',
        'follow_up_date',
        'follow_up_by',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'follow_up_date' => 'date',
        'missing_item_count' => 'integer',
        'emotional_score_valid' => 'boolean',
        'social_score_valid' => 'boolean',
        'personalization_triggers' => 'array',
        'safety_alert' => 'boolean',
        'safety_alert_details' => 'array',
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
