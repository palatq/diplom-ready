<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Carousel extends Model
{
    protected $fillable = [
        'image_path',
        'order',
        'is_active',
        'title',
        'description',
        'link'
    ];

    protected $attributes = [
        'order' => 0,
        'is_active' => true
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image_path);
    }
}