<?php

namespace App\Models;

use app\models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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