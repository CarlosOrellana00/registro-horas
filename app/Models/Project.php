<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    // Campos que se pueden asignar en masa
    protected $fillable = ['name', 'description'];

    // Relaciones
    public function workEntries(): HasMany
    {
        return $this->hasMany(WorkEntry::class);
    }
}
