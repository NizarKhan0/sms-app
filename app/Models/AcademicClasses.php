<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicClasses extends Model
{
    protected $fillable = [
        'name',
        'teacher_id',
    ];

    // untuk 1 teacher boleh 1 class
    // public function teacher(): BelongsTo
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // untuk 1 teacher boleh banyak class
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'academic_class_teacher');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
