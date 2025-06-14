<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EveningClass extends Model
{
    protected $fillable = ['name', 'category_id', 'teacher_id', 'student_id'];
    // protected $with = ['category', 'teacher'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EveningClassCategory::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

}
