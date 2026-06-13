<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Major extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image_path'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($major) {
            if (empty($major->slug)) {
                $major->slug = Str::slug($major->name);
            }
        });
        static::updating(function ($major) {
            if (empty($major->slug)) {
                $major->slug = Str::slug($major->name);
            }
        });
    }

    public function registrants(): HasMany
    {
        return $this->hasMany(Registrant::class, 'selected_major_id');
    }
}
