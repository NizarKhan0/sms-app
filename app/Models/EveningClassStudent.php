<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EveningClassStudent extends Model
{
    protected $table = 'evening_class_student';

    public function eveningClass()
    {
        return $this->belongsTo(EveningClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}