<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model
{
    protected $fillable = [
        'whatsapp',
        'email',
        'address',
        'google_maps_iframe',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
    ];
}
