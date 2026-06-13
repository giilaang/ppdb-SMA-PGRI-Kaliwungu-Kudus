<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    protected $fillable = ['year', 'is_active', 'is_archived'];

    public function heroSection(): HasOne
    {
        return $this->hasOne(HeroSection::class);
    }

    public function ppdbSetting(): HasOne
    {
        return $this->hasOne(PpdbSetting::class);
    }

    public function ppdbWaves(): HasMany
    {
        return $this->hasMany(PpdbWave::class);
    }

    public function brochures(): HasMany
    {
        return $this->hasMany(Brochure::class);
    }

    public function registrants(): HasMany
    {
        return $this->hasMany(Registrant::class);
    }
}
