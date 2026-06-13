<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'file_path', 'is_active', 'published_at'];
    
    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];
}
