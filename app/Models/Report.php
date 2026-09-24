<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    public $timestamps = false;

    protected $table = 'reports';

    protected $fillable = [
        'worker_id',
        'barangay',
        'report_period',
        'report_frequency',
        'diseases',
        'patient_count',
        'prepared_by',
        'attachment_path',
        'attachment_name',
    ];

    protected function casts(): array
    {
        return [
            'diseases' => 'array',
            'submitted_at' => 'datetime',
            'report_period' => 'date',
        ];
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
