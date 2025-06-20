<?php

namespace App\Models;

use App\Models\EveningClass;
use App\Models\AcademicClasses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'name',
        'age',
        'diagnosis',
        'reading_skills',
        'writing_skills',
        'numeracy',
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

    // Student.php
    public function academicClass()
    {
        return $this->belongsTo(AcademicClasses::class,'academic_classes_id');
    }

    public function eveningClasses()
    {
        return $this->belongsToMany(EveningClass::class);
    }
}
