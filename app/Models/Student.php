<?php

namespace App\Models;

use App\Models\EveningClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'name',
        'age',
        'diagnosis',
        'reading_skills',
        'writing_skills',
        'school_readiness',
        'motor_skills',
        'behaviour_skills',
        'sensory_issues',
        'communication_skills',
        'other_medical_conditions',
        'tips_and_tricks',
        'is_active',
        'academic_classes_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function eveningClasses()
    {
        return $this->belongsToMany(EveningClass::class);
    }
}
