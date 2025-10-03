<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkEntry extends Model
{
    use HasFactory;

    // Campos asignables
    protected $fillable = [
        'user_id',
        'project_id',
        'work_date',
        'hours',
        'description',
    ];

    // Casts (para que 'work_date' sea un objeto Carbon)
    protected $casts = [
        'work_date' => 'date',
    ];

    // Relaciones
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
