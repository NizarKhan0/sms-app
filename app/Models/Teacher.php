<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // untuk 1 teacher boleh 1 class
    // public function teacher(): HasMany
    // {
    //     return $this->hasMany(AcademicClasses::class, 'teacher_id');
    // }

    // untuk 1 teacher boleh banyak class
    public function academicClasses()
    {
        return $this->belongsToMany(AcademicClasses::class, 'academic_class_teacher');
    }
}
