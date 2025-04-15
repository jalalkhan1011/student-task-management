<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'description', 'original_image_path', 'webp_image_path', 'scheduled_at'];
}
