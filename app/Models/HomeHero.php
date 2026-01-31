<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHero extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'background_image',
        'button_text',
        'button_link',
        'is_active'
    ];
}
