<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'description',
        'vision',
        'mission',
        'principal_welcome_name',
        'principal_welcome_title',
        'principal_welcome_text',
        'principal_welcome_photo',
        'history',
        'video_path',
    ];
}
