<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbSetting extends Model
{
    protected $fillable = [
        'academic_year_id',
        'status',
        'quota',
        'requirements_text',
        'flow_text',
        'fees_text',
        'schedule_text',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
