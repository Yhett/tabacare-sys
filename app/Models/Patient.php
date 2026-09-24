<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_code',
        'disease',
        'date_onset',
        'address',
        'age',
        'age_unit',
        'gender',
        'added_by',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'date_onset' => 'date',
            'age' => 'integer',
        ];
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
