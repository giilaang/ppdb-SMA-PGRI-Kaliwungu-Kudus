<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registrant extends Model
{
    protected $fillable = [
        'academic_year_id',
        'registration_number',
        'name',
        'nisn',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'address',
        'previous_school',
        'phone_number',
        'parent_name',
        'selected_major_id',
        'document_ijazah',
        'document_akta',
        'document_kk',
        'document_foto',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'selected_major_id');
    }
}
