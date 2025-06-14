<?php

namespace App\Models;

use App\Models\EveningClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EveningClassCategory extends Model
{
    protected $fillable = ['name'];

    public function eveningClasses(): HasMany
    {
        return $this->hasMany(EveningClass::class);
    }
}
