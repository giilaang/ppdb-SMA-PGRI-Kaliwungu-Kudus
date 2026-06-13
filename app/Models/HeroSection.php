<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSection extends Model
{
    protected $fillable = [
        'academic_year_id',
        'title',
        'subtitle',
        'register_button_text',
        'brochure_button_text',
        'banner_image_1',
        'banner_image_2',
        'banner_image_3',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
