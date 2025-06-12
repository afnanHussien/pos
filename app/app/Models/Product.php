<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image_path',
        'video_path'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(strip_tags($value));
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(strip_tags($value));
    }
}
